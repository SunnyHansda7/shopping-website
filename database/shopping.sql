```sql
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

SET NAMES utf8mb4;

CREATE TABLE `product` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(65,0) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `product` (`id`, `product_name`, `product_price`, `product_image`) VALUES
(1, 'nokia 7', 22000, 'image/nokia7.jpg'),
(2, 'i phone', 10000, 'image/iphon.jpg'),
(3, 'One Plus', 15000, 'image/one_plus6.jpg'),
(4, 'Free shopping', 10000, 'image/f1.png'),
(5, 'Cartoon Astronaut T-Shirts', 10000, 'image/f1.jpg'),
(6, 'Cartoon Astronaut T-Shirts2', 12345, 'image/f2.jpg'),
(7, 'Cartoon Astronaut T-Shirts 3', 345, 'image/f3.jpg'),
(8, 'Cartoon Astronaut T-Shirts4', 2234, 'image/f4.jpg'),
(9, 't5', 100, 'image/f5.jpg'),
(10, 'f6', 200, 'image/f7.jpg'),
(11, 'f7', 300, 'image/f8.jpg'),
(12, 'f9', 422, 'image/n1.jpg'),
(13, 'a1', 422, 'image/n2.jpg'),
(14, 'a3', 422, 'image/n3.jpg'),
(15, 'n4', 100, 'image/n7.jpg'),
(16, 'n8', 12, 'image/n8.jpg'),
(17, 'n9', 23, 'image/n6.jpg'),
(18, 'n10', 230, 'image/n5.jpg');

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

ALTER TABLE `product` AUTO_INCREMENT = 19;

COMMIT;
```
