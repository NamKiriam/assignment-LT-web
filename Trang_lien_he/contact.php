<?php
include "../auth/auth_check.php";
require_once '../include/config.php';

$contact_success = '';
$contact_error = '';

// Xử lý khi người dùng gửi form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'] ?? null;
    $message = trim($_POST['message'] ?? '');

    if ($user_id && !empty($message)) {
        $stmt = $connection->prepare("INSERT INTO contacts (user_id, message, status, created_at) VALUES (?, ?, 'unread', NOW())");
        $stmt->bind_param("is", $user_id, $message);
        if ($stmt->execute()) {
            $contact_success = "Liên hệ của bạn đã được gửi thành công!";
        } else {
            $contact_error = "Lỗi khi gửi liên hệ.";
        }
        $stmt->close();
    } else {
        $contact_error = "Vui lòng nhập nội dung liên hệ.";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Foodiness - Cơm trưa văn phòng</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="contact.css" rel="stylesheet">
</head>

<body>
<?php include("../include/header_home.php"); ?>

<section class="contact-form-section py-5">
  <div class="container">

    <!-- Thông báo -->
    <?php if (!empty($contact_success)): ?>
      <div class="alert alert-success"><?= $contact_success ?></div>
    <?php elseif (!empty($contact_error)): ?>
      <div class="alert alert-danger"><?= $contact_error ?></div>
    <?php endif; ?>

    <div class="row">
      <!-- Form liên hệ -->
      <div class="col-md-6">
        <h2 class="mb-4 fw-bold">Liên hệ với chúng tôi</h2>
        <form method="post">
          <!-- Các trường không cần name vì không gửi -->
          <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Họ và tên</label>
            <input type="text" class="form-control" id="name" placeholder="Nhập họ tên của bạn">
          </div>
          <div class="mb-3">
            <label for="birthday" class="form-label fw-semibold">Ngày sinh</label>
            <input type="date" class="form-control" id="birthday">
          </div>
          <div class="mb-3">
            <label for="gender" class="form-label fw-semibold">Giới tính</label>
            <select id="gender" class="form-select">
              <option value="">-- Chọn giới tính --</option>
              <option value="Nam">Nam</option>
              <option value="Nữ">Nữ</option>
              <option value="Khác">Khác</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Nhập email">
          </div>
          <div class="mb-3">
            <label for="phone" class="form-label fw-semibold">SĐT</label>
            <input type="tel" class="form-control" id="phone" placeholder="Nhập số điện thoại">
          </div>
          <div class="mb-3">
            <label for="address" class="form-label fw-semibold">Địa chỉ</label>
            <input type="text" class="form-control" id="address" placeholder="Nhập địa chỉ...">
          </div>
          <!-- Đây mới là nội dung được lưu -->
          <div class="mb-3">
            <label for="message" class="form-label fw-semibold">Nội dung liên hệ</label>
            <textarea name="message" class="form-control" id="message" rows="5" placeholder="Nhập nội dung..."></textarea>
          </div>
          <button type="submit" class="btn btn-success px-4 fw-bold">Gửi liên hệ</button>
        </form>
      </div>

      <!-- Bản đồ -->
      <div class="col-md-6 mt-5 mt-md-0 map-wrapper">
        <h4 class="mb-3 fw-bold">Bản đồ</h4>
        <div class="ratio ratio-16x9">
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.3529!2d106.6640085!3d10.7810426!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f3d003123ff%3A0x9fbcd1b96dbf4f4b!2zS0NOIFTDom4gQsOgaW5o!5e0!3m2!1svi!2s!4v1682686501234!5m2!1svi!2s"
          width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include("../include/footer_home.php"); ?>
</body>
</html>
