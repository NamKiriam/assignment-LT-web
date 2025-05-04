<?php
session_start();
require_once '../include/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";
$password_error = "";
$password_success = "";

// Load thông tin user
$stmt = $connection->prepare("SELECT * FROM user WHERE ID_user = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Cập nhật thông tin chung
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_profile'])) {
    $username = trim($_POST['username']);
    $birthday = $_POST['birthday'] ?? null;
    $address = trim($_POST['address']);

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'upload/';
        $avatar_name = basename($_FILES['avatar']['name']);
        $avatar_path = $upload_dir . $avatar_name;

        move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar_path);
        $user['Avatar'] = 'Trang_profile/upload/' . $avatar_name;
    }

    $user['Username'] = $username;
    $user['Birthday'] = $birthday;
    $user['Address'] = $address;

    $stmt = $connection->prepare("UPDATE user SET Username = ?, Birthday = ?, Address = ?, Avatar = ? WHERE ID_user = ?");
    $stmt->bind_param("ssssi", $username, $birthday, $address, $user['Avatar'], $user_id);
    $stmt->execute();

    $message = "Cập nhật thông tin thành công!";
}

// // Đổi mật khẩu
// if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['change_password'])) {
//     $old_pass = $_POST['old_password'];
//     $new_pass = $_POST['new_password'];
//     $confirm_pass = $_POST['confirm_password'];

//     if (!password_verify($old_pass, $user['Password'])) {
//         $password_error = "Mật khẩu cũ không đúng.";
//     } elseif ($new_pass !== $confirm_pass) {
//         $password_error = "Mật khẩu mới không khớp.";
//     } else {
//         $hashed = password_hash($new_pass, PASSWORD_DEFAULT);
//         $stmt = $connection->prepare("UPDATE user SET Password = ? WHERE ID_user = ?");
//         $stmt->bind_param("si", $hashed, $user_id);
//         $stmt->execute();

//         $password_success = "Đổi mật khẩu thành công!";
//     }
// }
// ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang cá nhân</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../include/header_footer.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .profile-container {
            max-width: 850px;
            margin: 30px auto;
        }
    </style>
</head>
<body class="bg-light">

<?php include '../include/header_home.php'; ?>

<div class="container profile-container">
    <div class="card p-4 shadow">
        <h3 class="text-center mb-4">Trang cá nhân</h3>

        <?php if ($message): ?>
            <div class="alert alert-success text-center"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="row g-4">
            <input type="hidden" name="update_profile" value="1">

            <!-- Avatar -->
            <div class="col-md-4 text-center">
                <img src="../<?= htmlspecialchars($user['Avatar'] ?? 'Trang_profile/upload/default_avatar.png') ?>"
                    class="rounded-circle mb-3" alt="Avatar" width="150" height="150">
                <input type="file" name="avatar" class="form-control">
            </div>

            <!-- Thông tin -->
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label">Họ tên</label>
                    <input type="text" name="username" value="<?= htmlspecialchars($user['Username']) ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" value="<?= htmlspecialchars($user['Email']) ?>" class="form-control" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ngày sinh</label>
                    <input type="date" name="birthday" value="<?= $user['Birthday'] ?>" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Địa chỉ</label>
                    <textarea name="address" class="form-control" rows="3"><?= htmlspecialchars($user['Address']) ?></textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success px-4">Cập nhật</button>
                </div>
            </div>
        </form>

        <!-- <hr class="my-4">

        <h5 class="mb-3">Đổi mật khẩu</h5>

        <?php if ($password_error): ?>
            <div class="alert alert-danger"><?= $password_error ?></div>
        <?php elseif ($password_success): ?>
            <div class="alert alert-success"><?= $password_success ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="change_password" value="1">

            <div class="mb-3">
                <label class="form-label">Mật khẩu hiện tại</label>
                <input type="password" name="old_password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Mật khẩu mới</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Xác nhận mật khẩu mới</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
            </div>
        </form> -->
    </div>
</div>

</body>
</html>
