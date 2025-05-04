-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 09, 2025 lúc 02:51 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

CREATE DATABASE IF NOT EXISTS foodiness_db;
USE foodiness_db;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `meal_order`
--

-- --------------------------------------------------------

CREATE DATABASE IF NOT EXISTS foodiness_db;
USE foodiness_db;

-- Bảng người dùng
CREATE TABLE user (
  ID_user INT AUTO_INCREMENT PRIMARY KEY,
  Username VARCHAR(100) NOT NULL,
  Email VARCHAR(100) UNIQUE,
  Password VARCHAR(255) NOT NULL,
  Gender ENUM('Nam', 'Nữ', 'Khác') DEFAULT 'Nam',
  Birthday DATE,
  Role ENUM('client', 'admin') DEFAULT 'client',
  Created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Bảng admin
CREATE TABLE admin (
  ID_admin INT AUTO_INCREMENT PRIMARY KEY,
  Admin_name VARCHAR(50) NOT NULL UNIQUE,
  Password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO admin (Admin_name, Password) VALUES
('Zackerville', '04072004');

-- Bảng bài viết
CREATE TABLE `article` (
  `id` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(100) NOT NULL,
  `update_date` datetime NOT NULL,
  `content` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

INSERT INTO `article` (`id`, `title`, `author`, `update_date`, `content`) VALUES
('A20250503090000', 'Best Pho Recipe', 'Chef Nam', '2025-05-03 09:00:00', 'Here is the secret to the best pho...'),
('A20250503091000', 'Delicious Banh Mi', 'Chef Linh', '2025-05-04 10:37:50', 'Making the perfect banh mi is all about the bread...'),
('A20250503092000', 'Vietnamese Coffee Guide', 'Barista Hoa', '2025-05-03 09:20:00', 'Strong, sweet, and creamy — learn to make it right.');

-- Bảng câu hỏi
CREATE TABLE question (
  ID_question INT AUTO_INCREMENT PRIMARY KEY,
  ID_user INT NOT NULL,
  Content TEXT NOT NULL,
  Created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (ID_user) REFERENCES user(ID_user)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Bảng món ăn tổng
CREATE TABLE meal (
  ID_meal INT AUTO_INCREMENT PRIMARY KEY,
  Name VARCHAR(100) NOT NULL,
  Price DECIMAL(10,2) NOT NULL,
  Description TEXT,
  Image_url VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Bảng đơn hàng
CREATE TABLE `order` (
  ID_order INT AUTO_INCREMENT PRIMARY KEY,
  ID_user INT NOT NULL,
  ID_meal INT NOT NULL,
  Quantity INT DEFAULT 1,
  Order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (ID_user) REFERENCES user(ID_user),
  FOREIGN KEY (ID_meal) REFERENCES meal(ID_meal)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Các bảng phân loại món ăn
CREATE TABLE main_dish (
  ID_main INT AUTO_INCREMENT PRIMARY KEY,
  ID_meal INT NOT NULL,
  FOREIGN KEY (ID_meal) REFERENCES meal(ID_meal)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE soup (
  ID_soup INT AUTO_INCREMENT PRIMARY KEY,
  ID_meal INT NOT NULL,
  FOREIGN KEY (ID_meal) REFERENCES meal(ID_meal)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE dessert (
  ID_dessert INT AUTO_INCREMENT PRIMARY KEY,
  ID_meal INT NOT NULL,
  FOREIGN KEY (ID_meal) REFERENCES meal(ID_meal)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE dish (
  ID_dish INT AUTO_INCREMENT PRIMARY KEY,
  Name VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
