<?php include 'includes/header.php'; ?>

<div class="container d-flex justify-content-center align-items-center" style="min-height:80vh;">
    <div class="card p-4 shadow rounded-4" style="width:400px;">
        
        <h3 class="text-center mb-4 fw-bold">Đăng ký</h3>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger py-2 small border-0 mb-4 text-center">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success py-2 small border-0 mb-4 text-center">
                Đăng ký thành công. Vui lòng đăng nhập.
            </div>
        <?php endif; ?>

        <form action="register_process.php" method="POST">

            <div class="mb-3">
                <input name="name" class="form-control" placeholder="Tên hiển thị" required>
            </div>

            <div class="mb-3">
                <input name="username" class="form-control" placeholder="Username" required>
            </div>

            <div class="mb-3">
                <input name="email" type="email" class="form-control" placeholder="Email" required>
            </div>

            <div class="mb-3">
                <input name="password" type="password" class="form-control" placeholder="Mật khẩu" required>
            </div>

            <div class="mb-3">
                <input name="confirm" type="password" class="form-control" placeholder="Nhập lại mật khẩu" required>
            </div>

            <button class="btn btn-primary w-100">Đăng ký</button>

        </form>

        <div class="text-center mt-3">
            <small>Đã có tài khoản? <a href="login.php">Đăng nhập</a></small>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>
