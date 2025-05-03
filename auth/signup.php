<?php
require_once '../include/config.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];

    // Kiểm tra dữ liệu
    if (empty($fullname) || empty($email) || empty($password)) {
        $errors[] = "Vui lòng điền đầy đủ thông tin bắt buộc.";
    } else {
        // Kiểm tra email đã tồn tại
        $stmt = $connection->prepare("SELECT ID_user FROM user WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = "Email đã được sử dụng.";
        } else {
            // Mã hóa mật khẩu và chèn dữ liệu
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $connection->prepare("INSERT INTO user (Username, Email, Password, Gender, Birthday) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $fullname, $email, $hashed, $gender, $birthday);

            if ($stmt->execute()) {
                $success = "Đăng ký thành công! Bạn có thể đăng nhập.";
            } else {
                $errors[] = "Đăng ký thất bại. Vui lòng thử lại.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng ký tài khoản</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../include/header_footer.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">

<?php include '../include/header_home.php'; ?>

<div class="container mt-5">
  <div class="card mx-auto" style="max-width: 600px;">
    <div class="card-body">
      <h3 class="card-title text-center mb-4">Đăng ký tài khoản</h3>

      <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
      <?php elseif ($errors): ?>
        <div class="alert alert-danger">
          <?php foreach ($errors as $e) echo "<p>$e</p>"; ?>
        </div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Họ tên</label>
          <input type="text" name="fullname" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Mật khẩu</label>
          <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Giới tính</label>
          <select name="gender" class="form-select">
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
            <option value="Không tiết lộ">Không tiết lộ</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Ngày sinh</label>
          <input type="date" name="birthday" class="form-control">
        </div>

        <button type="submit" class="btn btn-success w-100 fw-bold">Đăng ký</button>
        <a href="login.php" class="text-decoration-underline">Đăng nhập!</a>
      </form>
    </div>
  </div>
</div>


</body>
</html>
