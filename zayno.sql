-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2025 at 04:36 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zayno`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `all_products`
--

CREATE TABLE `all_products` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `in_stock` tinyint(1) DEFAULT 1,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `all_products`
--

INSERT INTO `all_products` (`id`, `brand`, `product_name`, `price`, `image_url`, `size`, `color`, `in_stock`, `description`) VALUES
(1, 'Modano', 'Elegant Casual Shirt', 3500.00, 'images/Hustle/1_1.webp', 'S,M,L', 'white,blue', 1, 'An elegant shirt for casual occasions.'),
(2, 'Modano', 'Premium Denim Jeans', 5200.00, 'images/Hustle/1_1.webp', '30,32,34', 'dark_blue', 1, 'High-quality denim jeans.'),
(3, 'Hustle', 'Active Wear T-Shirt', 1950.00, 'images/Hustle/1_1.webp', 'M,L,XL', 'black,grey', 1, 'Comfortable and breathable active wear t-shirt.'),
(4, 'Hustle', 'Jogger Pants', 2800.00, 'C:\\\\\\\\\\\\\\\\xampp\\\\\\\\\\\\\\\\htdocs\\\\\\\\\\\\\\\\ZAYNO\\\\\\\\\\\\\\\\images\\\\\\\\\\\\\\\\Hustle\\\\\\\\\\\\\\\\1_1.webp', '0', 'navy', 1, '0'),
(5, 'King Street', 'Urban Style Hoodie', 4500.00, 'images/Hustle/1_1.webp', 'S,M,L,XL', 'black', 1, 'Modern urban style hoodie.'),
(6, 'Envogue', 'Chic Summer Dress', 6000.00, 'images/Hustle/1_1.webp', 'XS,S,M', 'floral', 1, 'A light and chic summer dress.'),
(7, 'Hada', 'Traditional Kurta', 2500.00, 'images/Hustle/1_1.webp', 'M,L', 'beige,maroon', 1, 'A traditional design kurta.'),
(8, 'MUN', 'Minimalist Watch', 8000.00, 'images/Hustle/1_1.webp', 'OS', 'silver', 1, 'Sleek and minimalist design watch.'),
(9, 'Curvy Clothing', 'Plus Size Blouse', 3800.00, 'C:\\\\\\\\\\\\\\\\xampp\\\\\\\\\\\\\\\\htdocs\\\\\\\\\\\\\\\\ZAYNO\\\\\\\\\\\\\\\\images/Hustle/1_1.webp', '0', 'pink', 10, '0'),
(10, 'Bigg Boss', 'Executive Formal Shirt', 4900.00, 'C:\\\\xampp\\\\htdocs\\\\ZAYNO\\\\images\\\\Hustle\\\\1_1.webp', 'L,XL', 'white', 0, 'A crisp formal shirt for executives.'),
(11, 'Modano', 'Jogger Pants', 2800.00, 'C:\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\xampp\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\htdocs\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ZAYNO\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\images\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\Hustle\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\1_1.webp', '0', 'navy', 1, '0'),
(12, 'Modano', 'Jogger Pants', 500.00, 'C:\\\\xampp\\\\htdocs\\\\ZAYNO\\\\images\\\\Hustle\\\\1_1.webp', 'S,M,L,XL', 'navy', 1, 'dfesdfe'),
(13, 'Hustle', 'Jogger Pants', 2000.00, 'C:\\\\xampp\\\\htdocs\\\\ZAYNO\\\\images\\\\Hustle\\\\1_1.webp', '1', 'black,White', 1, 'rgfg');

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `brand_name`, `product_name`, `description`, `price`, `size`, `image_url`) VALUES
(1, 'Hustle', 'Sporty T-Shirt', 'A comfortable and breathable t-shirt for your workouts.', 25.99, 'S,M,L,XL', 'images/Hustle/1_1.webp'),
(2, 'Modano', 'Elegant Dress', 'A beautiful dress perfect for evening events.', 79.99, 'XS,S,M', 'images/Modano/1_1.webp'),
(3, 'King Street', 'Classic Jeans', 'Durable denim jeans with a timeless design.', 55.00, '28,30,32,34,36', 'images/King Street/1_1.webp'),
(4, 'Envogue', 'Summer Blouse', 'Lightweight and stylish blouse for summer days.', 35.50, 'S,M,L', 'images/Envogue/1_1.webp'),
(5, 'Hada', 'Casual Sneakers', 'Comfortable sneakers for everyday wear.', 49.99, 'US7,US8,US9,US10', 'images/Hada/1_1.webp'),
(6, 'MUN', 'Luxury Watch', 'Sophisticated timepiece with a leather strap.', 199.00, 'One Size', 'images/MUN/1_1.webp'),
(7, 'Curvy clothing', 'Plus Size Leggings', 'Comfortable and flexible leggings for all body types.', 30.00, '1XL,2XL,3XL', 'images/Curvy Clothing/1_1.webp'),
(8, 'Bigg Boss', 'Men\'s Polo Shirt', 'Classic fit polo shirt with breathable fabric.', 42.00, 'M,L,XL,XXL', 'images/Bigg Boss/1_1.webp'),
(9, 'Hustle', 'Running Shorts', 'Lightweight shorts for intense running sessions.', 30.00, 'S,M,L', 'images/Hustle/1_1.webp'),
(10, 'Modano', 'Leather Handbag', 'Stylish and durable leather handbag with multiple compartments.', 120.00, 'One Size', 'images/Modano/1_1.webp');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`) VALUES
(8, 'BIGG BOSS'),
(7, 'Curvy Clothing'),
(4, 'Envogue'),
(5, 'Hada'),
(1, 'Hustle'),
(3, 'King Street'),
(2, 'Modano'),
(6, 'MUN');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image_url`, `display_order`) VALUES
(1, 'Women', 'womens_cloths', 'images/Ladies cloths/l1.png', 10),
(2, 'Men', 'mens_cloths', 'images/Mens cloths/m1.png', 20),
(3, 'Kids', 'kids_cloths', 'images/childrens cloths/k1.png', 30),
(4, 'Shoes', 'Shoes', 'images/Shoes/s1.png', 40),
(5, 'Toys', 'Toys', 'images/Toys/OIP.jpeg', 50),
(6, 'Bags', 'Bags', 'images/Bags/b1.png', 60);

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `conversation_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `guest_name` varchar(255) DEFAULT NULL,
  `status` enum('open','closed','pending') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `closed_at` datetime DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`conversation_id`, `user_id`, `guest_name`, `status`, `created_at`, `closed_at`, `admin_id`) VALUES
(1, NULL, 'Guest User 568', 'closed', '2025-06-08 11:16:17', '2025-06-08 11:40:13', NULL),
(2, NULL, 'Guest User 963', 'closed', '2025-06-08 11:20:30', '2025-06-08 11:41:19', NULL),
(3, NULL, 'Guest User 852', 'closed', '2025-06-08 11:32:06', '2025-06-08 11:33:49', NULL),
(4, NULL, 'Guest User 406', 'closed', '2025-06-08 11:42:09', '2025-06-21 19:06:41', NULL),
(5, NULL, 'Guest User 430', 'open', '2025-06-08 11:47:25', NULL, NULL),
(6, NULL, 'Guest User 434', 'open', '2025-06-08 11:47:46', NULL, NULL),
(7, NULL, 'Guest User 747', 'closed', '2025-06-08 11:48:21', '2025-06-26 20:37:45', NULL),
(8, NULL, 'Guest User 524', 'closed', '2025-06-08 11:48:22', '2025-06-26 20:37:39', NULL),
(9, NULL, 'Guest User 551', 'closed', '2025-06-08 11:48:23', '2025-06-26 20:37:33', NULL),
(10, NULL, 'Guest User 71', 'closed', '2025-06-08 11:52:00', '2025-06-26 20:37:27', NULL),
(11, NULL, 'Guest User 760', 'open', '2025-06-08 13:53:54', NULL, NULL),
(12, NULL, 'Guest User 28', 'closed', '2025-06-08 13:54:05', '2025-06-26 20:37:13', NULL),
(13, NULL, 'Guest User 545', 'closed', '2025-06-08 14:25:08', '2025-06-26 20:37:07', NULL),
(14, NULL, 'Guest User 181', 'closed', '2025-06-08 14:25:10', '2025-06-26 20:36:56', NULL),
(15, NULL, 'Guest User 351', 'closed', '2025-06-13 02:45:35', '2025-06-26 20:37:01', NULL),
(16, NULL, 'Guest User 165', 'closed', '2025-06-15 01:19:02', '2025-06-26 20:36:50', NULL),
(17, NULL, 'Anonymous', 'closed', '2025-06-15 01:30:24', '2025-06-26 20:36:43', NULL),
(18, NULL, 'Guest User 650', 'closed', '2025-06-19 21:59:16', '2025-06-26 20:36:38', NULL),
(19, NULL, 'Guest User 772', 'closed', '2025-06-21 17:01:07', '2025-06-26 20:36:29', NULL),
(20, NULL, 'Guest User 627', 'closed', '2025-06-21 19:50:01', '2025-06-26 20:36:24', NULL),
(21, NULL, 'Guest User 985', 'closed', '2025-06-21 19:50:03', '2025-06-26 20:36:17', NULL),
(22, NULL, 'Guest User 965', 'closed', '2025-06-21 19:57:55', '2025-06-26 20:36:12', NULL),
(23, NULL, 'Guest User 364', 'closed', '2025-06-22 20:25:00', '2025-06-26 20:36:06', NULL),
(24, NULL, 'Guest User 112', 'closed', '2025-06-22 23:32:40', '2025-06-26 20:36:00', NULL),
(25, NULL, 'Guest User 886', 'closed', '2025-06-23 09:54:04', '2025-06-26 20:35:53', NULL),
(26, NULL, 'Guest User 466', 'closed', '2025-06-23 14:44:58', '2025-06-26 20:35:47', NULL),
(27, NULL, 'Guest User 154', 'closed', '2025-06-23 14:46:31', '2025-06-26 20:35:34', NULL),
(28, NULL, 'Guest User 688', 'closed', '2025-06-26 13:04:21', '2025-06-26 20:35:28', NULL),
(29, NULL, 'Guest User 291', 'closed', '2025-06-26 13:05:26', '2025-06-26 20:35:21', NULL),
(30, NULL, 'Guest User 91', 'closed', '2025-06-26 13:05:57', '2025-06-26 20:35:40', NULL),
(31, NULL, 'Guest User 948', 'open', '2025-06-26 20:41:41', NULL, NULL),
(32, NULL, 'Guest User 898', 'open', '2025-06-26 20:42:28', NULL, NULL),
(33, NULL, 'Guest User 693', 'open', '2025-06-26 20:42:43', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `firstbanner`
--

CREATE TABLE `firstbanner` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `available_colors` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`available_colors`)),
  `available_sizes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`available_sizes`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `firstbanner`
--

INSERT INTO `firstbanner` (`id`, `product_name`, `description`, `price`, `image_url`, `stock_quantity`, `created_at`, `available_colors`, `available_sizes`) VALUES
(2, 'Classic Lavender Gown', 'A graceful lavender full-length gown with a simple yet elegant design. Ideal for formal events.', 129.50, 'images/AllBrands/Hustle/2_1.webp', 30, '2025-06-15 11:57:05', '[\"Lavender\",\"Purple\",\"White\"]', '[\"M\",\"L\",\"XL\"]'),
(3, 'Luxurious Black Gown', 'A stunning black floor-length gown with intricate detailing, designed for a sophisticated look.', 199.00, 'images/b3.png', 20, '2025-06-15 11:57:05', '[\"Black\", \"Blue\", \"Grey\"]', '[\"S\", \"M\", \"L\", \"XL\", \"XXL\"]'),
(4, 'Jogger Pants', 'dfdgfggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg', 3000.00, 'images/b4.webp', 10, '2025-06-15 12:12:29', '[\"Red\",\"Yellow\"]', '[\"M\",\"L\",\"XL\"]'),
(5, 'Jogger Pants', 'gghfvgh', 1000.00, 'images/1_1.webp', 10, '2025-06-15 12:14:31', NULL, NULL),
(6, 'Jogger Pants', 'gghfvgh', 1000.00, 'images/1_1.webp', 10, '2025-06-15 16:27:05', '[\"\"]', NULL),
(7, 'Jogger Pants', 'vbnbvn', 1000.00, 'images/1_1.webp', 10, '2025-06-15 16:29:34', '[\"Red\",\"Yellow\"]', NULL),
(8, 'Jogger Pants', 'vbnbvn', 1000.00, 'images/1_1.webp', 10, '2025-06-15 16:30:35', '[\"Red\",\"Yellow\"]', NULL),
(9, 'Jogger Pants', 'vbnbvn', 1000.00, 'images/1_1.webp', 10, '2025-06-15 16:32:09', '[\"Red\",\"Yellow\"]', NULL),
(10, 'Jogger Pants', 'vbnbvn', 1000.00, 'images/1_1.webp', 10, '2025-06-15 16:34:07', '[\"Red\",\"Yellow\"]', NULL),
(11, 'Jogger Pants', 'vbnbvn', 1000.00, 'images/1_1.webp', 10, '2025-06-15 16:34:47', '[\"Red\",\"Yellow\"]', NULL),
(12, 'Jogger Pants', 'vbnbvn', 1000.00, 'images/1_1.webp', 10, '2025-06-15 16:36:16', '[\"Red\",\"Yellow\"]', NULL),
(13, 'Jogger Pants', 'vbnbvn', 1000.00, 'images/1_1.webp', 10, '2025-06-15 16:36:51', '[\"Red\",\"Yellow\"]', NULL),
(14, 'Jogger Pants', 'ghjg', 1000.00, 'images/1_1.webp', 10, '2025-06-15 17:15:59', '[\"Red\",\"Yellow\"]', '[\"S\",\"L\",\"XL\"]'),
(15, 'Hustle Regular Fit Casual T-Shirt', 'fghv', 3000.00, 'images/1_2.webp', 10, '2025-06-15 17:27:20', '[\"Red\",\"\"]', '[\"S\",\"L\",\"XL\"]'),
(16, 'Hustle Regular Fit Casual T-Shirt', 'fghv', 3000.00, 'images/1_2.webp', 10, '2025-06-15 17:27:40', '[\"Red\",\"\"]', '[\"S\",\"L\",\"XL\"]'),
(17, 'Hustle Regular Fit Casual T-Shirt', 'fgjfnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn', 2000.00, 'images/Hustle/1_5.jpg', 0, '2025-06-16 06:19:59', '[\"Red\",\"\"]', '[\"S\",\"L\",\"XL\"]');

-- --------------------------------------------------------

--
-- Table structure for table `home_products`
--

CREATE TABLE `home_products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `discount_percentage` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `home_products`
--

INSERT INTO `home_products` (`id`, `name`, `description`, `price`, `image_url`, `stock`, `discount_percentage`, `created_at`, `updated_at`) VALUES
(1, 'Cozy Knit Sweater', 'A soft and warm knit sweater, perfect for chilly evenings. Made from a blend of wool and acrylic for comfort and durability.', 39.99, 'images/Ladies cloths/1.webp', 75, 10, '2025-06-22 12:45:33', '2025-06-22 12:45:33'),
(2, 'Classic Denim Jeans', 'High-waisted, slim-fit denim jeans with a timeless design. Durable and comfortable for everyday wear.', 59.99, 'images/Ladies cloths/2.webp', 120, 0, '2025-06-22 12:45:33', '2025-06-22 12:45:33'),
(3, 'Elegant Silk Scarf', 'A luxurious silk scarf with a delicate floral pattern. Adds a touch of elegance to any outfit.', 24.50, 'images/Ladies cloths/3.webp', 40, 5, '2025-06-22 12:45:33', '2025-06-22 12:45:33'),
(4, 'Sporty Hoodie', 'A comfortable and stylish hoodie with a front pocket. Ideal for workouts or casual wear.', 34.00, 'images/Ladies cloths/4.webp', 90, 15, '2025-06-22 12:45:33', '2025-06-22 12:45:33'),
(5, 'Summer Floral Dress', 'Lightweight and breathable floral dress, perfect for summer days. Features adjustable straps and a flowing skirt.', 45.00, 'images/Ladies cloths/5.webp', 60, 20, '2025-06-22 12:45:33', '2025-06-22 12:45:33'),
(6, 'Men\'s Casual Shirt', 'A comfortable long-sleeve cotton shirt for men, suitable for various casual occasions. Available in multiple colors.', 29.00, 'images/Ladies cloths/6.webp', 85, 0, '2025-06-22 12:45:33', '2025-06-22 12:45:33');

-- --------------------------------------------------------

--
-- Table structure for table `ladies`
--

CREATE TABLE `ladies` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `product_type` varchar(100) DEFAULT NULL,
  `size_options` varchar(255) DEFAULT NULL,
  `color_options` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ladies`
--

INSERT INTO `ladies` (`product_id`, `name`, `description`, `price`, `category`, `product_type`, `size_options`, `color_options`, `image_url`) VALUES
(1, 'Hada AI HAYA Women\'s Casual Linen Pant', '\nHada AI HAYA Women\'s Casual Linen Pant\nModel Wearing size - M\n\nDiscover elegance and comfort with the Hada AI HAYA Ladies Hajj Kurta Collection – modest, breathable, and beautifully designed for your spiritual journey. Perfect for Hajj, Umrah, and everyday wear.', 59.99, '0', 'Casual', 'S,M,L', 'Blue,Pink,White', 'Ladies cloths/1.webp'),
(2, 'Hada AI HAYA Women\'s Casual Pant', 'Model Wearing size - M\n\nDiscover elegance and comfort with the Hada AI HAYA Ladies Hajj Kurta Collection – modest, breathable, and beautifully designed for your spiritual journey. Perfect for Hajj, Umrah, and everyday wear.', 45.00, '0', 'Jeans', 'S,M,L', 'Blue,Black', 'Ladies cloths/2_1.webp'),
(3, 'Hada AI HAYA Women\'s Party Top', 'Model Wearing size - M\n\nDiscover elegance and comfort with the Hada AI HAYA Ladies Hajj Kurta Collection – modest, breathable, and beautifully designed for your spiritual journey. Perfect for Hajj, Umrah, and everyday wear.', 35.50, '0', 'Casual', 'S,M,L', 'Yellow,Floral', 'Ladies cloths/2.webp'),
(4, 'Hada AI HAYA Women\'s Party Kurta', 'Model Wearing size - M\n\nDiscover elegance and comfort with the Hada AI HAYA Ladies Hajj Kurta Collection – modest, breathable, and beautifully designed for your spiritual journey. Perfect for Hajj, Umrah, and everyday wear.', 29.99, '0', 'Casual', 'XS,S,M,L', 'Green , Yellow', 'Ladies cloths/3.webp'),
(5, 'Hada AI HAYA Women\'s Party Kurta', 'Model Wearing size - M\n\nDiscover elegance and comfort with the Hada AI HAYA Ladies Hajj Kurta Collection – modest, breathable, and beautifully designed for your spiritual journey. Perfect for Hajj, Umrah, and everyday wear.', 39.99, '0', 'Casual', 'S,M,L', 'Yellow,Floral', 'Ladies cloths/4.webp'),
(6, 'Hada AI HAYA Women\'s Casual Pant', 'Model Wearing size - M\n\nDiscover elegance and comfort with the Hada AI HAYA Ladies Hajj Kurta Collection – modest, breathable, and beautifully designed for your spiritual journey. Perfect for Hajj, Umrah, and everyday wear.', 39.00, '0', 'Casual', 'S,M,L', 'Blue , Yellow', 'Ladies cloths/5.webp'),
(7, 'Bloom Women\'s Casual Top', '\nBloom Women\'s Casual Top\nElevate your Ladies Casual Wear with our versatile Women\'s Casual Top. Effortlessly stylish and comfortable, perfect for relaxed yet chic looks.', 39.00, '0', 'Casual', 'S,M,L', 'Yellow,Floral', 'Ladies cloths/6.webp'),
(8, 'Modano Bloom Women\'s Casual Skirt', '\nElevate your Ladies Casual Wear with our versatile Women\'s Casual Skirt. Effortlessly stylish and comfortable, perfect for relaxed yet chic looks.', 90.00, '0', 'Casual', 'S,M,L', 'Yellow,Floral', 'Ladies cloths/22.webp'),
(9, 'Bloom Women\'s Casual Cargo Pant', 'Bloom Women\'s Casual Cargo Pant\nElevate your Ladies Casual Wear with our versatile Women\'s Casual Pant. Effortlessly stylish and comfortable, perfect for relaxed yet chic looks.', 44.99, '0', 'Casual', 'S,M,L', 'Yellow,Black', 'Ladies cloths/7.webp'),
(10, 'Bloom Women\'s Casual Top', 'Bloom Women\'s Casual Top\nElevate your Ladies Casual Wear with our versatile Women\'s Casual Top. Effortlessly stylish and comfortable, perfect for relaxed yet chic looks.', 45.99, '0', 'Casual', 'S,M,L', 'Black,Yellow', 'Ladies cloths/8.webp'),
(11, 'Bloom Women\'s Casual Top', 'Bloom Women\'s Casual Top\nElevate your Ladies Casual Wear with our versatile Women\'s Casual Top. Effortlessly stylish and comfortable, perfect for relaxed yet chic looks.', 55.99, '0', 'Skirt', 'S,M,L', 'Yellow,Floral', 'Ladies cloths/11.webp'),
(12, 'Bloom Women\'s Party Top', 'Bloom Women\'s Party Top\nElevate your Ladies Casual Wear with our versatile Women\'s Casual Top. Effortlessly stylish and comfortable, perfect for relaxed yet chic looks.', 25.99, '0', 'Casual', 'S,M,L', 'Yellow,White', 'Ladies cloths/9.webp');

-- --------------------------------------------------------

--
-- Table structure for table `ladiesorders`
--

CREATE TABLE `ladiesorders` (
  `order_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_address` text DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `selected_size` varchar(50) DEFAULT NULL,
  `selected_color` varchar(50) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ladiesorders`
--

INSERT INTO `ladiesorders` (`order_id`, `customer_name`, `customer_email`, `customer_address`, `product_id`, `product_name`, `selected_size`, `selected_color`, `quantity`, `unit_price`, `total_price`, `order_date`, `status`) VALUES
(1, 'gihani weerasinghe', 'gkw3432212@gmail.com', 'karawita', 2, 'Comfortable Denim Jeans', '26', 'Black', 1, 45.00, 45.00, '2025-06-21 11:14:42', 'Pending'),
(2, 'gihani weerasinghe', 'gkw3432212@gmail.com', 'Palawela Road\nkarawita', 1, 'Elegant Floral Dress', 'S', 'Blue', 1, 59.99, 59.99, '2025-06-21 12:07:11', 'Pending'),
(3, 'gihani weerasinghe', 'gkw3432212@gmail.com', 'karawita', 3, 'Hada AI HAYA Women\'s Party Top', 'S', 'Yellow', 1, 35.50, 35.50, '2025-06-22 17:43:20', 'Pending'),
(4, 'gihani weerasinghe', 'gkw3432212@gmail.com', 'VHGVH', 7, 'Bloom Women\'s Casual Top', 'S', 'Yellow', 1, 39.00, 39.00, '2025-06-22 17:43:41', 'Pending'),
(5, 'gihani weerasinghe', 'gkw3432212@gmail.com', 'Main Road', 3, 'Hada AI HAYA Women\'s Party Top', 'S', 'Yellow', 1, 35.50, 35.50, '2025-06-22 17:48:28', 'Pending'),
(6, 'gihani weerasinghe', 'gkw3432212@gmail.com', 'Palawela Road\nkarawita', 3, 'Hada AI HAYA Women\'s Party Top', 'S', 'Yellow', 1, 35.50, 35.50, '2025-06-22 17:49:00', 'Pending'),
(7, 'gihani weerasinghe', 'gkw3432212@gmail.com', 'karawita', 2, 'Hada AI HAYA Women\'s Casual Pant', 'S', 'Blue', 1, 45.00, 45.00, '2025-06-22 17:52:38', 'Pending'),
(8, 'gihani weerasinghe', 'gkw3432212@gmail.com', 'Palawela Road\nkarawita', 3, 'Hada AI HAYA Women\'s Party Top', 'S', 'Yellow', 1, 35.50, 35.50, '2025-06-23 05:04:02', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `sender_type` enum('user','admin') NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `message_text` text NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `conversation_id`, `sender_type`, `sender_id`, `message_text`, `timestamp`) VALUES
(1, 1, 'user', NULL, 'bhn', '2025-06-08 11:16:22'),
(2, 1, 'admin', NULL, 'hi', '2025-06-08 11:31:46'),
(3, 3, 'user', NULL, 'hi', '2025-06-08 11:32:12'),
(4, 3, 'admin', NULL, 'hi', '2025-06-08 11:32:21'),
(5, 3, 'user', NULL, 'weerasinghe', '2025-06-08 11:41:34'),
(6, 4, 'user', NULL, 'gihani weerasinghe', '2025-06-08 11:42:29'),
(7, 9, 'user', NULL, 'hi', '2025-06-08 11:48:40'),
(8, 14, 'user', NULL, 'weerasinghe', '2025-06-08 14:25:13'),
(9, 15, 'user', NULL, 'P.G.K.WEERASINGHE', '2025-06-13 02:45:41'),
(10, 16, 'user', NULL, 'heloo', '2025-06-15 01:19:07'),
(11, 27, 'user', NULL, 'heloo', '2025-06-23 14:46:40'),
(12, 27, 'admin', NULL, 'hi', '2025-06-23 14:47:40'),
(13, 28, 'user', NULL, 'heloooo', '2025-06-26 13:04:36'),
(14, 28, 'admin', NULL, 'hiiii', '2025-06-26 13:05:08'),
(15, 29, 'user', NULL, 'heloooo', '2025-06-26 13:05:27'),
(16, 30, 'user', NULL, 'heloooo', '2025-06-26 13:05:57'),
(17, 11, 'user', NULL, 'helooow', '2025-06-26 20:34:17'),
(18, 30, 'admin', NULL, 'haii', '2025-06-26 20:34:58'),
(19, 31, 'user', NULL, 'heloooww', '2025-06-26 20:41:48'),
(20, 31, 'admin', NULL, 'hiii', '2025-06-26 20:42:11'),
(21, 32, 'user', NULL, 'heloooww', '2025-06-26 20:42:28'),
(22, 33, 'user', NULL, 'heloooww', '2025-06-26 20:42:43');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `shipping_address` text NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_status` enum('Pending','Completed','Failed') DEFAULT 'Pending',
  `payment_method` varchar(50) DEFAULT NULL,
  `card_last_four` varchar(4) DEFAULT NULL,
  `order_status` enum('Pending','Processing','Shipped','Delivered','Cancelled') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_per_item` decimal(10,2) NOT NULL,
  `selected_size` varchar(50) DEFAULT NULL,
  `selected_color` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `in_stock` tinyint(1) DEFAULT 1,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `brand`, `product_name`, `price`, `image_url`, `size`, `color`, `in_stock`, `description`) VALUES
(1, 'Hustle', 'Regular Fit Casual T-Shirt', 1950.00, 'images/Hustle/1_1.webp', 'S,M,L,XL', 'black,white', 1, 'A comfortable regular fit t-shirt.'),
(2, 'Hustle', 'Casual Relax Fit Men\'s Polo T-Shirt', 2550.00, 'images/Hustle/2_1.webp', 'M,L,XL', 'navy,white', 1, 'Relaxed fit polo for casual wear.'),
(3, 'Hustle', 'Loose Fit Casual Oversize T-Shirt', 2650.00, 'images/Hustle/1_1.webp', 'M,L,XL', 'grey,black', 1, 'Oversized t-shirt for a modern look.'),
(4, 'Hustle', 'Men\'s Casual Jacket', 2850.00, 'images/Hustle/1_1.webp', 'S,M,L', 'grey,black,blue', 1, 'Stylish casual jacket for men.'),
(5, 'Hustle', 'Slim Fit Jeans', 3500.00, 'images/Hustle/1_1.webp', '28,30,32,34', 'blue,black', 1, 'Classic slim fit jeans.'),
(6, 'Hustle', 'Athletic Shorts', 1800.00, 'images/Hustle/1_1.webp', 'S,M,L', 'black,grey', 1, 'Comfortable shorts for athletic activities.'),
(8, 'Hustle', 'Jogger Pants', 500.00, 'C:\\\\\\\\xampp\\\\\\\\htdocs\\\\\\\\ZAYNO\\\\\\\\images\\\\\\\\Hustle\\\\\\\\1_1.webp', 'S,M,L,XL', 'navy', 1, 'cbbvxcb');

-- --------------------------------------------------------

--
-- Table structure for table `product_gallery_images`
--

CREATE TABLE `product_gallery_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `display_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_gallery_images`
--

INSERT INTO `product_gallery_images` (`id`, `product_id`, `image_url`, `display_order`) VALUES
(1, 1, 'C:xampphtdocs\ZAYNOimagesHustle1_1.webp', 1),
(2, 1, 'C:xampphtdocs\ZAYNOimagesHustle1_2.webp', 2),
(3, 1, 'C:xampphtdocs\ZAYNOimagesHustle1_3.webp', 3),
(4, 3, 'C:xampphtdocs\ZAYNOimagesHustle3_1.webp', 1),
(5, 3, 'C:xampphtdocs\ZAYNOimagesHustle3_2.webp', 2),
(10, 4, 'C:\\xampp\\htdocs\\ZAYNO\\images\\Hustle\\1_2.webp', 0),
(11, 4, 'C:\\xampp\\htdocs\\ZAYNO\\images\\Hustle\\1_3.webp', 1),
(13, 9, 'C:\\xampp\\htdocs\\ZAYNO\\images\\Hustle\\1_2.webp', 0);

-- --------------------------------------------------------

--
-- Table structure for table `search`
--

CREATE TABLE `search` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `search`
--

INSERT INTO `search` (`product_id`, `name`, `description`, `category`, `price`, `image_url`, `created_at`) VALUES
(1, 'Men\'s T-Shirt', 'Comfortable cotton t-shirt for everyday wear.', 'T-Shirts', 19.99, 'images/Mens cloths/2.jpg', '2025-06-21 17:18:46'),
(2, 'Women\'s Jeans', 'Classic blue denim jeans, slim fit.', 'Jeans', 49.99, 'images/Modano/1_1.webp', '2025-06-21 17:18:46'),
(3, 'Kids Hoodie', 'Warm and cozy hoodie for children.', 'Hoodies', 29.99, 'images/kids cloths/19.webp', '2025-06-21 17:18:46'),
(4, 'Summer Dress', 'Light and airy dress perfect for summer.', 'Dresses', 35.50, 'images/Curvy Clothing/1.webp', '2025-06-21 17:18:46'),
(5, 'Formal Shirt', 'Elegant formal shirt for special occasions.', 'Shirts', 45.00, 'images/King Street/2.webp', '2025-06-21 17:18:46');

-- --------------------------------------------------------

--
-- Table structure for table `secondbanner`
--

CREATE TABLE `secondbanner` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `discount_percentage` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `stock_quantity` int(11) DEFAULT 0,
  `available_sizes` varchar(255) DEFAULT '',
  `available_colors` varchar(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `secondbanner`
--

INSERT INTO `secondbanner` (`id`, `name`, `description`, `price`, `image_url`, `discount_percentage`, `created_at`, `stock_quantity`, `available_sizes`, `available_colors`) VALUES
(1, 'Backprint Relax Fit Casual T-Shirt', 'Backprint Relax Fit Casual T-Shirt\r\nModel wearing Size - L\r\n\r\nUnisex Hustle Oversized T-Shirt - Trendy backprint design, perfect for casual style.', 79.99, 'images/1_1.webp', 25, '2025-06-20 06:11:40', 6, '0', 'black , brown , yellow'),
(2, 'Bloom Women\'s Casual Top', 'Bloom Women\'s Casual Top\r\nElevate your Ladies Casual Wear with our versatile Women\'s Casual Top. Effortlessly stylish and comfortable, perfect for relaxed yet chic looks.\r\n\r\n', 65.00, 'images/SecondBanner/7.webp', 15, '2025-06-20 06:11:40', 2, '0', 'Lavender, Purple, White'),
(3, 'Classic Black Dress', 'A timeless black dress, a must-have for every wardrobe.', 89.99, 'images/SecondBanner/1.webp', 30, '2025-06-20 06:11:40', 0, '', ''),
(4, 'Boho Brown Dress', 'A comfortable and trendy brown dress with a bohemian feel.', 72.50, 'images/SecondBanner/2.webp', 20, '2025-06-20 06:11:40', 0, '', ''),
(5, 'Casual Cream Dress', 'A versatile cream dress, ideal for everyday wear.', 55.00, 'images/SecondBanner/3.webp', 10, '2025-06-20 06:11:40', 0, '0', 'Red, Yellow'),
(6, 'Formal Black Gown', 'A stunning black gown for special events.', 120.00, 'images/SecondBanner/4.webp', 25, '2025-06-20 06:11:40', -1, '0', ''),
(8, 'Regular Fit Casual Oversize T-Shirt', 'Regular Fit Casual Oversize T-Shirt\r\nUpgrade your casual wardrobe with our Oversized Tee. Effortlessly stylish and comfortable, perfect for everyday wear. Get yours now.', 790.00, 'images/6.jpg', 10, '2025-06-21 19:28:32', 8, '0', 'black , brown , yellow');

-- --------------------------------------------------------

--
-- Table structure for table `secondbannerorder`
--

CREATE TABLE `secondbannerorder` (
  `id` int(11) NOT NULL,
  `order_reference_id` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `selected_size` varchar(50) DEFAULT NULL,
  `selected_color` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `secondbannerorder`
--

INSERT INTO `secondbannerorder` (`id`, `order_reference_id`, `product_id`, `product_name`, `product_price`, `quantity`, `customer_name`, `customer_email`, `order_date`, `selected_size`, `selected_color`) VALUES
(1, 'order_685535b64d9923.563207501750414774', 1, 'Elegant Gray Dress', 59.99, 1, 'gihani weerasinghe', 'gkw3432212@gmail.com', '2025-06-20 10:19:34', NULL, NULL),
(2, 'order_685535b64d9923.563207501750414774', 2, 'Chic White Dress', 55.25, 1, 'gihani weerasinghe', 'gkw3432212@gmail.com', '2025-06-20 10:19:34', NULL, NULL),
(3, 'order_685535b64d9923.563207501750414774', 6, 'Formal Black Gown', 90.00, 1, 'gihani weerasinghe', 'gkw3432212@gmail.com', '2025-06-20 10:19:34', NULL, NULL),
(4, 'order_6855377b94c2e7.287188181750415227', 1, 'Elegant Gray Dress', 59.99, 1, 'gihani weerasinghe', 'gkw3432212@gmail.com', '2025-06-20 10:27:07', NULL, NULL),
(5, 'order_68554ed8768247.089496621750421208', 5, 'Casual Cream Dress', 49.50, 3, 'gihani weerasinghe', 'gkw3432212@gmail.com', '2025-06-20 12:06:48', '', 'Red'),
(6, 'order_68554f9991e3f4.702276541750421401', 5, 'Casual Cream Dress', 49.50, 2, 'gihani weerasinghe', 'gkw3432212@gmail.com', '2025-06-20 12:10:01', '', 'Red'),
(7, 'order_685697f3a126c4.018547081750505459', 5, 'Casual Cream Dress', 49.50, 1, 'gihani weerasinghe', 'gkw3432212@gmail.com', '2025-06-21 11:30:59', '', 'Red'),
(8, 'order_6856bca5189851.164047411750514853', 5, 'Casual Cream Dress', 49.50, 1, 'gihani weerasinghe', 'gkw3432212@gmail.com', '2025-06-21 14:07:33', '', 'Red'),
(9, 'order_6856bcfd91fc69.290477631750514941', 5, 'Casual Cream Dress', 49.50, 3, 'gihani weerasinghe', 'gkw3432212@gmail.com', '2025-06-21 14:09:01', '', 'Red'),
(10, 'order_685838fddefb25.006820381750612221', 2, 'Bloom Women\'s Casual Top', 55.25, 1, 'gihani weerasinghe', 'gkw3432212@gmail.com', '2025-06-22 17:10:21', '', 'Lavender'),
(11, 'order_685838fddefb25.006820381750612221', 2, 'Bloom Women\'s Casual Top', 55.25, 1, 'gihani weerasinghe', 'gkw3432212@gmail.com', '2025-06-22 17:10:21', '', 'White'),
(12, 'order_685838fddefb25.006820381750612221', 6, 'Men&#39;s Casual Shirt', 29.00, 1, 'gihani weerasinghe', 'gkw3432212@gmail.com', '2025-06-22 17:10:21', NULL, NULL),
(13, 'order_685838fddefb25.006820381750612221', 1, 'Backprint Relax Fit Casual T-Shirt', 59.99, 1, 'gihani weerasinghe', 'gkw3432212@gmail.com', '2025-06-22 17:10:21', '', 'black'),
(14, 'order_685839e75a03b8.134942581750612455', 1, 'Backprint Relax Fit Casual T-Shirt', 59.99, 2, 'gihani weerasinghe', 'gkw3432212@gmail.com', '2025-06-22 17:14:15', '', 'black'),
(15, 'order_6858e078636724.415669901750655096', 1, 'Backprint Relax Fit Casual T-Shirt', 59.99, 1, 'gihani weerasinghe', 'gkw3432212@gmail.com', '2025-06-23 05:04:56', '', 'black'),
(16, 'order_6858e078636724.415669901750655096', 8, 'Regular Fit Casual Oversize T-Shirt', 621.00, 1, 'gihani weerasinghe', 'gkw3432212@gmail.com', '2025-06-23 05:04:56', 'S', 'black'),
(17, 'order_68591ae1cf1e69.120834061750670049', 2, 'Bloom Women\'s Casual Top', 55.25, 1, 'gihani weerasinghe', 'gkw3432212@gmail.com', '2025-06-23 09:14:09', '', 'Purple');

-- --------------------------------------------------------

--
-- Table structure for table `secondbannerreview`
--

CREATE TABLE `secondbannerreview` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `reviewer_name` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `review_text` text DEFAULT NULL,
  `review_date` timestamp NOT NULL DEFAULT current_timestamp()
) ;

--
-- Dumping data for table `secondbannerreview`
--

INSERT INTO `secondbannerreview` (`id`, `product_id`, `reviewer_name`, `rating`, `review_text`, `review_date`) VALUES
(1, 5, 'Admin', 5, 'good', '2025-06-21 07:13:41'),
(2, 2, 'good product', 5, 'good', '2025-06-22 17:27:16'),
(3, 1, 'gihani', 4, 'good', '2025-06-23 03:41:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'gihani', 'gkw3432212@gmail.com', '$2y$10$MUMabuPOmAkSRpVfS2N5luZRyK26NbgKppO1MsOygWn9uinorWzoe', '2025-06-07 11:45:02'),
(9, 'gihaniweerasinghe', 'gihanikalpni@gmail.com', '$2y$10$aZLK8cn9t.7L05/MlTam4Om7nojW0ocLl2zxA/E/.1.8oJCoqafFW', '2025-06-07 12:45:57'),
(10, 'ATI', 'ati@gmail.com', '$2y$10$2bf1Ic/KoddTXBb0kTS/aeS8ZrQZsoWXWGsNaZIz9VNJu.WEOLbLa', '2025-06-07 12:52:52'),
(12, 'karawita', 'kalpanipiya@gmail.com', '$2y$10$5TQ3zuDlC6JAlAMAcSGihORdPwqow/Nei2oTWl9nr2haGXGrlbtiy', '2025-06-07 12:54:54'),
(13, '123', '123@gmail.com', '$2y$10$Fdr9Fva5UzQSoSqM59U8BuTQ8NVTfdFAfzmJ8AG9OX6P9XV1tBBmq', '2025-06-09 09:54:50'),
(15, 'Rashmi', 'aaa@gmail.com', '$2y$10$h1J2uAUC9YmYv.nAn3Hvv.VlYBgPVwBv29Nkn5AHo7l0xAzRQXZn.', '2025-06-12 18:51:24'),
(16, 'hi', 'hii@gmail.com', '$2y$10$Vi4u52mswz027CjPdWVzAuRxyYoAkv6TA7BTE./XKzX.ZpfwvsvE6', '2025-06-12 19:35:51'),
(18, 'gi', 'sss@gmail.com', '$2y$10$9X0/BuQyAcAbPCKtro4vAuh6plvRy2.JbNQHbllMDKdlQEKKaG4/6', '2025-06-16 13:43:49'),
(19, 'aa', 'aaaa@gmail.com', '$2y$10$NaCqeJv3rpXeep5EigbmU.LyQtGx2zcGFnC2VI2iyfjfR6NeOHLVK', '2025-06-22 16:57:52'),
(20, 'Roshani', 'roshani@gmail.com', '$2y$10$al62cB1VxHqT6DcepV.w0uhc0hFWPMkCrrH2yXTOXXXnX30PQbBSe', '2025-06-23 09:15:49'),
(21, 'test', 'test@gmail.com', '$2y$10$ipSojIphpn2PVY.hwHEq4uDNSFRygQHY6Wzn0/1ZLG25WBFazfmL6', '2025-06-26 07:01:25'),
(24, 'gihani weerasinghe', 'ghh@gmail.com', '$2y$10$Zc/1TKXLqB5qK2jFltNMAuf32cl5Hcdi62dLHr3QVaA1E6MJHLwG.', '2025-06-26 07:16:23');

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `street_address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `zip_code` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_addresses`
--

INSERT INTO `user_addresses` (`id`, `user_id`, `full_name`, `street_address`, `city`, `zip_code`, `country`, `phone_number`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 1, 'Gihani Weerasinghe', 'Main Road', 'Rathnapura', '70044', 'Sri Lanka', '0763951645', 0, '2025-06-12 18:47:21', '2025-06-12 18:47:21'),
(2, 19, 'weerasinghe', 'karawita Road', 'karawita', '70044', 'sri lanka', '763951645', 0, '2025-06-22 17:00:28', '2025-06-22 17:00:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `all_products`
--
ALTER TABLE `all_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`conversation_id`);

--
-- Indexes for table `firstbanner`
--
ALTER TABLE `firstbanner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_products`
--
ALTER TABLE `home_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ladies`
--
ALTER TABLE `ladies`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `ladiesorders`
--
ALTER TABLE `ladiesorders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `conversation_id` (`conversation_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_gallery_images`
--
ALTER TABLE `product_gallery_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `search`
--
ALTER TABLE `search`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `secondbanner`
--
ALTER TABLE `secondbanner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `secondbannerorder`
--
ALTER TABLE `secondbannerorder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `secondbannerreview`
--
ALTER TABLE `secondbannerreview`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `all_products`
--
ALTER TABLE `all_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `conversation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `firstbanner`
--
ALTER TABLE `firstbanner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `home_products`
--
ALTER TABLE `home_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ladies`
--
ALTER TABLE `ladies`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ladiesorders`
--
ALTER TABLE `ladiesorders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_gallery_images`
--
ALTER TABLE `product_gallery_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `search`
--
ALTER TABLE `search`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `secondbanner`
--
ALTER TABLE `secondbanner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `secondbannerorder`
--
ALTER TABLE `secondbannerorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `secondbannerreview`
--
ALTER TABLE `secondbannerreview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ladiesorders`
--
ALTER TABLE `ladiesorders`
  ADD CONSTRAINT `ladiesorders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `ladies` (`product_id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`conversation_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

--
-- Constraints for table `product_gallery_images`
--
ALTER TABLE `product_gallery_images`
  ADD CONSTRAINT `product_gallery_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `all_products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `secondbannerorder`
--
ALTER TABLE `secondbannerorder`
  ADD CONSTRAINT `secondbannerorder_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `secondbanner` (`id`);

--
-- Constraints for table `secondbannerreview`
--
ALTER TABLE `secondbannerreview`
  ADD CONSTRAINT `secondbannerreview_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `secondbanner` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
