<?php
session_start();

// Check if the admin is logged in (re-using the logic from AdminHome.php)
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: AdminLogin.html");
    exit();
}

include 'db.php'; // <<< CHANGED: Now using your db.php for database connection

$message = ""; // To store success/error messages

// --- Handle Add User ---
if (isset($_POST['add_user'])) {
    $username = $conn->real_escape_string($_POST['new_username']);
    $email = $conn->real_escape_string($_POST['new_email']);
    $password = $_POST['new_password']; // Raw password for hashing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password

    if (empty($username) || empty($email) || empty($password)) {
        $message = "<div class='alert error'>Please fill all fields for adding a user.</div>";
    } else {
        // Check if username or email already exists
        $check_stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $check_stmt->bind_param("ss", $username, $email);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $message = "<div class='alert error'>Username or Email already exists.</div>";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                $message = "<div class='alert success'>User added successfully!</div>";
            } else {
                $message = "<div class='alert error'>Error adding user: " . $stmt->error . "</div>";
            }
            $stmt->close();
        }
        $check_stmt->close();
    }
}

// --- Handle Edit User ---
if (isset($_POST['edit_user'])) {
    $id = (int)$_POST['edit_id'];
    $username = $conn->real_escape_string($_POST['edit_username']);
    $email = $conn->real_escape_string($_POST['edit_email']);
    $password_field = $_POST['edit_password']; // This might be empty if password is not changed

    if (empty($username) || empty($email)) {
        $message = "<div class='alert error'>Please fill username and email for editing.</div>";
    } else {
        $update_password_sql = "";
        $bind_types = "ssi";
        $bind_params = [&$username, &$email, &$id];

        if (!empty($password_field)) {
            $hashed_password = password_hash($password_field, PASSWORD_DEFAULT);
            $update_password_sql = ", password = ?";
            $bind_types = "sssi"; // Add 's' for password
            array_splice($bind_params, 2, 0, [$hashed_password]); // Insert hashed password before $id
        }

        // Check if username or email already exists for *other* users
        $check_stmt = $conn->prepare("SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?");
        $check_stmt->bind_param("ssi", $username, $email, $id);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $message = "<div class='alert error'>Username or Email already exists for another user.</div>";
        } else {
            $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?{$update_password_sql} WHERE id = ?");
            // Use call_user_func_array to bind parameters dynamically
            call_user_func_array([$stmt, 'bind_param'], array_merge([$bind_types], $bind_params));

            if ($stmt->execute()) {
                $message = "<div class='alert success'>User updated successfully!</div>";
            } else {
                $message = "<div class='alert error'>Error updating user: " . $stmt->error . "</div>";
            }
            $stmt->close();
        }
        $check_stmt->close();
    }
}


// --- Handle Delete User ---
if (isset($_POST['delete_user'])) {
    $id = (int)$_POST['delete_id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $message = "<div class='alert success'>User deleted successfully!</div>";
    } else {
        $message = "<div class='alert error'>Error deleting user: " . $stmt->error . "</div>";
    }
    $stmt->close();
}

// --- Fetch Users for Display ---
$users = [];
$result = $conn->query("SELECT id, username, email, created_at FROM users ORDER BY created_at DESC"); // Do NOT select password here!
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users | Admin Panel</title>
    <link rel="stylesheet" href="AdminHome.css"> <style>
        /* Specific CSS for this page */

        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f6f8;
    margin: 0;
    padding: 0;
    color: #333;
}

.dashboard-container {
    display: flex;
    min-height: 100vh;
}

.dashboard-header {
    background-color: #fff;
    color: #333;
    padding: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    position: fixed;
    top: 0;
    z-index: 100;
}

.logo {
    font-size: 1.5em;
    font-weight: bold;
}

.logo-icon {
    margin-right: 8px;
    color: #007bff;
}

.user-info {
    display: flex;
    align-items: center;
    margin-right: 45px;
}

.username {
    margin-right: 35px;
    font-weight: bold;
}

.logout-button {
    background-color: #dc3545;
    color: white;
    padding: 8px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
    font-size: 0.9em;
}

.logout-button:hover {
    background-color: #c82333;
}

.dashboard-nav {
    background-color: #343a40;
    color: #fff;
    width: 300px;
    padding-top: 80px; /* Adjust for fixed header */
    height: 100vh;
    position: fixed;
    left: 0;
    overflow-y: auto;
}
        
.dashboard-nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.dashboard-nav li a {
    display: block;
    padding: 15px 20px;
    text-decoration: none;
    color: #f8f9fa;
    transition: background-color 0.3s ease;
    border-left: 5px solid transparent;
}

.dashboard-nav li a i {
    margin-right: 10px;
}

.dashboard-nav li a:hover {
    background-color: #495057;
    border-left-color: #007bff;
}
.dashboard-content {
    flex-grow: 1;
    padding: 20px;
    padding-top: 100px; /* Adjust for fixed header */
    margin-left: 400px; /* Adjust for sidebar width */
}

        .user-management-container {
            padding: 20px;
        }

        .user-management-container h2 {
            margin-bottom: 20px;
            color: #333;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            background-color: #fff;
        }

        .user-table th, .user-table td {
            border: 1px solid #ddd;
            padding: 12px 15px;
            text-align: left;
        }

        .user-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #555;
        }

        .user-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .user-table tr:hover {
            background-color: #f1f1f1;
        }

        .action-buttons button {
            background-color:#343a40;
            width: 60px;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9em;
            margin-right: 5px;
            transition: background-color 0.3s ease;
        }

        .action-buttons button:hover {
            background-color: #0056b3;
        }

        .action-buttons .delete-btn {
            background-color: #dc3545;
        }

        .action-buttons .delete-btn:hover {
            background-color: #c82333;
        }

        /* Forms for Add/Edit */
        .form-section {
            background-color: #fff;
            padding: 25px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .form-section h3 {
            margin-top: 0;
            color: #007bff;
            margin-bottom: 20px;
        }

        .form-section label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .form-section input[type="text"],
        .form-section input[type="email"],
        .form-section input[type="password"] {
            width: calc(100% - 22px); /* Account for padding and border */
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
        }

        .form-section button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .form-section button:hover {
            background-color: #218838;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-weight: bold;
        }

        .alert.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1000; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; /* 5% from the top and centered */
            padding: 30px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            position: relative;
        }

        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 20px;
        }

        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-content h3 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #007bff;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .modal-content label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .modal-content input[type="text"],
        .modal-content input[type="email"],
        .modal-content input[type="password"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
        }

        .modal-content button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .modal-content button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <div class="logo">
                <span class="logo-icon">⚙️</span> Admin Panel
            </div>
            <div class="user-info">
                <span class="username" id="admin-username">Admin User</span>
                <a href="AdminLogout.php" class="logout-button">Logout</a>
            </div>
        </header>

        <nav class="dashboard-nav">
            <ul>
                <li class="nav-item">
                    <a href="AdminHome.html"><i class="fas fa-tags"></i> Manage Branded Products</a>
                </li>
                <li class="nav-item">
                    <a href="AdminHome.html"><i class="fas fa-list-alt"></i> Manage Product Categories</a>
                </li>
                <li class="nav-item">
                    <a href="AdminHome.html"><i class="fas fa-percent"></i> Manage Discounted Products</a>
                </li>
                <li class="nav-item">
                    <a href="AdminHome.html"><i class="fas fa-comments"></i> Manage Conversations</a>
                </li>
                <li class="nav-item active"> <a href="AdminManageUsers.php"><i class="fas fa-users"></i> Manage Users</a>
                </li>
                <li class="nav-item">
                    <a href="AdminHome.html"><i class="fas fa-shopping-cart"></i> View Orders</a>
                </li>
            </ul>
        </nav>

        <main class="dashboard-content">
            <div class="user-management-container">
                <h2><i class="fas fa-users"></i> Manage User Accounts</h2>

                <?php echo $message; // Display success/error messages ?>

                <div class="form-section">
                    <h3>Add New User</h3>
                    <form action="AdminManageUsers.php" method="POST">
                        <label for="new_username">Username:</label>
                        <input type="text" id="new_username" name="new_username" required>

                        <label for="new_email">Email:</label>
                        <input type="email" id="new_email" name="new_email" required>

                        <label for="new_password">Password:</label>
                        <input type="password" id="new_password" name="new_password" required>

                        <button type="submit" name="add_user">Add User</button>
                    </form>
                </div>

                <h3>Existing Users</h3>
                <?php if (empty($users)): ?>
                    <p>No users found in the database.</p>
                <?php else: ?>
                    <table class="user-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                                    <td class="action-buttons">
                                        <button class="edit-btn"
                                                data-id="<?php echo $user['id']; ?>"
                                                data-username="<?php echo htmlspecialchars($user['username']); ?>"
                                                data-email="<?php echo htmlspecialchars($user['email']); ?>">
                                            Edit
                                        </button>
                                        <form action="AdminManageUsers.php" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            <input type="hidden" name="delete_id" value="<?php echo $user['id']; ?>">
                                            <button type="submit" name="delete_user" class="delete-btn">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </main>

        <footer class="dashboard-footer">
            &copy; <?php echo date("Y"); ?> Your Online Store. All rights reserved.
        </footer>
    </div>

    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h3>Edit User</h3>
            <form action="AdminManageUsers.php" method="POST">
                <input type="hidden" id="edit_id" name="edit_id">

                <label for="edit_username_modal">Username:</label>
                <input type="text" id="edit_username_modal" name="edit_username" required>

                <label for="edit_email_modal">Email:</label>
                <input type="email" id="edit_email_modal" name="edit_email" required>

                <label for="edit_password_modal">New Password (leave blank to keep current):</label>
                <input type="password" id="edit_password_modal" name="edit_password">

                <button type="submit" name="edit_user">Update User</button>
            </form>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/your_fontawesome_kit_id.js" crossorigin="anonymous"></script>
    <script src="AdminHome.js"></script> <script>
        // JavaScript for modal functionality
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.edit-btn');
            const modal = document.getElementById('editUserModal');
            const closeButton = document.querySelector('.close-button');
            const editIdField = document.getElementById('edit_id');
            const editUsernameField = document.getElementById('edit_username_modal');
            const editEmailField = document.getElementById('edit_email_modal');
            const editPasswordField = document.getElementById('edit_password_modal');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const username = this.getAttribute('data-username');
                    const email = this.getAttribute('data-email');

                    editIdField.value = id;
                    editUsernameField.value = username;
                    editEmailField.value = email;
                    editPasswordField.value = ''; // Clear password field for security

                    modal.style.display = 'block'; // Show the modal
                });
            });

            closeButton.addEventListener('click', function() {
                modal.style.display = 'none'; // Hide the modal
            });

            window.addEventListener('click', function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none'; // Hide modal if clicked outside
                }
            });
        });
    </script>
</body>
</html>