<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<style>
    /* Full-page background */
    .login-wrapper {
        min-height: 100vh;
        width: 100%;
        background: linear-gradient(135deg, #1a3ab8 0%, #0d1f7c 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    /* Watermark Container */
    #watermark-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        overflow: hidden;
        pointer-events: none;
    }

    #watermark-container img {
        position: absolute;
        opacity: 0.10;
        width: 120px;
        object-fit: contain;
    }

    /* Card styling */
    .login-card {
        background-color: #ffffff;
        width: 90%;
        max-width: 420px;
        border-radius: 16px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* shadow-lg */
        padding: 40px;
        z-index: 10;
        position: relative;
    }

    /* Logo section */
    .logos-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }
    .logos-container img {
        width: 70px;
        height: 70px;
        object-fit: contain;
    }

    /* Titles */
    .login-title-main {
        text-align: center;
        font-weight: 700;
        font-size: 22px;
        color: #1a3ab8;
        margin-bottom: 4px;
    }
    .login-title-sub {
        text-align: center;
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 20px;
    }

    /* Divider */
    .login-divider {
        border: 0;
        height: 1px;
        background: #e5e7eb;
        margin-bottom: 24px;
    }

    /* Form Fields */
    .login-form-group {
        margin-bottom: 20px;
    }
    .login-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }
    .login-input-wrapper {
        display: flex;
        align-items: center;
        background: #f3f4f6;
        border-radius: 0.5rem;
    }
    .login-input-icon {
        padding: 0 16px;
        color: #6b7280;
    }
    .login-input {
        flex: 1;
        background: transparent;
        border: none;
        padding: 14px 14px 14px 0;
        font-size: 14px;
        color: #1f2937;
        outline: none;
        width: 100%;
    }
    .login-toggle-pw {
        background: transparent;
        border: none;
        padding: 0 16px;
        color: #6b7280;
        cursor: pointer;
        outline: none;
    }

    /* Button */
    .login-btn {
        width: 100%;
        background: #1a3ab8;
        color: #ffffff;
        border: none;
        border-radius: 0.5rem;
        padding: 14px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s;
        margin-top: 10px;
        margin-bottom: 24px;
    }
    .login-btn:hover {
        background: #142d96;
    }

    /* Footer */
    .login-footer {
        text-align: center;
        font-size: 11px;
        color: #6b7280;
    }
    
    /* Alerts */
    .login-alert {
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-size: 13px;
        text-align: center;
    }
    .login-alert.error { background: #fee2e2; color: #b91c1c; }
    .login-alert.success { background: #d1fae5; color: #047857; }
</style>

<div class="login-wrapper">

    <!-- Background Watermarks -->
    <div id="watermark-container">
        <img src="<?= base_url('assets/img/logo-ngawi-transparent.png') ?>" style="top: 5%; left: 3%; transform: rotate(-20deg);">
        <img src="<?= base_url('assets/img/logo-posyandu-transparent.png') ?>" style="top: 5%; left: 25%; transform: rotate(15deg);">
        <img src="<?= base_url('assets/img/logo-kkn-transparent.jpg') ?>" style="top: 5%; left: 50%; transform: rotate(-10deg);">
        <img src="<?= base_url('assets/img/logo-ngawi-transparent.png') ?>" style="top: 5%; left: 75%; transform: rotate(25deg);">
        
        <img src="<?= base_url('assets/img/logo-posyandu-transparent.png') ?>" style="top: 30%; left: 10%; transform: rotate(10deg);">
        <img src="<?= base_url('assets/img/logo-kkn-transparent.jpg') ?>" style="top: 30%; left: 40%; transform: rotate(-15deg);">
        <img src="<?= base_url('assets/img/logo-ngawi-transparent.png') ?>" style="top: 30%; left: 70%; transform: rotate(20deg);">
        <img src="<?= base_url('assets/img/logo-posyandu-transparent.png') ?>" style="top: 30%; left: 85%; transform: rotate(-5deg);">
        
        <img src="<?= base_url('assets/img/logo-kkn-transparent.jpg') ?>" style="top: 60%; left: 5%; transform: rotate(-25deg);">
        <img src="<?= base_url('assets/img/logo-ngawi-transparent.png') ?>" style="top: 60%; left: 30%; transform: rotate(15deg);">
        <img src="<?= base_url('assets/img/logo-posyandu-transparent.png') ?>" style="top: 60%; left: 60%; transform: rotate(-10deg);">
        <img src="<?= base_url('assets/img/logo-kkn-transparent.jpg') ?>" style="top: 60%; left: 85%; transform: rotate(12deg);">
        
        <img src="<?= base_url('assets/img/logo-ngawi-transparent.png') ?>" style="top: 80%; left: 15%; transform: rotate(20deg);">
        <img src="<?= base_url('assets/img/logo-posyandu-transparent.png') ?>" style="top: 85%; left: 50%; transform: rotate(-5deg);">
        <img src="<?= base_url('assets/img/logo-kkn-transparent.jpg') ?>" style="top: 80%; left: 80%; transform: rotate(-20deg);">
    </div>

    <!-- Login Card -->
    <div class="login-card">
        
        <!-- Logo Section -->
        <div class="logos-container">
            <img src="<?= base_url('assets/img/logo-ngawi-transparent.png') ?>" alt="Desa Kandangan">
            <img src="<?= base_url('assets/img/logo-posyandu-transparent.png') ?>" alt="Posyandu">
            <img src="<?= base_url('assets/img/logo-kkn-transparent.jpg') ?>" alt="KKN 38">
        </div>
        
        <!-- Titles -->
        <div class="login-title-main">SIPOSKA</div>
        <div class="login-title-sub">Sistem Informasi Posyandu Kandangan</div>

        <!-- Divider -->
        <hr class="login-divider">

        <?php if (session()->has('error')): ?>
            <div class="login-alert error">
                <i class="fas fa-exclamation-circle"></i> <?= esc(session('error')) ?>
            </div>
        <?php endif; ?>
        <?php if (session()->has('success')): ?>
            <div class="login-alert success">
                <i class="fas fa-check-circle"></i> <?= esc(session('success')) ?>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form action="<?= site_url('login') ?>" method="POST">
            <?= csrf_field() ?>
            
            <!-- Username -->
            <div class="login-form-group">
                <label class="login-label" for="username">Username</label>
                <div class="login-input-wrapper">
                    <div class="login-input-icon"><i class="fas fa-user"></i></div>
                    <input type="text" id="username" name="username" class="login-input" placeholder="Masukkan username" required autocomplete="username">
                </div>
            </div>

            <!-- Password -->
            <div class="login-form-group">
                <label class="login-label" for="password">Password</label>
                <div class="login-input-wrapper">
                    <div class="login-input-icon"><i class="fas fa-lock"></i></div>
                    <input type="password" id="password" name="password" class="login-input" placeholder="Masukkan password" required autocomplete="current-password">
                    <button type="button" class="login-toggle-pw" onclick="togglePassword()" id="btnToggle" title="Tampilkan/Sembunyikan password">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="login-btn">
                &rarr; Masuk ke Sistem
            </button>
        </form>

        <!-- Footer -->
        <div class="login-footer">
            &copy; 2026 SIPOSKA &mdash; Sistem Informasi Posyandu Kandangan
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        var pwd = document.getElementById("password");
        var btn = document.getElementById("btnToggle");
        if (pwd.type === "password") {
            pwd.type = "text";
            btn.innerHTML = '<i class="fas fa-eye-slash"></i>';
        } else {
            pwd.type = "password";
            btn.innerHTML = '<i class="fas fa-eye"></i>';
        }
    }
</script>
<?= $this->endSection() ?>