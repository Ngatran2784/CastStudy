<?php
session_start();
include 'includes/db_config.php';
require_once 'includes/header.php';

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['ID'])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION['user']['ID'];
$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $old = isset($_POST['old']) ? trim($_POST['old']) : '';
    $new = isset($_POST['new']) ? trim($_POST['new']) : '';

    if (empty($old) || empty($new)) {
        $error = "Mật khẩu không được để trống!";
    } elseif (strlen($new) < 6) {
        $error = "Mật khẩu mới phải tối thiểu 6 ký tự!";
    } else {
        // lấy password cũ từ DB
        $result = mysqli_query($conn, "SELECT Password FROM user WHERE ID=$id");
        if (!$result) {
            $error = "Lỗi truy vấn database!";
        } else {
            $user = mysqli_fetch_assoc($result);
            if (!$user) {
                $error = "Không tìm thấy người dùng!";
            } elseif (!password_verify($old, $user['Password'])) {
                $error = "Mật khẩu cũ sai!";
            } else {
                // hash password mới
                $new_hash = password_hash($new, PASSWORD_DEFAULT);

                // update
                $update_result = mysqli_query($conn, "UPDATE user SET Password='$new_hash' WHERE ID=$id");
                if ($update_result) {
                    $success = true;
                } else {
                    $error = "Cập nhật mật khẩu";
                }
            }
        }
    }
}
?>

<div class="container mb-5">
    <div class="row mt-4">
        <div class="col-lg-6 offset-lg-3">
            <div class="card shadow-sm p-4">
                <h3 class="fw-bold mb-4">Đổi mật khẩu</h3>

                <?php if ($success): ?>
                    <div class="alert alert-success" role="alert" style="color: #1b5e20; background-color: #e8f5e9; border: 1px solid #4caf50; padding: 12px; border-radius: 4px;">
                        <strong>✓ Thành công!</strong> Đổi mật khẩu thành công. Chuyển hướng trong 2 giây...
                    </div>
                    <script>
                        setTimeout(function() {
                            window.location.href = 'profile.php';
                        }, 2000);
                    </script>
                <?php elseif ($error): ?>
                    <div class="alert alert-danger" role="alert" style="color: #d32f2f; background-color: #ffebee; border: 1px solid #ef5350; padding: 12px; border-radius: 4px;">
                        <strong>✗ Lỗi:</strong> <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <?php if (!$success): ?>
                <form method="POST" class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Mật khẩu cũ</label>
                        <input type="password" name="old" required class="form-control" placeholder="Nhập mật khẩu cũ">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Mật khẩu mới</label>
                        <input type="password" name="new" required class="form-control" placeholder="Nhập mật khẩu mới (tối thiểu 6 ký tự)">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                        <a href="profile.php" class="btn btn-secondary">Quay lại</a>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
