<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,700&family=Outfit:wght@500;700;800&display=swap" rel="stylesheet">

<style>
    /* Variables */
    :root {
        --deep-blue: #0F2167;
        --emerald: #35A29F;
        --ledger-white: #FAFAFA;
        --ink-gray: #333333;
        --coral: #F7418F;
        --font-display: 'Outfit', sans-serif;
        --font-body: 'DM Sans', sans-serif;
    }

    body {
        margin: 0;
        padding: 0;
        background-color: var(--ledger-white);
        font-family: var(--font-body);
        color: var(--ink-gray);
    }

    .login-container {
        display: flex;
        min-height: 100vh;
        width: 100%;
        overflow: hidden;
    }

    /* Left Panel (Topographical Map) */
    .login-left {
        width: 40%;
        background-color: var(--deep-blue);
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 40px;
        color: #fff;
        /* Topo SVG pattern generated dynamically */
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
    }

    .login-left-content {
        position: relative;
        z-index: 10;
        text-align: center;
        max-width: 400px;
    }

    .login-logo {
        width: 140px;
        height: auto;
        margin-bottom: 24px;
        filter: drop-shadow(0 10px 15px rgba(0,0,0,0.2));
    }

    .brand-title {
        font-family: var(--font-display);
        font-size: 42px;
        font-weight: 800;
        line-height: 1.1;
        margin: 0 0 12px 0;
        letter-spacing: -0.02em;
    }
    
    .brand-subtitle {
        font-size: 16px;
        opacity: 0.8;
        font-weight: 400;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    /* Right Panel (Form) */
    .login-right {
        width: 60%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px;
        background-color: var(--ledger-white);
    }

    .login-form-wrapper {
        width: 100%;
        max-width: 440px;
    }

    .login-greeting {
        font-family: var(--font-display);
        font-size: 48px;
        font-weight: 700;
        color: var(--ink-gray);
        margin-bottom: 8px;
        line-height: 1.1;
        letter-spacing: -0.03em;
        margin-top: 0;
    }

    .login-greeting-sub {
        font-size: 18px;
        color: #666;
        margin-bottom: 48px;
    }

    /* Ledger-style Inputs */
    .ledger-group {
        margin-bottom: 36px;
        position: relative;
    }

    .ledger-label {
        display: block;
        font-weight: 700;
        font-size: 14px;
        color: var(--ink-gray);
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .ledger-input {
        width: 100%;
        background: transparent;
        border: none;
        border-bottom: 2px solid #D1D5DB;
        padding: 12px 0;
        font-size: 24px;
        font-family: var(--font-display);
        color: var(--ink-gray);
        outline: none;
        transition: border-color 0.3s ease;
    }

    .ledger-input::placeholder {
        color: #9CA3AF;
        font-weight: 400;
    }

    .ledger-input:focus {
        border-bottom-color: var(--emerald);
    }

    /* Password Toggle */
    .password-wrapper {
        position: relative;
    }

    .toggle-pw-btn {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #9CA3AF;
        font-size: 20px;
        padding: 8px;
        transition: color 0.2s;
    }

    .toggle-pw-btn:hover {
        color: var(--deep-blue);
    }

    /* Actions */
    .login-action {
        margin-top: 48px;
        display: flex;
        justify-content: flex-end;
    }

    .btn-masuk {
        background-color: var(--deep-blue);
        color: #fff;
        border: none;
        padding: 16px 48px;
        font-size: 18px;
        font-weight: 700;
        font-family: var(--font-display);
        border-radius: 100px; /* Pill shape */
        cursor: pointer;
        transition: transform 0.2s, background-color 0.2s;
        box-shadow: 0 10px 20px -5px rgba(15, 33, 103, 0.4);
    }

    .btn-masuk:hover {
        background-color: var(--emerald);
        transform: translateY(-2px);
    }

    /* Alerts */
    .alert-box {
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 32px;
        font-weight: 500;
    }
    .alert-error {
        background-color: #FDF2F8;
        color: var(--coral);
        border-left: 4px solid var(--coral);
    }
    .alert-success {
        background-color: #ECFDF5;
        color: var(--emerald);
        border-left: 4px solid var(--emerald);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .login-container {
            flex-direction: column;
        }
        .login-left {
            width: 100%;
            padding: 60px 20px;
        }
        .login-right {
            width: 100%;
            padding: 40px 20px;
        }
        .login-greeting {
            font-size: 36px;
        }
        .ledger-input {
            font-size: 20px;
        }
    }
</style>

<main class="login-container">
    <!-- Left Panel: Topographical Canvas -->
    <section class="login-left">
        <div class="login-left-content">
            <img src="<?= base_url('assets/img/logo-siposka-transparent.png') ?>" alt="Logo SIPOSKA" class="login-logo">
            <h1 class="brand-title">SIPOSKA</h1>
            <div class="brand-subtitle">Sistem Informasi Posyandu Kandangan</div>
        </div>
    </section>

    <!-- Right Panel: Ledger Form -->
    <section class="login-right">
        <div class="login-form-wrapper">
            
            <h2 class="login-greeting">Selamat Datang</h2>
            <p class="login-greeting-sub">Silakan masuk untuk mengakses sistem.</p>

            <?php if (session()->has('error')): ?>
                <div class="alert-box alert-error">
                    <?= esc(session('error')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->has('success')): ?>
                <div class="alert-box alert-success">
                    <?= esc(session('success')) ?>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('login') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="ledger-group">
                    <label class="ledger-label" for="username">Nama Pengguna</label>
                    <input type="text" id="username" name="username" class="ledger-input" required autocomplete="username" placeholder="Masukkan nama pengguna">
                </div>

                <div class="ledger-group">
                    <label class="ledger-label" for="password">Kata Sandi</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" class="ledger-input" required autocomplete="current-password" placeholder="Masukkan kata sandi">
                        <button type="button" class="toggle-pw-btn" onclick="togglePassword()" title="Tampilkan/Sembunyikan kata sandi">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="login-action">
                    <button type="submit" class="btn-masuk">Masuk</button>
                </div>
            </form>
        </div>
    </section>
</main>

<script>
    function togglePassword() {
        const pwInput = document.getElementById('password');
        const icon = document.querySelector('.toggle-pw-btn i');
        
        if (pwInput.type === 'password') {
            pwInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            pwInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
<?= $this->endSection() ?>