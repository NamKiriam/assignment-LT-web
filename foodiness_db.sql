-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2025 at 03:53 PM
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
-- Database: `foodiness_db`
--
-- Tạo database nếu chưa tồn tại
CREATE DATABASE IF NOT EXISTS foodiness_db;

-- Chọn sử dụng database đó
USE foodiness_db;

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(100) NOT NULL,
  `update_date` datetime NOT NULL,
  `content` text DEFAULT NULL,
  `like` int(11) NOT NULL DEFAULT 0 CHECK (`like` >= 0),
  `dislike` int(11) NOT NULL DEFAULT 0 CHECK (`dislike` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `title`, `author`, `update_date`, `content`, `like`, `dislike`) VALUES
('A20250503090000', 'Best Pho Recipe', 'Chef Nam', '2025-05-03 09:00:00', 'Here is the secret to the best pho...', 0, 0),
('A20250503091000', 'Delicious Banh Mi', 'Chef Linh', '2025-05-04 10:37:50', 'Making the perfect banh mi is all about the bread...', 0, 0),
('A20250503092000', 'Vietnamese Coffee Guide', 'Barista Hoa', '2025-05-03 09:20:00', 'Strong, sweet, and creamy — learn to make it right.', 0, 0),
('A20250504115057', 'The quick brown fox jumps over the lazy dog.', 'Lebron James', '2025-05-04 16:50:57', 'The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog.\n                    The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog.\n                    The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog.\n                    The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog.\n                    The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog.\n                    The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog.\n                    The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog.', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `ID_comment` int(11) NOT NULL,
  `ID_post` int(11) NOT NULL,
  `ID_user` int(11) NOT NULL,
  `Content` text NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `status` enum('unread','read','replied') DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `user_id`, `message`, `status`, `created_at`) VALUES
(3, 9, 'hello', 'unread', '2025-05-05 09:16:21');

-- --------------------------------------------------------

--
-- Table structure for table `dessert`
--

CREATE TABLE `dessert` (
  `ID_dessert` int(11) NOT NULL,
  `ID_meal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dish`
--

CREATE TABLE `dish` (
  `id` bigint(19) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `category` varchar(20) NOT NULL,
  `meat` varchar(10) NOT NULL,
  `description` varchar(100) NOT NULL,
  `img_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dish`
--

INSERT INTO `dish` (`id`, `name`, `price`, `category`, `meat`, `description`, `img_url`) VALUES
(1, 'Thịt kho trứng', 40000, 'Món khô', 'Thịt heo', '', ''),
(2, 'Bò xào', 35000, 'Món khô', 'Thịt bò', '', ''),
(3, 'Chả giò chiên', 35000, 'Món khô', 'Thịt heo', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `main_dish`
--

CREATE TABLE `main_dish` (
  `ID_main` int(11) NOT NULL,
  `ID_meal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meal`
--

CREATE TABLE `meal` (
  `ID_meal` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Description` text DEFAULT NULL,
  `Image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `ID_order` int(11) NOT NULL,
  `ID_user` int(11) NOT NULL,
  `ID_meal` int(11) NOT NULL,
  `Quantity` int(11) DEFAULT 1,
  `Order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `ID_post` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Content` text NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `ID_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `ID_question` int(11) NOT NULL,
  `ID_user` int(11) NOT NULL,
  `Content` text NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `answered` tinyint(1) NOT NULL DEFAULT 0,
  `answer` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`ID_question`, `ID_user`, `Content`, `Created_at`, `answered`, `answer`) VALUES
(27, 9, 'xin chào', '2025-05-05 09:05:47', 0, NULL),
(28, 9, 'giao trong bao lâu?', '2025-05-05 09:10:33', 0, NULL),
(29, 9, 'Mấy giờ rồi?', '2025-05-05 12:52:39', 0, NULL),
(30, 9, 'ủa ủa?', '2025-05-05 13:48:10', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `site_content`
--

CREATE TABLE `site_content` (
  `id` int(11) NOT NULL,
  `page` varchar(50) NOT NULL,
  `section` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_content`
--

INSERT INTO `site_content` (`id`, `page`, `section`, `content`, `updated_at`) VALUES
(16, 'home', 'hero_title', 'CƠM TRƯA VĂN PHÒNG FOODINESS', '2025-05-05 07:04:04'),
(17, 'home', 'hero_intro', 'Cơm trưa văn phòng không chỉ đơn giản là một bữa ăn thông thường mà còn là sự kết hợp giữa chất lượng và hương vị tinh tế. Món cơm được chế biến từ nguyên liệu tươi ngon, nấu kỹ càng để đảm bảo dinh dưỡng và ngon miệng.', '2025-05-05 07:02:54'),
(18, 'home', 'hero_button', 'Đặt món ngay', '2025-05-05 07:02:54'),
(19, 'home', 'why_title', 'Vì sao chọn Foodiness?', '2025-05-05 07:02:54'),
(20, 'home', 'why_text', 'Đến với Cơm Văn Phòng, bạn không cần bận tâm đến an toàn thực phẩm. Với nguyên tắc “Cái đức đặt lên hàng đầu”, mọi khâu chế biến đều được đội ngũ bếp chăm chút kỹ lưỡng.', '2025-05-05 07:02:54'),
(21, 'home', 'why_items', '<div class=\"col-sm-6 col-md-4\">\r\n  <div class=\"card p-3 h-100\">\r\n    <img src=\"assets/picture/vegetable.png\" alt=\"Tươi sạch\">\r\n    <h5 class=\"fw-semibold\">Nguồn thực phẩm tươi, sạch</h5>\r\n    <p><i>Thực phẩm chọn lọc kỹ càng, cam kết không dùng hóa chất nhằm mục đích lợi nhuận.</i></p>\r\n  </div>\r\n</div>\r\n<div class=\"col-sm-6 col-md-4\">\r\n  <div class=\"card p-3 h-100\">\r\n    <img src=\"assets/picture/noodles.png\" alt=\"Hương vị\">\r\n    <h5 class=\"fw-semibold\">Hương vị đặc trưng</h5>\r\n    <p><i>Món ăn chế biến hương vị đậm đà, giữ vững đặc trưng của vùng miền.</i></p>\r\n  </div>\r\n</div>\r\n<div class=\"col-sm-6 col-md-4\">\r\n  <div class=\"card p-3 h-100\">\r\n    <img src=\"assets/picture/sushi.png\" alt=\"Đa dạng\">\r\n    <h5 class=\"fw-semibold\">Đa dạng thực đơn</h5>\r\n    <p><i>Thực đơn phong phú, thường xuyên được cập nhật, mang tới nhiều lựa chọn cho thực khách.</i></p>\r\n  </div>\r\n</div>\r\n<div class=\"col-sm-6 col-md-4\">\r\n  <div class=\"card p-3 h-100\">\r\n    <img src=\"assets/picture/clock.png\" alt=\"Giao hàng\">\r\n    <h5 class=\"fw-semibold\">Giao hàng nhanh chóng</h5>\r\n    <p><i>Đúng giờ, cố gắng giao thức ăn đến tay khách hàng nhanh nhất.</i></p>\r\n  </div>\r\n</div>\r\n<div class=\"col-sm-6 col-md-4\">\r\n  <div class=\"card p-3 h-100\">\r\n    <img src=\"assets/picture/dinner_meat.png\" alt=\"Dinh dưỡng\">\r\n    <h5 class=\"fw-semibold\">Đầy đủ chất dinh dưỡng</h5>\r\n    <p><i>Mỗi bữa ăn giàu dinh dưỡng, tiếp thêm năng lượng cho ngày làm việc hiệu quả.</i></p>\r\n  </div>\r\n</div>\r\n<div class=\"col-sm-6 col-md-4\">\r\n  <div class=\"card p-3 h-100\">\r\n    <img src=\"assets/picture/message.png\" alt=\"Lắng nghe\">\r\n    <h5 class=\"fw-semibold\">Lắng nghe người dùng</h5>\r\n    <p><i>Cơm văn phòng luôn lắng nghe mọi ý kiến khách hàng để cải thiện chất lượng dịch vụ.</i></p>\r\n  </div>\r\n</div>\r\n', '2025-05-05 07:03:49'),
(22, 'home', 'steps_title', 'Quy trình đặt suất ăn online', '2025-05-05 07:02:54'),
(23, 'home', 'steps_list', '<ol class=\"process-steps ps-0\">\r\n  <li>\r\n    <div class=\"step-circle\">1</div>\r\n    <div class=\"step-content\">\r\n      <h6 class=\"fw-bold\">Xem thực đơn</h6>\r\n      <p>Quý khách tham khảo các món ăn có trong thực đơn</p>\r\n    </div>\r\n  </li>\r\n  <li>\r\n    <div class=\"step-circle\">2</div>\r\n    <div class=\"step-content\">\r\n      <h6 class=\"fw-bold\">Liên hệ đặt hàng</h6>\r\n      <p>Quý khách liên hệ với công ty để đặt phần ăn</p>\r\n    </div>\r\n  </li>\r\n  <li>\r\n    <div class=\"step-circle\">3</div>\r\n    <div class=\"step-content\">\r\n      <h6 class=\"fw-bold\">Giao hàng</h6>\r\n      <p>Công ty giao hàng tới quý khách</p>\r\n    </div>\r\n  </li>\r\n</ol>\r\n', '2025-05-05 07:03:49'),
(24, 'home', 'testimonial', '<section class=\"testimonials position-relative text-white\">\r\n  <img src=\"assets/picture/banner_cuisine.png\" class=\"img-fluid w-100\" style=\"height: 400px; object-fit: cover;\" alt=\"Background\">\r\n  <div class=\"testimonial-overlay position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center\">\r\n    <div class=\"text-center px-3 px-md-5\">\r\n      <h5 class=\"mb-4 text-uppercase fw-bold\">Khách hàng nói gì về Logo</h5>\r\n      <blockquote class=\"blockquote fs-5 fst-italic\">\r\n        “Cơm và đồ ăn rất ngon, sạch sẽ, món ăn đa dạng”\r\n      </blockquote>\r\n      <div class=\"mt-3\">\r\n        <img src=\"assets/picture/man_icon.png\" class=\"rounded-circle\" width=\"50\" height=\"50\" alt=\"Avatar\">\r\n        <p class=\"mb-0 fw-bold\">Anh Nguyễn Văn A</p>\r\n        <p class=\"small\">Công ty BOSCH</p>\r\n      </div>\r\n    </div>\r\n  </div>\r\n</section>\r\n', '2025-05-05 07:03:49');

-- --------------------------------------------------------

--
-- Table structure for table `soup`
--

CREATE TABLE `soup` (
  `ID_soup` int(11) NOT NULL,
  `ID_meal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID_user` int(11) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Password` varchar(255) NOT NULL,
  `Gender` enum('Nam','Nữ','Khác') DEFAULT 'Nam',
  `Birthday` date DEFAULT NULL,
  `Role` enum('client','admin') DEFAULT 'client',
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID_user`, `Username`, `Email`, `Password`, `Gender`, `Birthday`, `Role`, `Created_at`) VALUES
(1, 'Trần Ngọc Khánh Huy', 'huybacdau123@gmail.com', '$2y$10$yTOuuxYSHYgJtoa1YUrfsOV3YfAX47EE4t.hrs03F0qgQXCKmOmiC', 'Nam', '2004-02-20', 'admin', '2025-05-04 11:46:14'),
(9, 'User Huy', 'hehe@gmail.com', '$2y$10$7NZkpajLWOquXzPtmi4Eruvx7ccyU0v1BaqpxuGTsyECdfdxllgNK', 'Nam', '2025-05-15', 'client', '2025-05-05 08:56:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`ID_comment`),
  ADD KEY `ID_post` (`ID_post`),
  ADD KEY `ID_user` (`ID_user`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_ibfk_1` (`user_id`);

--
-- Indexes for table `dessert`
--
ALTER TABLE `dessert`
  ADD PRIMARY KEY (`ID_dessert`),
  ADD KEY `ID_meal` (`ID_meal`);

--
-- Indexes for table `dish`
--
ALTER TABLE `dish`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `price` (`price`),
  ADD KEY `category` (`category`),
  ADD KEY `meat` (`meat`);

--
-- Indexes for table `main_dish`
--
ALTER TABLE `main_dish`
  ADD PRIMARY KEY (`ID_main`),
  ADD KEY `ID_meal` (`ID_meal`);

--
-- Indexes for table `meal`
--
ALTER TABLE `meal`
  ADD PRIMARY KEY (`ID_meal`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`ID_order`),
  ADD KEY `ID_user` (`ID_user`),
  ADD KEY `ID_meal` (`ID_meal`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`ID_post`),
  ADD KEY `ID_user` (`ID_user`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`ID_question`),
  ADD KEY `ID_user` (`ID_user`);

--
-- Indexes for table `site_content`
--
ALTER TABLE `site_content`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_section` (`page`,`section`);

--
-- Indexes for table `soup`
--
ALTER TABLE `soup`
  ADD PRIMARY KEY (`ID_soup`),
  ADD KEY `ID_meal` (`ID_meal`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID_user`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `ID_comment` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dessert`
--
ALTER TABLE `dessert`
  MODIFY `ID_dessert` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `main_dish`
--
ALTER TABLE `main_dish`
  MODIFY `ID_main` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meal`
--
ALTER TABLE `meal`
  MODIFY `ID_meal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `ID_order` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `ID_post` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `ID_question` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `site_content`
--
ALTER TABLE `site_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `soup`
--
ALTER TABLE `soup`
  MODIFY `ID_soup` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`ID_post`) REFERENCES `post` (`ID_post`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`ID_user`) REFERENCES `user` (`ID_user`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`ID_user`) REFERENCES `user` (`ID_user`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`ID_meal`) REFERENCES `meal` (`ID_meal`);

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`ID_user`) REFERENCES `user` (`ID_user`);

--
-- Constraints for table `soup`
--
ALTER TABLE `soup`
  ADD CONSTRAINT `soup_ibfk_1` FOREIGN KEY (`ID_meal`) REFERENCES `meal` (`ID_meal`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
