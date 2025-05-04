<?php include "../auth/auth_check.php"; require_once '../include/config.php'?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Toàn bộ thực đơn món ăn cho bạn lựa chọn">
    <meta name="keywords" content="đặt thức ăn trưa, dịch vụ giao cơm, thực đơn văn phòng, chất lượng, tận tâm">
    <title>Thực đơn</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- External CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Montserrat fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>
<body>

<!-- Navbar -->
<section class="navbar navbar-expand-lg navbar-dark bg-success px-3">
  <a class="navbar-brand" href="#">
    <img src="../Trang_chu/assets/picture/foodiness.png" alt="Logo" height="">
  </a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a class="nav-link text-white" href="../Trang_chu/home.php">Trang chủ</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="../Trang_gioi_thieu/index.php">Giới thiệu</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="../Trang_hoi_dap/index.php">Hỏi đáp</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="../Trang_thuc_don/index.php">Thực đơn</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="../Trang_bai_viet/user/index.php">Bài viết</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="../Trang_lien_he/contact.phpphp">Liên hệ</a></li>
    </ul>

    <a href="../auth/login.php">
      <img src="../Trang_chu/assets/picture/user_icon.png" alt="Login Icon" class="user-icon">
    </a>

  </div>
</section>

    <!-- Main Content -->
<!-- body.html -->
<div class="page-body">
    <!-- Sidebar filters -->
    <aside class="sidebar">
      <form class="filters">
        <h2>Giá</h2>
        <input type="range" min="5000" max="500000" step="5000" />
  
        <h2>Loại món</h2>
        <label><input type="radio" name="type" value="kho" /> Món khô</label>
        <label><input type="radio" name="type" value="nuoc" /> Món nước</label>
  
        <h2>Thịt</h2>
        <label><input type="radio" name="meat" value="bo" /> Bò</label>
        <label><input type="radio" name="meat" value="heo" /> Heo</label>
        <label><input type="radio" name="meat" value="ga" /> Gà</label>
        <label><input type="radio" name="meat" value="ca" /> Cá</label>
        <label><input type="radio" name="meat" value="haisan" /> Hải sản</label>
  
        <h2>Dinh dưỡng</h2>
        <label><input type="radio" name="nutri" value="protein" /> Chất đạm</label>
        <label><input type="radio" name="nutri" value="starch" /> Tinh bột</label>
        <label><input type="radio" name="nutri" value="fiber" /> Chất xơ</label>
        <label><input type="radio" name="nutri" value="fat" /> Chất béo</label>
        <label><input type="radio" name="nutri" value="vitamin" /> Vitamin & Khoáng</label>
  
        <h2>Nước</h2>
        <label><input type="radio" name="drink" value="nuocsuoi" /> Nước suối</label>
        <label><input type="radio" name="drink" value="nuocngot" /> Nước ngọt</label>
        <label><input type="radio" name="drink" value="cafe" /> Cafe</label>
        <label><input type="radio" name="drink" value="tra" /> Trà</label>
      </form>
    </aside>
  
    <!-- Main content -->
    <main class="main-content">
        <body>

  <!-- Giỏ hàng -->
  <div id="cart">
    Giỏ hàng: <span id="cart-count">0</span> phần
  </div>

  <div class="meal-card">
    <h1>Phần ăn #1</h1>

    <div class="section">
      <p class="section-title">Món chính</p>
      <div class="row">
        <input type="text" list="main-dishes" placeholder="Chọn món">
        <input type="text" list="soups"      placeholder="Canh">
      </div>
      <datalist id="main-dishes">
        <option value="Thịt kho tàu">
        <option value="Cá chiên">
        <option value="Gà nướng">
        <option value="Đậu sốt">
      </datalist>
      <datalist id="soups">
        <option value="Canh rau củ">
        <option value="Canh nấm">
        <option value="Canh rong biển">
      </datalist>
    </div>

    <div class="section">
      <p class="section-title">Giải khát</p>
      <input type="text" list="drinks" placeholder="Chọn nước">
      <datalist id="drinks">
        <option value="Nước suối">
        <option value="Trà đá">
        <option value="Nước cam">
        <option value="Soda">
      </datalist>
    </div>

    <div class="section">
      <p class="section-title">Tráng miệng</p>
      <input type="text" list="desserts" placeholder="Trái cây, đồ ngọt,...">
      <datalist id="desserts">
        <option value="Dưa hấu">
        <option value="Xoài">
        <option value="Bánh flan">
        <option value="Chè sen">
      </datalist>
    </div>

    <div class="section">
      <textarea placeholder="Ghi chú"></textarea>
    </div>

    <!-- Nút +1 thêm món -->
    <button class="add-btn" onclick="addMeal()">+1</button>
  </div>

  <script>
    let cartCount = 0;
    function addMeal() {
      cartCount++;
      document.getElementById('cart-count').textContent = cartCount;
      // TODO: ở đây bạn có thể gọi API hoặc lưu localStorage...
    }
  </script>
  
      <!-- Popular items -->
      <section class="popular">
        <h2>PHỔ BIẾN</h2>
        <div class="cards">
          <article class="card">
            <div class="img-wrap">
              <img src="res/thitkhotrung.png" alt="Thịt kho trứng" />
            </div>
            <h3>Thịt kho trứng</h3>
            <p class="meta">Món nước, thịt bò, buổi sáng-trưa</p>
            <button class="btn">Thêm</button>
          </article>
          <article class="card">
            <div class="img-wrap">
              <img src="res/boxao.png" alt="Bò xào" />
            </div>
            <h3>Bò xào</h3>
            <p class="meta">Món khô, thịt heo, buổi sáng</p>
            <button class="btn">Thêm</button>
          </article>
          <article class="card">
            <div class="img-wrap">
              <img src="res/chagiochien.png" alt="Chả giò chiên" />
            </div>
            <h3>Chả giò chiên</h3>
            <p class="meta">Món nước, thịt heo, buổi trưa</p>
            <button class="btn">Thêm</button>
          </article>
        </div>
        <a href="#" class="see-more">Xem thêm »»</a>
      </section>
  
      <!-- Category tabs + product grid -->
      <section class="catalog">
        <nav class="tabs">
          <a href="#" class="active">Tất cả</a>
          <a href="#">Món chính</a>
          <a href="#">Canh</a>
          <a href="#">Chay</a>
          <a href="#">Tráng miệng</a>
          <a href="#">Giải khát</a>
          <span class="sort">Sắp xếp: Nổi bật</span>
        </nav>
  
        <div class="product-grid">
          <article class="product-card">
            <div class="img-wrap">
              <img src="path-to-your-image.jpg" alt="Bánh xèo" />
            </div>
            <h3>BÁNH XÈO</h3>
            <p class="meta">Món khô, thịt heo, hải sản, buổi trưa</p>
            <button class="btn">Thêm</button>
          </article>
          <article class="product-card">
            <div class="img-wrap">
              <img src="path-to-your-image.jpg" alt="Súp cua" />
            </div>
            <h3>SÚP CUA</h3>
            <p class="meta">Món nước, buổi sáng</p>
            <button class="btn">Thêm</button>
          </article>
          <article class="product-card">
            <div class="img-wrap">
              <img src="path-to-your-image.jpg" alt="Cafe đen" />
            </div>
            <h3>CAFE ĐEN</h3>
            <p class="meta">Cafe, buổi sáng</p>
            <button class="btn">Thêm</button>
          </article>
          <!-- more items... -->
        </div>
      </section>
    </main>
  </div>
  


<!-- Footer -->
<footer class="bg-footer text-dark py-4">
  <div class="container">
    <div class="row justify-content-between">
      <!-- Cột trái: logo + liên hệ -->
      <div class="col-md-6 mb-4">
        <a href="#" class="navbar-brand d-block mb-3">
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
          <a href="../Trang_hoi_dap/index.php" class="fw-bold text-dark me-3">Hỏi đáp</a>
          <a href="../Trang_thuc_don/index.php" class="fw-bold text-dark me-3">Thực đơn</a>
          <a href="#" class="fw-bold text-dark me-3">Bài viết</a>
          <a href="#" class="fw-bold text-dark">Liên hệ</a>
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
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>