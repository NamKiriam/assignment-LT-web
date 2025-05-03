<?php
session_start();
require_once '../include/config.php';

$email = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $stmt = $connection->prepare("SELECT * FROM user WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // So sánh mật khẩu đã mã hóa
        if (password_verify($password, $user['Password'])) {
            $_SESSION['user_id'] = $user['ID_user'];
            $_SESSION['user_name'] = $user['User_name'];
            $_SESSION['email'] = $user['Email'];

            header("Location: ../Trang_chu/home.php");
            exit();
        } else {
            $error = "Mật khẩu không đúng.";
        }
    } else {
        $error = "Tài khoản không tồn tại.";
    }

    $stmt->close();
    $connection->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng nhập</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../include/header_footer.css">
</head>

<body class="bg-light">

<?php include '../include/header_home.php'; ?>

<div class="container mt-5">
  <div class="card mx-auto" style="max-width: 600px;">
    <div class="card-body">

        <h3 class="card-title text-center mb-4">Đăng nhập</h3>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100 fw-bold">Đăng nhập</button>
            <a href="forgot_password.php" class="text-decoration-underline">Quên mật khẩu?</a> </br>
            <a href="signup.php" class="text-decoration-underline">Chưa có tài khoản? Đăng ký!</a>
        </form>
    </div>
  </div>
</div>

</body>

</html>
