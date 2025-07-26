<?php
session_start(); // Start the session to access user ID

// Set content type for JSON response
header('Content-Type: application/json');

// --- Database Configuration ---
// IMPORTANT: Replace with your actual database credentials
define('DB_HOST', 'localhost'); // <--- CHANGE THIS LINE
define('DB_NAME', 'zayno'); // <--- CHANGE THIS LINE
define('DB_USER', 'root');       // <--- CHANGE THIS LINE
define('DB_PASS', '');   // <--- CHANGE THIS LINE

/**
 * Establishes a PDO database connection.
 * @return PDO|null Returns a PDO object on success, null on failure.
 */
function getDbConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,     // Fetch results as associative arrays
            PDO::ATTR_EMULATE_PREPARES   => false,                 // Disable emulation for better security/performance
        ];
        return new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        // Log the error (e.g., to a file, not to stdout in production)
        error_log("Database connection failed: " . $e->getMessage());
        return null; // Return null if connection fails
    }
}

// --- User Authentication Simulation ---
// In a real application, the user_id would be securely set upon successful login.
// For demonstration, we'll set a dummy user_id if not already set.
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1; // Dummy user ID for testing
    // In production, if $_SESSION['user_id'] is not set, you should redirect to login.
    // echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    // exit();
}
$userId = $_SESSION['user_id'];

// Get the action and data from the request
$input = json_decode(file_get_contents('php://input'), true);

// If JSON input is not available, try to get action from POST data
if (empty($input) && isset($_POST['action'])) {
    $action = $_POST['action'];
    $data = $_POST;
} else if (isset($input['action'])) {
    $action = $input['action'];
    $data = $input;
} else {
    echo json_encode(['success' => false, 'message' => 'No action specified.']);
    exit();
}

$pdo = getDbConnection(); // Get the database connection
if (!$pdo) {
    echo json_encode(['success' => false, 'message' => 'Database connection error.']);
    exit();
}

try {
    switch ($action) {
        case 'fetch_all':
            $stmt = $pdo->prepare("SELECT * FROM user_addresses WHERE user_id = :user_id ORDER BY is_default DESC, created_at DESC");
            $stmt->execute([':user_id' => $userId]);
            $addresses = $stmt->fetchAll();
            echo json_encode(['success' => true, 'addresses' => $addresses]);
            break;

        case 'fetch_single':
            $addressId = $data['id'] ?? null;
            if (!$addressId) {
                echo json_encode(['success' => false, 'message' => 'Address ID missing.']);
                break;
            }
            $stmt = $pdo->prepare("SELECT * FROM user_addresses WHERE id = :id AND user_id = :user_id");
            $stmt->execute([':id' => $addressId, ':user_id' => $userId]);
            $address = $stmt->fetch();
            if ($address) {
                echo json_encode(['success' => true, 'address' => $address]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Address not found or unauthorized.']);
            }
            break;

        case 'add_address':
            $isDefault = isset($data['is_default']) && $data['is_default'] === true;

            // If new address is set as default, update all others for this user to not be default
            if ($isDefault) {
                $stmt = $pdo->prepare("UPDATE user_addresses SET is_default = FALSE WHERE user_id = :user_id");
                $stmt->execute([':user_id' => $userId]);
            }

            $stmt = $pdo->prepare(
                "INSERT INTO user_addresses (user_id, full_name, street_address, city, zip_code, country, phone_number, is_default)
                 VALUES (:user_id, :full_name, :street_address, :city, :zip_code, :country, :phone_number, :is_default)"
            );
            $stmt->execute([
                ':user_id' => $userId,
                ':full_name' => $data['name'] ?? '',
                ':street_address' => $data['street'] ?? '',
                ':city' => $data['city'] ?? '',
                ':zip_code' => $data['zip'] ?? '',
                ':country' => $data['country'] ?? '',
                ':phone_number' => $data['phone'] ?? '',
                ':is_default' => $isDefault
            ]);
            echo json_encode(['success' => true, 'message' => 'Address added successfully!']);
            break;

        case 'update_address':
            $addressId = $data['id'] ?? null;
            if (!$addressId) {
                echo json_encode(['success' => false, 'message' => 'Address ID missing for update.']);
                break;
            }
            $isDefault = isset($data['is_default']) && $data['is_default'] === true;

            // If updated address is set as default, update all others for this user to not be default
            if ($isDefault) {
                $stmt = $pdo->prepare("UPDATE user_addresses SET is_default = FALSE WHERE user_id = :user_id");
                $stmt->execute([':user_id' => $userId]);
            }

            $stmt = $pdo->prepare(
                "UPDATE user_addresses SET
                    full_name = :full_name,
                    street_address = :street_address,
                    city = :city,
                    zip_code = :zip_code,
                    country = :country,
                    phone_number = :phone_number,
                    is_default = :is_default
                 WHERE id = :id AND user_id = :user_id"
            );
            $stmt->execute([
                ':full_name' => $data['name'] ?? '',
                ':street_address' => $data['street'] ?? '',
                ':city' => $data['city'] ?? '',
                ':zip_code' => $data['zip'] ?? '',
                ':country' => $data['country'] ?? '',
                ':phone_number' => $data['phone'] ?? '',
                ':is_default' => $isDefault,
                ':id' => $addressId,
                ':user_id' => $userId
            ]);

            if ($stmt->rowCount() > 0) {
                echo json_encode(['success' => true, 'message' => 'Address updated successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Address not found or no changes made.']);
            }
            break;

        case 'delete_address':
            $addressId = $data['id'] ?? null;
            if (!$addressId) {
                echo json_encode(['success' => false, 'message' => 'Address ID missing for deletion.']);
                break;
            }

            // Check if this address is the default one before deleting
            $stmt = $pdo->prepare("SELECT is_default FROM user_addresses WHERE id = :id AND user_id = :user_id");
            $stmt->execute([':id' => $addressId, ':user_id' => $userId]);
            $isDefaultToDelete = $stmt->fetchColumn();

            $stmt = $pdo->prepare("DELETE FROM user_addresses WHERE id = :id AND user_id = :user_id");
            $stmt->execute([':id' => $addressId, ':user_id' => $userId]);

            if ($stmt->rowCount() > 0) {
                // If the deleted address was the default, and there are other addresses,
                // set a new default (e.g., the oldest remaining address)
                if ($isDefaultToDelete) {
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM user_addresses WHERE user_id = :user_id");
                    $stmt->execute([':user_id' => $userId]);
                    if ($stmt->fetchColumn() > 0) {
                        $stmt = $pdo->prepare("UPDATE user_addresses SET is_default = TRUE WHERE user_id = :user_id ORDER BY created_at ASC LIMIT 1");
                        $stmt->execute([':user_id' => $userId]);
                    }
                }
                echo json_encode(['success' => true, 'message' => 'Address deleted successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Address not found or unauthorized for deletion.']);
            }
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action.']);
            break;
    }
} catch (PDOException $e) {
    error_log("Database operation error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'A database error occurred.']);
}
