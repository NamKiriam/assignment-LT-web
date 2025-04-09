-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 09, 2025 lúc 02:51 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

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

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `ID_admin` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`ID_admin`, `Name`, `Password`) VALUES
(0, 'Nguyễn Văn A', '0901234567');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment`
--

CREATE TABLE `comment` (
  `ID_comment` int(11) NOT NULL,
  `ID_post` int(11) DEFAULT NULL,
  `ID_user` int(11) DEFAULT NULL,
  `Content` text DEFAULT NULL,
  `Date_create` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dessert`
--

CREATE TABLE `dessert` (
  `ID_dish` int(11) NOT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dish`
--

CREATE TABLE `dish` (
  `ID_dish` int(11) NOT NULL,
  `ID_admin` int(11) DEFAULT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `main_dish`
--

CREATE TABLE `main_dish` (
  `ID_dish` int(11) NOT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `meal`
--

CREATE TABLE `meal` (
  `ID_meal` int(11) NOT NULL,
  `Amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order`
--

CREATE TABLE `order` (
  `ID_order` int(11) NOT NULL,
  `ID_meal` int(11) DEFAULT NULL,
  `ID_user` int(11) DEFAULT NULL,
  `date_arrive` date DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post`
--

CREATE TABLE `post` (
  `ID_post` int(11) NOT NULL,
  `Content` text DEFAULT NULL,
  `Date_update` date DEFAULT NULL,
  `Author` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `question`
--

CREATE TABLE `question` (
  `ID_question` int(11) NOT NULL,
  `ID_admin` int(11) DEFAULT NULL,
  `ID_user` int(11) DEFAULT NULL,
  `question` text DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `Date_create` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `soup`
--

CREATE TABLE `soup` (
  `ID_dish` int(11) NOT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `ID_user` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Mail` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID_admin`);

--
-- Chỉ mục cho bảng `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`ID_comment`),
  ADD KEY `ID_post` (`ID_post`),
  ADD KEY `ID_user` (`ID_user`);

--
-- Chỉ mục cho bảng `dessert`
--
ALTER TABLE `dessert`
  ADD PRIMARY KEY (`ID_dish`);

--
-- Chỉ mục cho bảng `dish`
--
ALTER TABLE `dish`
  ADD PRIMARY KEY (`ID_dish`),
  ADD KEY `ID_admin` (`ID_admin`);

--
-- Chỉ mục cho bảng `main_dish`
--
ALTER TABLE `main_dish`
  ADD PRIMARY KEY (`ID_dish`);

--
-- Chỉ mục cho bảng `meal`
--
ALTER TABLE `meal`
  ADD PRIMARY KEY (`ID_meal`);

--
-- Chỉ mục cho bảng `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`ID_order`),
  ADD KEY `ID_meal` (`ID_meal`),
  ADD KEY `ID_user` (`ID_user`);

--
-- Chỉ mục cho bảng `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`ID_post`),
  ADD KEY `Author` (`Author`);

--
-- Chỉ mục cho bảng `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`ID_question`),
  ADD KEY `ID_admin` (`ID_admin`),
  ADD KEY `ID_user` (`ID_user`);

--
-- Chỉ mục cho bảng `soup`
--
ALTER TABLE `soup`
  ADD PRIMARY KEY (`ID_dish`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID_user`);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`ID_post`) REFERENCES `post` (`ID_post`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`ID_user`) REFERENCES `user` (`ID_user`);

--
-- Các ràng buộc cho bảng `dessert`
--
ALTER TABLE `dessert`
  ADD CONSTRAINT `dessert_ibfk_1` FOREIGN KEY (`ID_dish`) REFERENCES `dish` (`ID_dish`);

--
-- Các ràng buộc cho bảng `dish`
--
ALTER TABLE `dish`
  ADD CONSTRAINT `dish_ibfk_1` FOREIGN KEY (`ID_admin`) REFERENCES `admin` (`ID_admin`);

--
-- Các ràng buộc cho bảng `main_dish`
--
ALTER TABLE `main_dish`
  ADD CONSTRAINT `main_dish_ibfk_1` FOREIGN KEY (`ID_dish`) REFERENCES `dish` (`ID_dish`);

--
-- Các ràng buộc cho bảng `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`ID_meal`) REFERENCES `meal` (`ID_meal`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`ID_user`) REFERENCES `user` (`ID_user`);

--
-- Các ràng buộc cho bảng `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`Author`) REFERENCES `user` (`ID_user`);

--
-- Các ràng buộc cho bảng `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`ID_admin`) REFERENCES `admin` (`ID_admin`),
  ADD CONSTRAINT `question_ibfk_2` FOREIGN KEY (`ID_user`) REFERENCES `user` (`ID_user`);

--
-- Các ràng buộc cho bảng `soup`
--
ALTER TABLE `soup`
  ADD CONSTRAINT `soup_ibfk_1` FOREIGN KEY (`ID_dish`) REFERENCES `dish` (`ID_dish`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
