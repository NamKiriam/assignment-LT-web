<?php
require_once '../include/config.php';

// Lấy nội dung từ site_content
$content = [];
$stmt = $connection->prepare("SELECT section, content FROM site_content WHERE page = 'home'");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $content[$row['section']] = $row['content'];
}
$stmt->close();
?>

<?php include("../include/header_home.php"); ?>
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
  <link href="assets/home.css" rel="stylesheet">
</head>
<body>

<!-- Hero -->
<section class="hero position-relative">
  <img src="assets/picture/fine_dinner.png" class="w-100 hero-img" alt="Hero Image">
  <div class="hero-content position-absolute top-50 start-50 translate-middle p-4">
    <h1 class="fw-bold text-uppercase text-danger"><?= $content['hero_title'] ?? '' ?></h1>
    <p class="mb-4 text-start text-white"><?= $content['hero_intro'] ?? '' ?></p>
    <a href="../Trang_thuc_don/index.php" class="btn btn-success fw-semibold px-4 py-2"><?= $content['hero_button'] ?? 'Đặt món ngay' ?></a>
  </div>
</section>

<!-- Vì sao chọn -->
<section class="why-choose py-5">
  <div class="container text-center">
    <h2 class="fw-bold"><?= $content['why_title'] ?? '' ?></h2>
    <img src="assets/picture/chop_food.png" alt="subordinate-img" height="50">
    <p class="mb-5"><?= $content['why_text'] ?? '' ?></p>
    <div class="row g-4 features">
      <?= $content['why_items'] ?? '' ?>
    </div>
  </div>
</section>

<!-- Quy trình đặt suất ăn online -->
<section class="order-process py-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="process-box p-4">
          <h5 class="fw-bold text-dark mb-3"><?= $content['steps_title'] ?? '' ?></h5>
          <p class="mb-4 text-dark">Một số khách hàng mà đặt cơm lần đầu còn chưa quen với cách thức đặt hàng, sau đây là bảng tóm tắt quy trình đặt hàng của chúng tôi:</p>
          <?= $content['steps_list'] ?? '' ?>
        </div>
      </div>
      <div class="col-md-6 text-center">
        <img src="assets/picture/order_online.png" alt="Order Online" class="img-fluid process-img">
      </div>
    </div>
  </div>
</section>

<!-- Khách hàng nói gì -->
<?= $content['testimonial'] ?? '' ?>

<?php include("../include/footer_home.php"); ?>
</body>
</html>
