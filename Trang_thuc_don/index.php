<?php include "../auth/auth_check.php"; 
  $connect = mysqli_connect("localhost",root,"","foodiness_db");

  $sql = "SELECT * FROM dish";

  $result = mysqli_query($connect, $sql);
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
</head>
<body>

  <!-- Header bạn đã có sẵn -->
  <?php include("../include/header_home.php"); ?>

    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h3>GIÁ:</h3>
            <label><input type="range" min="5000" max="500000" value="5000"> 5.000 - 500.000 VND</label>
            <label><input type="checkbox"> Món Khô</label>
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
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Meal Selection Section -->
            <div class="meal-section" id="meal-section-1">
                <h2>Tạo suất ăn <span id="meal-number">Phần ăn #1</span></h2>
                <div class="meal-options">
                    <div>
                        <label>Món chính</label>
                        <div class="autocomplete">
                            <input type="text" id="main-dish-1" placeholder="Chọn món">
                            <div id="autocomplete-list-1" class="autocomplete-items"></div>
                        </div>
                    </div>
                    <div>
                        <label>Canh</label>
                        <select>
                            <option>Chọn nước</option>
                            <option>Canh rau</option>
                            <option>Canh chua</option>
                        </select>
                    </div>
                    <div>
                        <label>Giải khát</label>
                        <select>
                            <option>Chọn nước</option>
                            <option>Nước ngọt</option>
                            <option>Cafe</option>
                        </select>
                    </div>
                    <div>
                        <label>Tráng miệng</label>
                        <select>
                            <option>Trái cây, đồ ngọt...</option>
                            <option>Trái cây</option>
                            <option>Bánh ngọt</option>
                        </select>
                    </div>
                    <button class="add-meal-btn" onclick="addMealSection()">+1</button>
                </div>
                <button class="order-btn">Đặt món</button>
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
                    <img src="https://via.placeholder.com/150" alt="Bánh Xèo">
                    <h2>BÁNH XÈO</h2><br>Món khô, thịt heo, dùng-trưa</p>
                    <button>Thêm</button>
                </div>
                <div class="dish-card">
                    <img src="https://via.placeholder.com/150" alt="Món Súp Cua">
                    <p>MÓN SÚP CUA<br>Món nước, hải sản</p>
                    <button>Thêm</button>
                </div>
                <div class="dish-card">
                    <img src="https://via.placeholder.com/150" alt="Cafe Đen">
                    <p>CAFE ĐEN<br>Cafe, dùng-bữa</p>
                    <button>Thêm</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simulated database of dishes
        const dishes = [
            "Phở Bò",
            "Bánh Mì Xíu",
            "Bún Chả",
            "Bánh Xèo",
            "Món Súp Cua",
            "Cafe Đen",
            "Cơm Tấm",
            "Hủ Tiếu",
            "Gỏi Cuốn",
            "Chả Giò"
        ];

        // Autocomplete functionality
        function setupAutocomplete(inputId, listId) {
            const input = document.getElementById(inputId);
            const list = document.getElementById(listId);

            input.addEventListener("input", function() {
                const val = this.value.toLowerCase();
                list.innerHTML = "";

                if (!val) return;

                const matches = dishes.filter(dish => dish.toLowerCase().includes(val));
                matches.forEach(dish => {
                    const div = document.createElement("div");
                    div.textContent = dish;
                    div.addEventListener("click", function() {
                        input.value = dish;
                        list.innerHTML = "";
                    });
                    list.appendChild(div);
                });
            });

            document.addEventListener("click", function(e) {
                if (e.target !== input) {
                    list.innerHTML = "";
                }
            });
        }

        // Initialize autocomplete for the first section
        setupAutocomplete("main-dish-1", "autocomplete-list-1");

        // Add new meal section
        let mealCount = 1;
        function addMealSection() {
            mealCount++;
            const newSection = document.createElement("div");
            newSection.className = "meal-section";
            newSection.id = `meal-section-${mealCount}`;
            newSection.innerHTML = `
                <h2>Tạo suất ăn <span id="meal-number">Phần ăn #${mealCount}</span></h2>
                <div class="meal-options">
                    <div>
                        <label>Món chính</label>
                        <div class="autocomplete">
                            <input type="text" id="main-dish-${mealCount}" placeholder="Chọn món">
                            <div id="autocomplete-list-${mealCount}" class="autocomplete-items"></div>
                        </div>
                    </div>
                    <div>
                        <label>Canh</label>
                        <select>
                            <option>Chọn nước</option>
                            <option>Canh rau</option>
                            <option>Canh chua</option>
                        </select>
                    </div>
                    <div>
                        <label>Giải khát</label>
                        <select>
                            <option>Chọn nước</option>
                            <option>Nước ngọt</option>
                            <option>Cafe</option>
                        </select>
                    </div>
                    <div>
                        <label>Tráng miệng</label>
                        <select>
                            <option>Trái cây, đồ ngọt...</option>
                            <option>Trái cây</option>
                            <option>Bánh ngọt</option>
                        </select>
                    </div>
                    <button class="add-meal-btn" onclick="addMealSection()">+1</button>
                </div>
                <button class="order-btn">Đặt món</button>
            `;
            document.querySelector(".main-content").insertBefore(newSection, document.querySelector(".main-content").children[1]);
            setupAutocomplete(`main-dish-${mealCount}`, `autocomplete-list-${mealCount}`);
        }
    </script>

  <!-- Footer bạn đã có sẵn -->
  <?php include("../include/footer_home.php"); ?>

</body>

</html>