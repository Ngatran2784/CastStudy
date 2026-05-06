<?php
session_start();
include 'includes/db_config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$id = $_SESSION['user_id'];
$result = mysqli_query($conn, "SELECT * FROM user WHERE ID=$id");
$user = mysqli_fetch_assoc($result);

$avatar = !empty($user['Avatar']) ? $user['Avatar'] : 'default.png';
include 'includes/header.php';
?>

<section class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="row g-0">
                    <div class="col-md-4 bg-primary text-white d-flex flex-column align-items-center justify-content-center p-4">
                        <img src="uploads/avatars/<?php echo $avatar; ?>" class="rounded-circle border border-3 border-white mb-3" width="140" height="140" style="object-fit: cover;">
                        <h4 class="fw-bold text-center mb-1"><?= htmlspecialchars($user['Name']); ?></h4>
                        <p class="small text-white-75 mb-0">Thành viên</p>
                    </div>
                    <div class="col-md-8 p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <h3 class="fw-bold mb-1">Hồ sơ cá nhân</h3>
                                <p class="text-muted mb-0">Quản lý thông tin tài khoản của bạn.</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted small mb-3">Thông tin tài khoản</h6>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <div class="bg-light rounded-4 p-3">
                                        <div class="small text-muted">Username</div>
                                        <div class="fw-semibold"><?php echo htmlspecialchars($user['Username']); ?></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="bg-light rounded-4 p-3">
                                        <div class="small text-muted">Email</div>
                                        <div class="fw-semibold"><?php echo htmlspecialchars($user['Email']); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted small mb-3">Cập nhật hồ sơ</h6>
                            <form action="update_profile.php" method="POST" enctype="multipart/form-data" class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Họ và tên</label>
                                    <input type="text" name="name" value="<?php echo htmlspecialchars($user['Name']); ?>" class="form-control rounded-pill" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Ảnh đại diện</label>
                                    <input type="file" name="avatar" class="form-control rounded-pill" accept="image/*">
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary rounded-pill px-4">Cập nhật</button>
                                </div>
                            </form>
                        </div>

                        <div>
                            <h6 class="text-uppercase text-muted small mb-3">Đổi mật khẩu</h6>
                            <form action="change_password.php" method="POST" class="row g-3">
                                <div class="col-12 col-md-6">
                                    <input type="password" name="old" class="form-control rounded-pill" placeholder="Mật khẩu cũ" required>
                                </div>
                                <div class="col-12 col-md-6">
                                    <input type="password" name="new" class="form-control rounded-pill" placeholder="Mật khẩu mới" required>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-outline-primary rounded-pill px-4">Đổi mật khẩu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>