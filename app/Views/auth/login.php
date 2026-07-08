<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<style>
    /* ===== BACKGROUND ===== */
    .auth-main-container {
        background: linear-gradient(135deg, #0f2d69 0%, #1a56db 50%, #0f2d69 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        position: relative;
        overflow: hidden;
    }

    /* ===== DEKORASI (9 Logos Scattered) ===== */
    .auth-watermarks-grid {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        pointer-events: none;
        z-index: 0;
        opacity: 0.08;
        /* Lebih transparan agar tidak mengganggu tapi besar */
        mix-blend-mode: multiply;
        /* Menghilangkan background putih pada JPG */
    }

    .auth-watermarks-grid img {
        position: absolute;
        object-fit: contain;
    }


    /* ===== KARTU LOGIN ===== */
    .auth-card {
        background: #ffffff;
        width: 100%;
        max-width: 440px;
        border-radius: 20px;
        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.30), 0 0 0 1px rgba(255, 255, 255, 0.05);
        position: relative;
        z-index: 10;
        animation: fadeInUp 0.5s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .auth-card-body {
        padding: 44px;
    }

    /* Logo */
    .auth-card-logo {
        display: block;
        width: 220px !important;
        height: auto !important;
        margin: 0 auto 30px !important;
        object-fit: contain;
    }

    /* Judul */
    .auth-card-title {
        text-align: center;
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .auth-card-subtitle {
        text-align: center;
        font-size: 13px;
        color: #94a3b8;
        margin-bottom: 24px;
    }

    /* Divider */
    .auth-divider {
        height: 1px;
        width: 100%;
        background: linear-gradient(to right, transparent, #e2e8f0, transparent);
        margin: 0 auto 28px;
    }

    /* Form Groups */
    .auth-form-group {
        margin-bottom: 20px;
    }

    .auth-form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 7px;
    }

    .auth-input-wrapper {
        position: relative;
    }

    .auth-input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
        transition: color 0.25s;
    }

    .auth-input-wrapper:focus-within .auth-input-icon {
        color: #1a56db;
    }

    .auth-form-control {
        width: 100%;
        padding: 12px 16px 12px 42px;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 13.5px;
        color: #1e293b;
        font-family: inherit;
        transition: all 0.25s ease;
        box-sizing: border-box;
    }

    .auth-form-control:focus {
        outline: none;
        border-color: #1a56db;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(26, 86, 219, 0.12);
    }

    .auth-form-control::placeholder {
        color: #cbd5e1;
    }

    /* Toggle password */
    .auth-toggle-pw {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        font-size: 14px;
        padding: 6px;
        outline: none;
        transition: color 0.2s;
    }

    .auth-toggle-pw:hover {
        color: #1a56db;
    }

    /* Options row */
    .auth-options {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        font-size: 13px;
    }

    .auth-remember {
        display: flex;
        align-items: center;
        gap: 7px;
        color: #64748b;
        cursor: pointer;
        user-select: none;
    }

    .auth-remember input[type="checkbox"] {
        cursor: pointer;
        width: 15px;
        height: 15px;
        accent-color: #1a56db;
    }

    .auth-forgot {
        color: #1a56db;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.2s;
    }

    .auth-forgot:hover {
        color: #1344b0;
        text-decoration: underline;
    }

    /* Submit */
    .auth-btn-submit {
        width: 100%;
        background: linear-gradient(135deg, #1a56db 0%, #1344b0 100%);
        color: #ffffff;
        border: none;
        padding: 13px;
        border-radius: 10px;
        font-size: 14.5px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        transition: all 0.25s ease;
        font-family: inherit;
        box-shadow: 0 4px 14px rgba(26, 86, 219, 0.30);
    }

    .auth-btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(26, 86, 219, 0.40);
    }

    .auth-btn-submit:active {
        transform: translateY(0);
        box-shadow: 0 4px 10px rgba(26, 86, 219, 0.25);
    }

    /* Footer */
    .auth-card-footer {
        text-align: center;
        padding-top: 22px;
        border-top: 1px solid #f1f5fb;
        margin-top: 22px;
    }

    .auth-card-footer p {
        font-size: 11px;
        color: #94a3b8;
        margin-bottom: 10px;
    }

    .auth-card-footer a {
        font-size: 13px;
        color: #1a56db;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: opacity 0.2s;
    }

    .auth-card-footer a:hover {
        opacity: 0.75;
    }

    /* Alerts */
    .auth-alert {
        padding: 11px 14px;
        border-radius: 8px;
        font-size: 13px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .auth-alert.error {
        background: rgba(220, 38, 38, 0.08);
        border-left: 4px solid #dc2626;
        color: #dc2626;
    }

    .auth-alert.success {
        background: rgba(22, 163, 74, 0.08);
        border-left: 4px solid #16a34a;
        color: #16a34a;
    }

    /* ===== TABLET ===== */
    @media (max-width: 1024px) {

        .wm-ml,
        .wm-mr,
        .wm-tml,
        .wm-bmr,
        .wm-tcr {
            display: none;
        }

        .dots-left,
        .dots-right {
            display: none;
        }
    }

    @media (max-width: 768px) {

        .wm-rt,
        .wm-lb,
        .geo-tr,
        .geo-bl {
            display: none;
        }

        .wm-lt {
            width: 220px;
            height: 220px;
        }

        .wm-rb {
            width: 220px;
            height: 220px;
        }

        .auth-card-body {
            padding: 36px 28px;
        }
    }

    /* ===== MOBILE ≤480px ===== */
    @media (max-width: 480px) {
        .auth-main-container {
            background: #ffffff;
            padding: 0;
            align-items: flex-start;
        }

        /* Sembunyikan semua dekorasi */
        .auth-watermark,
        .auth-geo,
        .dots-left,
        .dots-right {
            display: none !important;
        }

        /* Hilangkan card shell */
        .auth-card {
            box-shadow: none;
            border-radius: 0;
            max-width: none;
            width: 100%;
        }

        .auth-card-body {
            padding: 40px 24px 24px;
        }

        .auth-card-logo {
            width: 180px !important;
            height: auto !important;
        }

        .auth-card-title {
            font-size: 20px;
        }

        .auth-options {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .auth-forgot {
            margin-left: auto;
        }
    }

    /* ===== DEKORASI BACKGROUND ===== */
    .auth-watermarks-grid {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        pointer-events: none;
        z-index: 0;
        opacity: 0.15;
    }

    .auth-watermarks-grid img {
        position: absolute;
        width: 140px;
        height: 140px;
        object-fit: contain;
    }
</style>

<main class="auth-main-container">
    <!-- Dekorasi Background Simetris -->
    <div class="auth-watermarks-grid">
        <!-- Sisi Kiri -->
        <img src="<?= base_url('assets/img/login-decoration.png') ?>" alt="Dekorasi" style="top: 10%; left: 10%; transform: rotate(-15deg);">
        <img src="<?= base_url('assets/img/login-decoration.png') ?>" alt="Dekorasi" style="top: 50%; left: 5%; transform: translateY(-50%) rotate(10deg);">
        <img src="<?= base_url('assets/img/login-decoration.png') ?>" alt="Dekorasi" style="bottom: 10%; left: 10%; transform: rotate(-20deg);">

        <!-- Sisi Kanan -->
        <img src="<?= base_url('assets/img/login-decoration.png') ?>" alt="Dekorasi" style="top: 10%; right: 10%; transform: rotate(15deg);">
        <img src="<?= base_url('assets/img/login-decoration.png') ?>" alt="Dekorasi" style="top: 50%; right: 5%; transform: translateY(-50%) rotate(-10deg);">
        <img src="<?= base_url('assets/img/login-decoration.png') ?>" alt="Dekorasi" style="bottom: 10%; right: 10%; transform: rotate(20deg);">
    </div>

    <!-- Login Card -->
    <div class="auth-card">
        <div class="auth-card-body">

            <!-- Logo Aplikasi -->
            <div style="display: flex; justify-content: center; align-items: center; gap: 16px; margin-bottom: 30px;">
                <img src="<?= base_url('assets/img/logo-ngawi-transparent.png') ?>" alt="Logo Ngawi" style="height: 85px; width: auto; object-fit: contain;">
                <div style="height: 70px; width: 1px; background: #e2e8f0;"></div>
                <img src="<?= base_url('assets/img/logo-siposka-transparent.png') ?>" alt="Logo SIPOSKA" style="height: 85px; width: auto; object-fit: contain;">
            </div>

            <div class="auth-divider"></div>

            <?php if (session()->has('error')): ?>
                <div class="auth-alert error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= esc(session('error')) ?>
                </div>
            <?php endif; ?>
            <?php if (session()->has('success')): ?>
                <div class="auth-alert success">
                    <i class="fas fa-check-circle"></i>
                    <?= esc(session('success')) ?>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('login') ?>" method="POST">
                <?= csrf_field() ?>

                <!-- Username -->
                <div class="auth-form-group">
                    <label for="username" class="auth-form-label">Username</label>
                    <div class="auth-input-wrapper">
                        <span class="auth-input-icon"><i class="fas fa-user"></i></span>
                        <input type="text" id="username" name="username" class="auth-form-control" required
                            autocomplete="username" placeholder="Masukkan username">
                    </div>
                </div>

                <!-- Password -->
                <div class="auth-form-group">
                    <label for="password" class="auth-form-label">Password</label>
                    <div class="auth-input-wrapper">
                        <span class="auth-input-icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password" class="auth-form-control" required
                            autocomplete="current-password" placeholder="Masukkan password">
                        <button type="button" class="auth-toggle-pw" onclick="togglePassword()" id="btnToggle"
                            title="Tampilkan/Sembunyikan password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>



                <!-- Tombol Submit -->
                <button type="submit" class="auth-btn-submit">
                    <i class="fas fa-sign-in-alt"></i> Masuk ke Sistem
                </button>
            </form>

            <!-- Footer -->
            <div class="auth-card-footer">
                <p>&copy; <?= date('Y') ?> SIPOSKA — Sistem Informasi Posyandu Kandangan</p>
            </div>
        </div>
    </div>
</main>

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