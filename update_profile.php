<?php
session_start();
include 'includes/db_config.php';

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['ID'])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION['user']['ID'];
$username = isset($_POST['username']) ? mysqli_real_escape_string($conn, trim($_POST['username'])) : '';
$email = isset($_POST['email']) ? mysqli_real_escape_string($conn, trim($_POST['email'])) : '';
$name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';

// Validate
if (empty($username)) {
    die("Username không được để trống!");
}

if (empty($email)) {
    die("Email không được để trống!");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Email không hợp lệ!");
}

if (empty($name)) {
    die("Họ và tên không được để trống!");
}

// Kiểm tra username có trùng không (ngoài user hiện tại)
$check_username = mysqli_query($conn, "SELECT ID FROM user WHERE Username='$username' AND ID != $id");
if (mysqli_num_rows($check_username) > 0) {
    die("Username đã tồn tại!");
}

// Kiểm tra email có trùng không (ngoài user hiện tại)
$check_email = mysqli_query($conn, "SELECT ID FROM user WHERE Email='$email' AND ID != $id");
if (mysqli_num_rows($check_email) > 0) {
    die("Email đã tồn tại!");
}

// xử lý avatar
if (!empty($_FILES['avatar']['name'])) {
    $file = $_FILES['avatar'];
    
    // Kiểm tra file
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (!in_array($ext, $allowed)) {
        die("Chỉ chấp nhận file ảnh (jpg, jpeg, png, gif)");
    }
    
    if ($file['size'] > 5 * 1024 * 1024) { // 5MB
        die("File quá lớn (tối đa 5MB)");
    }
    
    $filename = time() . "_" . basename($file['name']);
    $target = "uploads/avatars/" . $filename;

    if (move_uploaded_file($file['tmp_name'], $target)) {
        $filename = mysqli_real_escape_string($conn, $filename);
        $sql = "UPDATE user SET Username='$username', Email='$email', Name='$name', Avatar='$filename' WHERE ID=$id";
    } else {
        die("Lỗi upload file");
    }
} else {
    $sql = "UPDATE user SET Username='$username', Email='$email', Name='$name' WHERE ID=$id";
}

mysqli_query($conn, $sql);

// Cập nhật lại session với dữ liệu mới
$result = mysqli_query($conn, "SELECT * FROM user WHERE ID=$id");
$user = mysqli_fetch_assoc($result);
unset($user['Password']);
$_SESSION['user'] = $user;

header("Location: profile.php");
?>
