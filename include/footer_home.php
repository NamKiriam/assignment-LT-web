<?php
require_once '../include/config.php';
$content = [];
$result = $connection->query("SELECT section, content FROM site_content WHERE page = 'home'");
while ($row = $result->fetch_assoc()) {
    $content[$row['section']] = $row['content'];
}
$connection->close();
?>

<!-- Footer -->
<footer class="bg-footer text-dark py-4">
  <div class="container">
    <div class="row justify-content-between">
      <!-- Cột trái: logo + liên hệ -->
      <div class="col-md-6 mb-4">
        <a href="../Trang_chu/home.php" class="navbar-brand d-block mb-3">
          <img src="../Trang_chu/assets/picture/foodiness.png" alt="Foodiness Logo" height="50">
        </a>
        <h5 class="fw-bold mb-3">Liên hệ</h5>
        <p><i class="bi bi-envelope me-2"></i>Email: info@foodiness.vn</p>
        <p><i class="bi bi-telephone me-2"></i>Hotline: 0123 456 789</p>
        <p><i class="bi bi-geo-alt me-2"></i>CS sản xuất: KCN Tân Bình, TP.HCM</p>
        <p><i class="bi bi-building me-2"></i>Văn phòng: Quận 1, TP.HCM</p>
      </div>

      <!-- Cột phải: nav + mạng xã hội -->
      <div class="col-md-5 text-md-end text-start">
        <nav class="mb-33">
          <a href="../Trang_chu/home.php" class="fw-bold text-dark me-3">Trang chủ</a>
          <a href="../Trang_gioi_thieu/index.php" class="fw-bold text-dark me-3">Giới thiệu</a>

          <?php if (isset($_SESSION['user_id'])): ?>
            <a href="../Trang_hoi_dap/index.php" class="fw-bold text-dark me-3">Hỏi đáp</a>
            <a href="../Trang_thuc_don/index.php" class="fw-bold text-dark me-3">Thực đơn</a>
            <a href="#" class="fw-bold text-dark me-3">Bài viết</a>
            <a href="../Trang_lien_he/contact.php" class="fw-bold text-dark">Liên hệ</a>
          <?php endif; ?>
        </nav>

        <h6 class="fw-bold mb-3">Mạng xã hội</h6>
        <div class="d-flex gap-3 justify-content-md-end justify-content-start">
          <a href="#"><i class="fab fa-facebook fa-2x social-icon facebook"></i></a>
          <a href="#"><i class="fab fa-tiktok fa-2x social-icon tiktok"></i></a>
          <a href="#"><i class="fab fa-x-twitter fa-2x social-icon x"></i></a>
          <a href="#"><i class="fab fa-instagram fa-2x social-icon instagram"></i></a>
        </div>
      </div>
    </div>
  </div>
</footer>