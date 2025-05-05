SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: foodiness_db
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng admin
--

CREATE TABLE admin (
  ID_admin int(11) NOT NULL,
  Admin_name varchar(50) NOT NULL,
  Password varchar(255) NOT NULL,
  Email varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng admin
--

INSERT INTO admin (ID_admin, Admin_name, Password, Email) VALUES
(1, 'Zackerville', '04072004', NULL),
(2, 'quanh', '$2y$10$ZmkztvywIefbkgYy0.qfjuod9mI3QrGcJRXmz/iDeDV...\r\n\r\n', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng comment
--

CREATE TABLE comment (
  ID_comment int(11) NOT NULL,
  ID_post int(11) NOT NULL,
  ID_user int(11) NOT NULL,
  Content text NOT NULL,
  Created_at timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng contacts
--

CREATE TABLE contacts (
  id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  message text DEFAULT NULL,
  status enum('unread','read','replied') DEFAULT 'unread',
  created_at timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng dessert
--

CREATE TABLE dessert (
  ID_dessert int(11) NOT NULL,
  ID_meal int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng dish
--

CREATE TABLE dish (
  ID_dish int(11) NOT NULL,
  Name varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng main_dish
--

CREATE TABLE main_dish (
  ID_main int(11) NOT NULL,
  ID_meal int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng meal
--

CREATE TABLE meal (
  ID_meal int(11) NOT NULL,
  Name varchar(100) NOT NULL,
  Price decimal(10,2) NOT NULL,
  Description text DEFAULT NULL,
  Image_url varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng order
--

CREATE TABLE order (
  ID_order int(11) NOT NULL,
  ID_user int(11) NOT NULL,
  ID_meal int(11) NOT NULL,
  Quantity int(11) DEFAULT 1,
  Order_date timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng post
--

CREATE TABLE post (
  ID_post int(11) NOT NULL,
  Title varchar(255) NOT NULL,
  Content text NOT NULL,
  Created_at timestamp NOT NULL DEFAULT current_timestamp(),
  ID_user int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng question
--

CREATE TABLE question (
  ID_question int(11) NOT NULL,
  ID_user int(11) NOT NULL,
  Content text NOT NULL,
  Created_at timestamp NOT NULL DEFAULT current_timestamp(),
  answered tinyint(1) DEFAULT 0,
  answer text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng question
--

INSERT INTO question (ID_question, ID_user, Content, Created_at, answered, answer) VALUES
(22, 5, 'Khi nào đơn hàng của tôi được giao ?', '2025-05-05 05:02:55', 0, NULL),
(23, 5, 'Trong menu có các món chay không ?', '2025-05-05 05:03:07', 0, NULL),
(24, 5, 'Hôm nay menu có gì ?', '2025-05-05 06:23:22', 0, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng site_content
--

CREATE TABLE site_content (
  id int(11) NOT NULL,
  page varchar(50) NOT NULL,
  section varchar(50) NOT NULL,
  content text NOT NULL,
  updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng site_content
--

INSERT INTO site_content (id, page, section, content, updated_at) VALUES
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
-- Cấu trúc bảng cho bảng soup
--

CREATE TABLE soup (
  ID_soup int(11) NOT NULL,
  ID_meal int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng user
--

CREATE TABLE user (
  ID_user int(11) NOT NULL,
  Username varchar(100) NOT NULL,
  Email varchar(100) DEFAULT NULL,
  Password varchar(255) NOT NULL,
  Gender enum('Nam','Nữ','Khác') DEFAULT 'Nam',
  Birthday date DEFAULT NULL,
  Role enum('client','admin') DEFAULT 'client',
  Created_at timestamp NOT NULL DEFAULT current_timestamp(),
  Avatar varchar(255) DEFAULT 'default_avatar.png',
  Address text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng user
--

INSERT INTO user (ID_user, Username, Email, Password, Gender, Birthday, Role, Created_at, Avatar, Address) VALUES
(5, 'quanh', 'quanganhngo2211@gmail.com', '$2y$10$euFcv1Wcv8d5tD0CLdT5M.O1LDIC1uVy7rAcf5THSQ3ow5PqVhAsm', 'Nam', '2004-11-22', 'client', '2025-05-04 01:21:23', 'default_avatar.png', NULL),
(6, 'meow', 'anh.ngobk2211@hcmut.edu.vn', '$2y$10$ZmkztvywIefbkgYy0.qfjuod9mI3QrGcJRXmz/iDeDVnmn/Sr7UdK', 'Nam', '2004-11-22', 'admin', '2025-05-04 01:22:07', 'default_avatar.png', NULL),
(8, 'Tiến', 'zack1_admin@gmail.com', '$2y$10$YUCZHaWzjDem8DbvOFCL1eGOKbrpCqV9dfWjsI/c34pAwGlhgFkDG', 'Nam', '2004-11-22', 'admin', '2025-05-05 03:14:08', 'default_avatar.png', NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng admin
--
ALTER TABLE admin
  ADD PRIMARY KEY (ID_admin),
  ADD UNIQUE KEY Admin_name (Admin_name),
  ADD UNIQUE KEY Email (Email);

--
-- Chỉ mục cho bảng comment
--
ALTER TABLE comment
  ADD PRIMARY KEY (ID_comment),
  ADD KEY ID_post (ID_post),
  ADD KEY ID_user (ID_user);

--
-- Chỉ mục cho bảng contacts
--
ALTER TABLE contacts
  ADD PRIMARY KEY (id),
  ADD KEY contacts_ibfk_1 (user_id);

--
-- Chỉ mục cho bảng dessert
--
ALTER TABLE dessert
  ADD PRIMARY KEY (ID_dessert),
  ADD KEY ID_meal (ID_meal);

--
-- Chỉ mục cho bảng dish
--
ALTER TABLE dish
  ADD PRIMARY KEY (ID_dish);

--
-- Chỉ mục cho bảng main_dish
--
ALTER TABLE main_dish
  ADD PRIMARY KEY (ID_main),
  ADD KEY ID_meal (ID_meal);

--
-- Chỉ mục cho bảng meal
--
ALTER TABLE meal
  ADD PRIMARY KEY (ID_meal);

--
-- Chỉ mục cho bảng order
--
ALTER TABLE order
  ADD PRIMARY KEY (ID_order),
  ADD KEY ID_user (ID_user),
  ADD KEY ID_meal (ID_meal);

--
-- Chỉ mục cho bảng post
--
ALTER TABLE post
  ADD PRIMARY KEY (ID_post),
  ADD KEY ID_user (ID_user);

--
-- Chỉ mục cho bảng question
--
ALTER TABLE question
  ADD PRIMARY KEY (ID_question),
  ADD KEY ID_user (ID_user);

--
-- Chỉ mục cho bảng site_content
--
ALTER TABLE site_content
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY unique_section (page,`section`);

--
-- Chỉ mục cho bảng soup
--
ALTER TABLE soup
  ADD PRIMARY KEY (ID_soup),
  ADD KEY ID_meal (ID_meal);

--
-- Chỉ mục cho bảng user
--
ALTER TABLE user
  ADD PRIMARY KEY (ID_user),
  ADD UNIQUE KEY Email (Email);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng admin
--
ALTER TABLE admin
  MODIFY ID_admin int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng comment
--
ALTER TABLE comment
  MODIFY ID_comment int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng contacts
--
ALTER TABLE contacts
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng dessert
--
ALTER TABLE dessert
  MODIFY ID_dessert int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng dish
--
ALTER TABLE dish
  MODIFY ID_dish int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng main_dish
--
ALTER TABLE main_dish
  MODIFY ID_main int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng meal
--
ALTER TABLE meal
  MODIFY ID_meal int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng order
--
ALTER TABLE order
  MODIFY ID_order int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng post
--
ALTER TABLE post
  MODIFY ID_post int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng question
--
ALTER TABLE question
  MODIFY ID_question int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng site_content
--
ALTER TABLE site_content
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng soup
--
ALTER TABLE soup
  MODIFY ID_soup int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng user
--
ALTER TABLE user
  MODIFY ID_user int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng comment
--
ALTER TABLE comment
  ADD CONSTRAINT comment_ibfk_1 FOREIGN KEY (ID_post) REFERENCES post (ID_post),
  ADD CONSTRAINT comment_ibfk_2 FOREIGN KEY (ID_user) REFERENCES user (ID_user);

--
-- Các ràng buộc cho bảng contacts
--
ALTER TABLE contacts
  ADD CONSTRAINT contacts_ibfk_1 FOREIGN KEY (user_id) REFERENCES user (ID_user) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng dessert
--
ALTER TABLE dessert
  ADD CONSTRAINT dessert_ibfk_1 FOREIGN KEY (ID_meal) REFERENCES meal (ID_meal);

--
-- Các ràng buộc cho bảng main_dish
--
ALTER TABLE main_dish
  ADD CONSTRAINT main_dish_ibfk_1 FOREIGN KEY (ID_meal) REFERENCES meal (ID_meal);

--
-- Các ràng buộc cho bảng order
--
ALTER TABLE order
  ADD CONSTRAINT order_ibfk_1 FOREIGN KEY (ID_user) REFERENCES user (ID_user),
  ADD CONSTRAINT order_ibfk_2 FOREIGN KEY (ID_meal) REFERENCES meal (ID_meal);

--
-- Các ràng buộc cho bảng post
--
ALTER TABLE post
  ADD CONSTRAINT post_ibfk_1 FOREIGN KEY (ID_user) REFERENCES user (ID_user);

--
-- Các ràng buộc cho bảng question
--
ALTER TABLE question
  ADD CONSTRAINT question_ibfk_1 FOREIGN KEY (ID_user) REFERENCES user (ID_user);

--
-- Các ràng buộc cho bảng soup
--
ALTER TABLE soup
  ADD CONSTRAINT soup_ibfk_1 FOREIGN KEY (ID_meal) REFERENCES meal (ID_meal);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;