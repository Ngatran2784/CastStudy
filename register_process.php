<?php
session_start();
include 'includes/db_config.php';

$name = trim($_POST['name'] ?? '');
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm'] ?? '';

if ($name === '' || $username === '' || $email === '' || $password === '' || $confirm === '') {
    header('Location: register.php?error=' . urlencode('Vui lòng điền đầy đủ thông tin.'));
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: register.php?error=' . urlencode('Email không đúng định dạng.'));
    exit;
}

if (strlen($password) < 6) {
    header('Location: register.php?error=' . urlencode('Mật khẩu phải từ 6 ký tự trở lên.'));
    exit;
}

if ($password !== $confirm) {
    header('Location: register.php?error=' . urlencode('Mật khẩu không khớp.'));
    exit;
}

$usernameEscaped = mysqli_real_escape_string($conn, $username);
$emailEscaped = mysqli_real_escape_string($conn, $email);
$nameEscaped = mysqli_real_escape_string($conn, $name);

$checkSql = "SELECT ID FROM user WHERE Username = '$usernameEscaped' OR Email = '$emailEscaped' LIMIT 1";
$checkResult = mysqli_query($conn, $checkSql);
if ($checkResult && mysqli_num_rows($checkResult) > 0) {
    header('Location: register.php?error=' . urlencode('Username hoặc email đã tồn tại.'));
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$insertSql = "INSERT INTO user (Username, Email, Password, Name, role, Avatar) VALUES (?, ?, ?, ?, 1, 'default.png')";
$stmt = mysqli_prepare($conn, $insertSql);
if (!$stmt) {
    header('Location: register.php?error=' . urlencode('Lỗi hệ thống, thử lại sau.'));
    exit;
}

mysqli_stmt_bind_param($stmt, 'ssss', $usernameEscaped, $emailEscaped, $hash, $nameEscaped);
if (mysqli_stmt_execute($stmt)) {
    header('Location: login.php?registered=1');
    exit;
}

header('Location: register.php?error=' . urlencode('Không thể đăng ký, vui lòng thử lại.'));
exit;
