```sql
CREATE DATABASE IF NOT EXISTS shopping;
USE shopping;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

SET NAMES utf8mb4;

CREATE TABLE `product` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(65,0) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT 'General',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `product` (`id`, `product_name`, `product_price`, `product_image`, `category`) VALUES
(1, 'nokia 7', 22000, 'image/nokia7.jpg', 'Mobiles'),
(2, 'i phone', 10000, 'image/iphon.jpg', 'Mobiles'),
(3, 'One Plus', 15000, 'image/one_plus6.jpg', 'Mobiles'),
(4, 'Free shopping', 10000, 'image/f1.png', 'Men\'s Clothing'),
(5, 'Cartoon Astronaut T-Shirts', 10000, 'image/f1.jpg', 'Men\'s Clothing'),
(6, 'Cartoon Astronaut T-Shirts2', 12345, 'image/f2.jpg', 'Men\'s Clothing'),
(7, 'Cartoon Astronaut T-Shirts 3', 345, 'image/f3.jpg', 'Men\'s Clothing'),
(8, 'Cartoon Astronaut T-Shirts4', 2234, 'image/f4.jpg', 'Men\'s Clothing'),
(9, 't5', 100, 'image/f5.jpg', 'Women\'s Clothing'),
(10, 'f6', 200, 'image/f7.jpg', 'Women\'s Clothing'),
(11, 'f7', 300, 'image/f8.jpg', 'Women\'s Clothing'),
(12, 'f9', 422, 'image/n1.jpg', 'Men\'s Clothing'),
(13, 'a1', 422, 'image/n2.jpg', 'Men\'s Clothing'),
(14, 'a3', 422, 'image/n3.jpg', 'Men\'s Clothing'),
(15, 'n4', 100, 'image/n7.jpg', 'Men\'s Clothing'),
(16, 'n8', 12, 'image/n8.jpg', 'Men\'s Clothing'),
(17, 'n9', 23, 'image/n6.jpg', 'Men\'s Clothing'),
(18, 'n10', 230, 'image/n5.jpg', 'Men\'s Clothing'),
(19, 'Apple MacBook Pro 14"', 150000, 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500&h=500&fit=crop', 'Laptops'),
(20, 'Dell XPS 13', 120000, 'https://images.unsplash.com/photo-1531297172868-6cb2850c476c?w=500&h=500&fit=crop', 'Laptops'),
(21, 'HP Spectre x360', 135000, 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500&h=500&fit=crop', 'Laptops'),
(22, 'Samsung Galaxy S23', 85000, 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=500&h=500&fit=crop', 'Mobiles'),
(23, 'Summer Floral Dress', 2500, 'https://images.unsplash.com/photo-1532453288672-3a27e9be9efd?w=500&h=500&fit=crop', 'Women\'s Clothing');

CREATE TABLE `spay` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `purpose` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `pid` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `pay_date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `product` AUTO_INCREMENT = 24;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `user_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;
```
