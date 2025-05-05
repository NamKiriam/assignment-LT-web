<?php include "../auth/auth_check.php"; 
  // $connect = mysqli_connect("localhost",root,"","foodiness_db");

  // $sql = "SELECT * FROM dish";

  // $result = mysqli_query($connect, $sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Thực đơn</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="include/header_footer.css" rel="stylesheet">
</head>
<style>
    .filter-btn {
    background-color: #00c4b4;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 20px;
    cursor: pointer;
    font-size: 16px;
}
</style>
<body>

  <!-- Header bạn đã có sẵn -->
  <?php include("../include/header_home.php"); ?>

    <div class="container_body">
        <!-- Sidebar -->
        <div class="sidebar">
            <h3>GIÁ:</h3>
            <label><input type="range" min="5000" max="500000" value="5000"> 5.000 - 500.000 VND</label>
            <label><input type="checkbox"> Món khô</label>
            <label><input type="checkbox"> Món Nước</label>
            <h3>THỊT:</h3>
            <label><input type="checkbox"> Bò</label>
            <label><input type="checkbox"> Heo</label>
            <label><input type="checkbox"> Gà</label>
            <label><input type="checkbox"> Cá</label>
            <label><input type="checkbox"> Hải Sản</label>
            <label><input type="checkbox"> Chay</label>
            <h3>DINH DƯỠNG:</h3>
            <label><input type="checkbox"> Chất đạm</label>
            <label><input type="checkbox"> Tinh bột</label>
            <label><input type="checkbox"> Chất xơ</label>
            <label><input type="checkbox"> Chất béo</label>
            <label><input type="checkbox"> Vitamin & Khoáng</label>
            <h3>THỨC UỐNG:</h3>
            <label><input type="checkbox"> Nước suối</label>
            <label><input type="checkbox"> Nước ngọt</label>
            <label><input type="checkbox"> Cafe</label>
            <label><input type="checkbox"> Trà</label>
            <button class="filter-btn" onclick="filterDishes()">Lọc</button>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Meal Selection Section -->
            <script>
    let mealCount = 1;

    function addMealSection() {
        mealCount++;

        // Lấy phần tử meal-section đầu tiên
        const mealSection = document.getElementById('meal-section-1');

        // Tạo bản sao của meal-section
        const newMealSection = mealSection.cloneNode(true);

        // Cập nhật id và tiêu đề của phần mới
        newMealSection.id = `meal-section-${mealCount}`;
        newMealSection.querySelector('#meal-number').innerText = `Phần ăn #${mealCount}`;

        // Thêm phần mới vào cuối main-content
        document.querySelector('.main-content').appendChild(newMealSection);
    }
</script>
            <div class="meal-section" id="meal-section-1">
                <h2>Tạo suất ăn <span id="meal-number">Phần ăn #1</span></h2>
                <div class="meal-options">
                    <div>
                        <label>Món chính</label>
                        <select>
                            <option>Chọn món chính</option>    
                            <option>Thịt kho trứng</option>
                            <option>Bò xào</option>
                            <option>Chả giò chiên</option>
                        </select>
                    </div>
                    <div>
                        <label>Canh</label>
                        <select>
                            <option>Chọn món canh</option>
                            <option>Canh cua mồng tơi</option>
                            <option>Canh khổ qua</option>
                            
                        </select>
                    </div>
                    <div>
                        <label>Giải khát</label>
                        <select>
                            <option>Chọn nước uống</option>
                            <option>Nước suối</option>
                            <option>Cafe đen đá</option>
                            
                        </select>
                    </div>
                    <div>
                        <label>Tráng miệng</label>
                        <select>
                            <option>Chọn món tráng miệng</option>
                            <option>Trái cây (tùy ngày)</option>
                            <option>Sữa chua</option>
                            <option>Kem</option>
                        </select>
                    </div>
                    <button class="add-meal-btn" onclick="addMealSection()">+1</button>
                </div>
                <button class="order-btn" href="../Trang_thanh_toan/index.php">Đặt món</button>
            </div>

            <!-- Popular Dishes -->
            <h2>PHỔ BIẾN</h2>
            <div class="popular-dishes">
                <div class="dish-card">
                    <img src="assets/images/thitkhotrung.png" alt="Thịt kho trứng">
                    <h4 class ="bold">Thịt kho trứng</h4>
                    <p>Món khô, thịt heo, bữa trưa</p>
                    <button>Thêm</button>
                </div>
                <div class="dish-card">
                    <img src="assets/images/boxao.png" alt="Bò xào">
                    <h4 class ="bold">Bò xào</h4>
                    <p>Món khô, thịt bò, bữa trưa</p>
                    <button>Thêm</button>
                </div>
                <div class="dish-card">
                    <img src="assets/images/chagiochien.png" alt="Chả giò chiên">
                    <h4 class ="bold">Chả giò chiên</h4>
                    <p>Món khô, thịt heo, bữa trưa</p>
                    <button>Thêm</button>
                </div>
            </div>

            <!-- All Dishes -->
            <h2>TẤT CẢ</h2>
            <div class="category-tabs">
                <button>Sắp xếp: Nổi bật</button>
            </div>
            <div class="popular-dishes">
                <div class="dish-card">
                    <img src="assets/images/canhcua.png" alt="Canh cua mồng tơi">
                    <h4 class ="bold">Canh cua mồng tơi</h4>
                    <p>Món nước, hải sản</p>
                    <button>Thêm</button>
                </div>
                <div class="dish-card">
                    <img src="assets/images/canhkhoqua.png" alt="Canh khổ qua">
                    <h4 class="bold">Canh khổ qua</h4>
                    <p>Món nước, thịt heo</p>
                    <button>Thêm</button>
                </div>
                <div class="dish-card">
                    <img src="assets/images/denda.png" alt="Cafe đen đá">
                    <h4 class ="bold">Cafe đen đá</h4>
                    <p>Cafe</p>
                    <button>Thêm</button>
                </div>
            </div>
        </div>
    </div>


  <!-- Footer bạn đã có sẵn -->
  <?php include("../include/footer_home.php"); ?>
  <script>
    function filterDishes() {
        // Lấy tất cả các checkbox đã được tích
        const checkedOptions = Array.from(document.querySelectorAll('.sidebar input[type="checkbox"]:checked'))
            .map(checkbox => checkbox.parentElement.innerText.trim().toLowerCase());

        // Lấy tất cả các món ăn trong mục "TẤT CẢ"
        const allDishes = document.querySelectorAll('.popular-dishes .dish-card');

        // Nếu không có checkbox nào được chọn, hiển thị tất cả các món ăn
        if (checkedOptions.length === 0) {
            allDishes.forEach(dish => {
                dish.style.display = 'block';
            });
            return;
        }

        // Lọc các món ăn dựa trên các tùy chọn đã tích
        allDishes.forEach(dish => {
            const dishText = dish.innerText.toLowerCase();
            const isMatch = checkedOptions.some(option => dishText.includes(option));
            dish.style.display = isMatch ? 'block' : 'none';
        });
    }
</script>
</body>

</html>