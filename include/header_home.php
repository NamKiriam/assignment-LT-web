<!-- <?php session_start(); ?> -->
 
<!--Navbar-->
<section class="navbar navbar-expand-lg navbar-dark bg-success px-3">
  <a class="navbar-brand" href="#">
    <img src="../Trang_chu/assets/picture/foodiness.png" alt="Logo">
  </a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a class="nav-link text-white" href="../Trang_chu/home.php">Trang chủ</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="../Trang_gioi_thieu/index.php">Giới thiệu</a></li>

      <?php if (isset($_SESSION['user_id'])): ?>
        <li class="nav-item"><a class="nav-link text-white" href="../Trang_thuc_don/index.php">Thực đơn</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="../Trang_bai_viet/index.php">Bài viết</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="../Trang_lien_he/contact.php">Liên hệ</a></li>
        <li class="nav-item"><a class="nav-link text-white fw-semibold" href="../auth/logout.php">Đăng xuất</a></li>
        <a href="../Trang_profile/profile.php">
          <img src="../Trang_chu/assets/picture/user_icon.png" alt="Login Icon" class="user-icon">
        </a>
      <?php else: ?>
        <li class="nav-item"><a class="nav-link text-white fw-semibold" href="../auth/login.php">Đăng nhập</a></li>
      <?php endif; ?>
    </ul>
  </div>
</section>