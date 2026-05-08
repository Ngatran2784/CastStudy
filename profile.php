<?php
require_once 'includes/db_config.php';
require_once 'includes/header.php';

// kiểm tra đăng nhập
if (!isset($_SESSION['user'])) {
    die("Bạn chưa đăng nhập!");
}

$id = $_SESSION['user']['ID'];

$result = mysqli_query($conn, "SELECT * FROM user WHERE ID=$id");
$user = mysqli_fetch_assoc($result);

// avatar mặc định
$avatar = $user['Avatar'] ? $user['Avatar'] : 'default.png';
?>

<div class="container mb-5">
    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card shadow-sm p-4">
                <h3 class="fw-bold">Hồ sơ cá nhân</h3>
                <div class="d-flex gap-4 align-items-center mt-3">
                    <img src="uploads/avatars/<?php echo $avatar; ?>" class="rounded-circle border border-primary-subtle" width="140" height="140" style="object-fit: cover;">
                    <div>
                        <p class="mb-1"><strong>Username:</strong> <?php echo htmlspecialchars($user['Username']); ?></p>
                        <p class="mb-1"><strong>Email:</strong> <?php echo htmlspecialchars($user['Email']); ?></p>
                        <p class="mb-0"><strong>Họ và tên:</strong> <?php echo htmlspecialchars($user['Name']); ?></p>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="fw-semibold">Cập nhật thông tin</h5>
                <form action="update_profile.php" method="POST" enctype="multipart/form-data" class="row g-3 mt-2">
                    <div class="col-md-6">
                        <label class="form-label small">Username</label>
                        <input name="username" value="<?php echo htmlspecialchars($user['Username']); ?>" required class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Email</label>
                        <input name="email" type="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required class="form-control">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label small">Họ và tên</label>
                        <input name="name" value="<?php echo htmlspecialchars($user['Name']); ?>" required class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small">Ảnh đại diện</label>
                        <input type="file" name="avatar" accept="image/*" class="form-control">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>

                <hr class="my-4">

                <h5 class="fw-semibold">Đổi mật khẩu</h5>
                <form action="change_password.php" method="POST" class="row g-3 mt-2">
                    <div class="col-md-6">
                        <input type="password" name="old" placeholder="Mật khẩu cũ" required class="form-control">
                    </div>
                    <div class="col-md-6">
                        <input type="password" name="new" placeholder="Mật khẩu mới" required class="form-control">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-outline-primary">Đổi mật khẩu</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card sidebar-card shadow-sm p-4 bg-white mb-4 border-0 rounded-4">
                <h5 class="fw-bold mb-3"><i class="fa-solid fa-user me-2 text-primary"></i> Tùy chọn tài khoản</h5>
                <div class="list-group list-group-flush">
                    <a href="my-rooms.php" class="list-group-item list-group-item-action border-0 px-0">Quản lý tin đăng</a>
                    <a href="post_room.php" class="list-group-item list-group-item-action border-0 px-0">Đăng tin mới</a>
                    <a href="logout.php" class="list-group-item list-group-item-action border-0 px-0 text-danger">Đăng xuất</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
