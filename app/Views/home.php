<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($title ?? 'SIPOSKA – Sistem Informasi Posyandu Kandangan') ?></title>
  <meta name="description"
    content="SIPOSKA – Platform digital pendataan, monitoring dan pelaporan data kesehatan balita & ibu hamil wilayah Kandangan.">
  <link rel="icon" type="image/jpeg" href="<?= base_url('favicon.ico') ?>?v=<?= time() ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* ========== RESET & BASE ========== */
    *,
    *::before,
    *::after {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    :root {
      --blue: #1a56db;
      --blue-dk: #1344b0;
      --blue-lt: #eff4ff;
      --gray-bg: #f1f5fb;
      --text: #1e293b;
      --muted: #64748b;
      --border: #e2e8f0;
      --radius: 10px;
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Poppins', sans-serif;
      color: var(--text);
      background: #fff;
    }

    a {
      text-decoration: none;
      color: inherit;
    }

    img {
      display: block;
      max-width: 100%;
    }

    /* ========== TOP BAR ========== */
    .topbar {
      background: var(--blue);
      padding: 7px 0;
      font-size: 12px;
      color: rgba(255, 255, 255, 0.85);
    }

    .topbar .wrap {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .topbar-links {
      display: flex;
      gap: 20px;
    }

    .topbar-links a {
      color: rgba(255, 255, 255, 0.85);
      transition: color .2s;
    }

    .topbar-links a:hover {
      color: #fff;
    }

    .topbar-contacts {
      display: flex;
      gap: 22px;
    }

    .topbar-contacts span {
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .topbar-contacts i {
      opacity: .75;
    }

    /* ========== NAVBAR ========== */
    .navbar {
      background: #fff;
      box-shadow: 0 1px 0 var(--border), 0 4px 16px rgba(0, 0, 0, 0.06);
      position: sticky;
      top: 0;
      z-index: 999;
    }

    .navbar .wrap {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
      display: flex;
      align-items: center;
      height: 64px;
      gap: 0;
    }

    /* Logo */
    .nav-logo {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-right: 28px;
      flex-shrink: 0;
    }

    .nav-logo img {
      width: 36px;
      height: 36px;
      object-fit: contain;
      border-radius: 6px;
    }

    .nav-logo .logo-text {
      line-height: 1.15;
    }

    .nav-logo .logo-title {
      font-size: 16px;
      font-weight: 700;
      color: var(--blue);
      display: block;
    }

    .nav-logo .logo-sub {
      font-size: 9px;
      color: var(--muted);
      display: block;
    }

    /* Menu */
    .nav-links {
      display: flex;
      align-items: center;
      flex: 1;
      gap: 2px;
    }

    .nav-links>a,
    .nav-links>.dd>.dd-trigger {
      padding: 8px 13px;
      font-size: 13.5px;
      font-weight: 500;
      color: var(--text);
      border-radius: 7px;
      transition: all .18s;
      cursor: pointer;
      border: none;
      background: none;
      font-family: inherit;
      display: flex;
      align-items: center;
      gap: 4px;
    }

    .nav-links>a:hover,
    .nav-links>.dd>.dd-trigger:hover {
      color: var(--blue);
      background: var(--blue-lt);
    }

    .nav-links>a.active {
      color: var(--blue);
      background: var(--blue-lt);
      font-weight: 600;
    }

    /* Dropdown */
    .dd {
      position: relative;
    }

    .dd::after {
      content: "";
      position: absolute;
      bottom: -15px;
      left: 0;
      right: 0;
      height: 15px;
      z-index: 1;
    }

    .dd-trigger .caret {
      font-size: 9px;
      opacity: .5;
    }

    .dd-panel {
      display: none;
      position: absolute;
      top: calc(100% + 8px);
      left: 0;
      background: #fff;
      border-radius: 12px;
      min-width: 210px;
      box-shadow: 0 10px 36px rgba(0, 0, 0, 0.13);
      border: 1px solid var(--border);
      overflow: hidden;
      z-index: 1000;
      padding: 6px 0;
    }

    .dd:hover .dd-panel {
      display: block;
    }

    .dd-panel a {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 16px;
      font-size: 13px;
      color: var(--text);
      transition: background .15s;
    }

    .dd-panel a:hover {
      background: var(--blue-lt);
      color: var(--blue);
    }

    .dd-panel a i {
      width: 16px;
      text-align: center;
      color: var(--muted);
      font-size: 12px;
    }

    .dd-panel a:hover i {
      color: var(--blue);
    }

    .dd-divider {
      height: 1px;
      background: var(--border);
      margin: 5px 0;
    }

    .dd-header {
      padding: 6px 16px 4px;
      font-size: 10px;
      font-weight: 600;
      letter-spacing: .8px;
      text-transform: uppercase;
      color: var(--muted);
    }

    /* Login button */
    .btn-login {
      margin-left: auto;
      padding: 9px 22px;
      background: var(--blue);
      color: #fff;
      border-radius: 8px;
      font-size: 13.5px;
      font-weight: 600;
      transition: all .2s;
    }

    .btn-login:hover {
      background: var(--blue-dk);
      box-shadow: 0 4px 14px rgba(0, 0, 0, .15);
      transform: translateY(-1px);
    }

    /* Mobile toggle */
    .nav-toggle {
      display: none;
      margin-left: auto;
      background: none;
      border: none;
      font-size: 22px;
      color: #fff;
      cursor: pointer;
    }

    /* ========== HERO ========== */
    .hero {
      background: var(--gray-bg);
      position: relative;
      overflow: hidden;
      min-height: 420px;
    }

    .slider {
      min-height: 420px;
    }

    .slide {
      display: none;
      min-height: 420px;
    }

    .slide.active {
      display: flex;
      align-items: center;
    }

    .slide-inner {
      max-width: 1200px;
      margin: 0 auto;
      padding: 48px 20px;
      display: flex;
      align-items: center;
      gap: 48px;
      width: 100%;
    }

    .slide-text {
      flex: 1;
    }

    .slide-text h1 {
      font-size: clamp(22px, 3vw, 38px);
      font-weight: 800;
      line-height: 1.25;
      margin-bottom: 14px;
      color: var(--text);
    }

    .slide-text h1 span {
      color: var(--blue);
    }

    .slide-text p {
      font-size: 14px;
      color: var(--muted);
      line-height: 1.8;
      max-width: 420px;
      margin-bottom: 26px;
    }

    .slide-img {
      flex-shrink: 0;
      width: 42%;
      max-width: 430px;
    }

    .slide-img img {
      width: 100%;
      height: 360px;
      object-fit: cover;
      border-radius: 14px;
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
    }

    .btn-primary {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: var(--blue);
      color: #fff;
      padding: 12px 26px;
      border-radius: 9px;
      font-size: 14px;
      font-weight: 600;
      transition: all .2s;
    }

    .btn-primary:hover {
      background: var(--blue-dk);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(26, 86, 219, .35);
    }

    .btn-outline {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: transparent;
      color: var(--text);
      padding: 12px 26px;
      border-radius: 9px;
      font-size: 14px;
      font-weight: 600;
      border: 2px solid var(--border);
      transition: all .2s;
    }

    .btn-outline:hover {
      border-color: var(--blue);
      color: var(--blue);
      background: var(--blue-lt);
    }

    .slider-arrow {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .92);
      border: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      color: var(--blue);
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
      transition: all .2s;
      z-index: 10;
    }

    .slider-arrow:hover {
      background: var(--blue);
      color: #fff;
    }

    .arrow-prev {
      left: 18px;
    }

    .arrow-next {
      right: 18px;
    }

    .dots {
      position: absolute;
      bottom: 16px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 8px;
    }

    .dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: rgba(26, 86, 219, .25);
      cursor: pointer;
      transition: all .22s;
    }

    .dot.active {
      background: var(--blue);
      width: 24px;
      border-radius: 4px;
    }

    /* ========== STATS ========== */
    .stats {
      background: #fff;
    }

    .stats-grid {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 0;
    }

    .stat-card {
      padding: 30px 26px;
      position: relative;
      overflow: hidden;
      transition: transform .22s;
    }

    .stat-card:hover {
      transform: translateY(-3px);
    }

    .stat-card:nth-child(1) {
      background: #1a56db;
    }

    .stat-card:nth-child(2) {
      background: #1e90ff;
    }

    .stat-card:nth-child(3) {
      background: #1344b0;
    }

    .stat-card:nth-child(4) {
      background: #0e337a;
    }

    .stat-bg-icon {
      position: absolute;
      right: -8px;
      bottom: -8px;
      font-size: 78px;
      color: rgba(255, 255, 255, 0.10);
      pointer-events: none;
    }

    .stat-label {
      font-size: 10.5px;
      font-weight: 700;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: rgba(255, 255, 255, .72);
      margin-bottom: 8px;
    }

    .stat-value {
      font-size: 34px;
      font-weight: 800;
      color: #fff;
      line-height: 1;
    }

    .stat-unit {
      font-size: 15px;
      font-weight: 400;
      margin-left: 4px;
    }

    /* ========== POSYANDU CARDS ========== */
    .posyandu-section {
      padding: 70px 20px;
      background: var(--gray-bg);
    }

    .posyandu-section .wrap {
      max-width: 1200px;
      margin: 0 auto;
    }

    .section-head {
      text-align: center;
      margin-bottom: 44px;
    }

    .badge-label {
      display: inline-block;
      background: var(--blue-lt);
      color: var(--blue);
      padding: 4px 14px;
      border-radius: 50px;
      font-size: 11.5px;
      font-weight: 600;
      margin-bottom: 10px;
    }

    .section-head h2 {
      font-size: 26px;
      font-weight: 700;
      margin-bottom: 10px;
      color: var(--text);
    }

    .section-head p {
      font-size: 13.5px;
      color: var(--muted);
      max-width: 500px;
      margin: 0 auto;
      line-height: 1.75;
    }

    .posyandu-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
    }

    .posyandu-card {
      background: #fff;
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 2px 14px rgba(0, 0, 0, 0.06);
      border: 1px solid var(--border);
      transition: all .25s;
    }

    .posyandu-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 14px 36px rgba(26, 86, 219, 0.13);
      border-color: rgba(26, 86, 219, .2);
    }

    .posyandu-card-head {
      background: var(--blue);
      padding: 20px 18px;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .posyandu-card-head .num {
      width: 34px;
      height: 34px;
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 15px;
      font-weight: 700;
      color: #fff;
      flex-shrink: 0;
    }

    .posyandu-card-head .name {
      font-size: 13.5px;
      font-weight: 600;
      color: #fff;
      line-height: 1.3;
    }

    .posyandu-card-head .desa {
      font-size: 10.5px;
      color: rgba(255, 255, 255, .7);
    }

    .posyandu-card-body {
      padding: 16px 18px;
    }

    .posyandu-meta {
      display: flex;
      flex-direction: column;
      gap: 8px;
      margin-bottom: 16px;
    }

    .posyandu-meta-row {
      display: flex;
      align-items: flex-start;
      gap: 8px;
      font-size: 12px;
      color: var(--muted);
    }

    .posyandu-meta-row i {
      color: var(--blue);
      font-size: 12px;
      margin-top: 2px;
      flex-shrink: 0;
    }

    .posyandu-actions {
      display: flex;
      flex-direction: column;
      gap: 7px;
    }

    .posyandu-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 7px;
      padding: 9px;
      border-radius: 8px;
      font-size: 12.5px;
      font-weight: 600;
      transition: all .18s;
    }

    .posyandu-btn.primary {
      background: var(--blue);
      color: #fff;
    }

    .posyandu-btn.primary:hover {
      background: var(--blue-dk);
      box-shadow: 0 4px 12px rgba(26, 86, 219, .3);
    }

    .posyandu-btn.outline {
      background: transparent;
      color: var(--blue);
      border: 1.5px solid var(--blue);
    }

    .posyandu-btn.outline:hover {
      background: var(--blue-lt);
    }

    /* ========== FEATURES ========== */
    .features {
      padding: 70px 20px;
      background: #fff;
    }

    .features .wrap {
      max-width: 1200px;
      margin: 0 auto;
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 22px;
    }

    .feature-card {
      background: var(--gray-bg);
      border-radius: 14px;
      padding: 28px 24px;
      border: 1px solid var(--border);
      transition: all .25s;
    }

    .feature-card:hover {
      background: #fff;
      transform: translateY(-5px);
      box-shadow: 0 10px 30px rgba(26, 86, 219, 0.10);
      border-color: rgba(26, 86, 219, .18);
    }

    .feature-icon {
      width: 52px;
      height: 52px;
      border-radius: 12px;
      background: var(--blue-lt);
      color: var(--blue);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      margin-bottom: 18px;
    }

    .feature-card h3 {
      font-size: 15px;
      font-weight: 600;
      margin-bottom: 8px;
    }

    .feature-card p {
      font-size: 12.5px;
      color: var(--muted);
      line-height: 1.7;
    }

    /* ========== PARTNER LOGOS ========== */
    .partner-logos {
      background: #EEF3FC;
      padding: 40px 0;
      border-top: 1px solid var(--border);
    }

    .partner-logos .wrap {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 48px;
      flex-wrap: wrap;
    }

    .partner-logos img {
      height: 60px;
      width: auto;
      object-fit: contain;
      filter: grayscale(100%);
      transition: filter 0.3s ease;
    }

    .partner-logos img:hover {
      filter: grayscale(0%);
    }

    /* ========== FOOTER ========== */
    footer {
      background: var(--blue-dk);
      color: rgba(255, 255, 255, 0.8);
      text-align: center;
      padding: 22px 20px;
      font-size: 12.5px;
    }

    footer strong {
      color: #fff;
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 1024px) {
      .posyandu-grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }

    @media (max-width: 860px) {
      .stats-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .posyandu-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .features-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 700px) {
      .topbar {
        display: none;
      }

      .nav-links {
        display: none;
        flex-direction: column;
        align-items: flex-start;
        position: absolute;
        top: 64px;
        left: 0;
        right: 0;
        background: #fff;
        padding: 10px 0 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.10);
        gap: 0;
      }

      .nav-links.open {
        display: flex;
      }

      .nav-toggle {
        display: block;
      }

      .btn-login {
        display: none;
      }

      .slide-inner {
        flex-direction: column-reverse;
        padding: 28px 16px;
        gap: 24px;
      }

      .slide-img {
        width: 100%;
      }

      .slide-img img {
        height: 220px;
      }

      .slider-arrow {
        display: none;
      }
    }

    @media (max-width: 540px) {
      .stats-grid {
        grid-template-columns: 1fr 1fr;
      }

      .posyandu-grid {
        grid-template-columns: 1fr;
      }

      .features-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>




  <!-- ===== NAVBAR ===== -->
  <nav class="navbar">
    <div class="wrap">
      <a href="<?= site_url('/') ?>" class="nav-logo">
        <img src="<?= base_url('assets/img/logo-siposka.png') ?>" alt="Logo SIPOSKA">
        <div class="logo-text">
          <span class="logo-title">SIPOSKA</span>
          <span class="logo-sub">Sistem Informasi Posyandu Kandangan</span>
        </div>
      </a>

      <div class="nav-links" id="navLinks">
        <a href="<?= site_url('/') ?>" class="<?= ($activePage ?? '') === 'home' ? 'active' : '' ?>">Home</a>

        <!-- Dropdown Profil -->
        <div class="dd">
          <button class="dd-trigger <?= ($activePage ?? '') === 'profil' ? 'active' : '' ?>">Profil <i
              class="fas fa-chevron-down caret"></i></button>
          <div class="dd-panel">
            <a href="<?= site_url('profil') ?>"><i class="fas fa-info-circle"></i> Tentang Kami</a>
          </div>
        </div>

        <!-- Dropdown Data Posyandu — per dusun dari database -->
        <div class="dd">
          <button class="dd-trigger <?= ($activePage ?? '') === 'posyandu' ? 'active' : '' ?>">
            Data Posyandu <i class="fas fa-chevron-down caret"></i>
          </button>
          <div class="dd-panel" style="min-width:240px;">
            <div class="dd-header">Pilih Posyandu</div>
            <?php if (!empty($posyanduList)): ?>
              <?php foreach ($posyanduList as $p): ?>
                <a href="<?= site_url('posyandu-' . $p['id']) ?>">
                  <i class="fas fa-clinic-medical"></i>
                  <?= esc($p['nama_posyandu']) ?>
                </a>
              <?php endforeach; ?>
            <?php else: ?>
              <a href="#"><i class="fas fa-info-circle"></i> Belum ada data</a>
            <?php endif; ?>
          </div>
        </div>


      </div>

      <button class="nav-toggle" id="navToggle"><i class="fas fa-bars"></i></button>

      <?php if (session()->get('isLoggedIn')): ?>
        <!-- Dropdown user ketika sudah login -->
        <div class="dd" style="margin-left:auto;flex-shrink:0;">
          <button class="dd-trigger"
            style="padding:8px 14px;background:var(--blue-lt);border-radius:8px;color:var(--blue);font-weight:600;">
            <i class="fas fa-user-circle" style="margin-right:5px;"></i>
            <?= esc(session()->get('name')) ?>
            <i class="fas fa-chevron-down caret"></i>
          </button>
          <div class="dd-panel" style="right:0;left:auto;min-width:220px;">
            <div style="padding:10px 16px 8px;border-bottom:1px solid var(--border);">
              <div style="font-size:13px;font-weight:600;color:var(--text);"><?= esc(session()->get('name')) ?></div>
              <div style="font-size:11px;color:var(--muted);"><?= ucfirst(str_replace('_', ' ', session()->get('role'))) ?>
              </div>
            </div>
            <a href="#" id="btnOpenAdminSPA">
              <i class="fas fa-tachometer-alt"></i> Panel Admin
            </a>
            <div class="dd-divider"></div>
            <a href="<?= site_url('logout') ?>" style="color:#e11d48;">
              <i class="fas fa-sign-out-alt"></i> Logout
            </a>
          </div>
        </div>
      <?php else: ?>
        <a href="<?= site_url('login') ?>" class="btn-login">Login</a>
      <?php endif; ?>
    </div>
  </nav>

  <!-- ===== HERO SLIDER ===== -->
  <section class="hero">
    <div class="slider" id="slider">

      <div class="slide active">
        <div class="slide-inner">
          <div class="slide-text">
            <h1>Selamat Datang di <span>SIPOSKA</span> Ver. 1.0</h1>
            <p>Aplikasi ini menjadi katalisator dalam pencegahan stunting di Kecamatan Kandangan melalui pengumpulan dan
              pelaporan data kesehatan balita dan ibu hamil secara digital.</p>
            <div style="display:flex;gap:12px;flex-wrap:wrap;">
              <a href="<?= site_url('login') ?>" class="btn-primary"><i class="fas fa-sign-in-alt"></i> Masuk
                Sekarang</a>
              <a href="#posyandu" class="btn-outline"><i class="fas fa-clinic-medical"></i> Lihat Posyandu</a>
            </div>
          </div>
          <div class="slide-img">
            <img src="<?= base_url('assets/img/hero-posyandu.png') ?>" alt="Petugas Posyandu">
          </div>
        </div>
      </div>

      <div class="slide">
        <div class="slide-inner">
          <div class="slide-text">
            <h1>Monitoring <span>Tumbuh Kembang Balita</span> Secara Digital</h1>
            <p>Pantau berat badan, tinggi badan, dan status gizi balita secara real-time. Data tersimpan otomatis dan
              mudah dilaporkan.</p>
            <a href="<?= site_url('login') ?>" class="btn-primary"><i class="fas fa-chart-line"></i> Lihat Data
              Balita</a>
          </div>
          <div class="slide-img">
            <img src="<?= base_url('assets/img/hero-posyandu.png') ?>" alt="Monitoring Balita">
          </div>
        </div>
      </div>

      <div class="slide">
        <div class="slide-inner">
          <div class="slide-text">
            <h1>Pendataan <span>Ibu Hamil</span> Lebih Mudah &amp; Akurat</h1>
            <p>Catat dan pantau kondisi ibu hamil di seluruh <?= $totalPosyandu ?? 0 ?> posyandu wilayah Kandangan dalam
              satu sistem terintegrasi.</p>
            <a href="<?= site_url('login') ?>" class="btn-primary"><i class="fas fa-female"></i> Selengkapnya</a>
          </div>
          <div class="slide-img">
            <img src="<?= base_url('assets/img/hero-posyandu.png') ?>" alt="Data Ibu Hamil">
          </div>
        </div>
      </div>

    </div>

    <button class="slider-arrow arrow-prev" id="arrowPrev"><i class="fas fa-chevron-left"></i></button>
    <button class="slider-arrow arrow-next" id="arrowNext"><i class="fas fa-chevron-right"></i></button>
    <div class="dots" id="dots">
      <div class="dot active"></div>
      <div class="dot"></div>
      <div class="dot"></div>
    </div>
  </section>

  <!-- ===== STATS ===== -->
  <section class="stats">
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-bg-icon"><i class="fas fa-child"></i></div>
        <div class="stat-label">Total Balita</div>
        <div class="stat-value"><?= number_format($totalBalita ?? 0) ?><span class="stat-unit">Jiwa</span></div>
      </div>
      <div class="stat-card">
        <div class="stat-bg-icon"><i class="fas fa-mars"></i></div>
        <div class="stat-label">Laki-laki</div>
        <div class="stat-value"><?= number_format($balitaL ?? 0) ?><span class="stat-unit">Jiwa</span></div>
      </div>
      <div class="stat-card">
        <div class="stat-bg-icon"><i class="fas fa-venus"></i></div>
        <div class="stat-label">Perempuan</div>
        <div class="stat-value"><?= number_format($balitaP ?? 0) ?><span class="stat-unit">Jiwa</span></div>
      </div>
      <div class="stat-card">
        <div class="stat-bg-icon"><i class="fas fa-clinic-medical"></i></div>
        <div class="stat-label">Posyandu Aktif</div>
        <div class="stat-value"><?= number_format($totalPosyandu ?? 0) ?><span class="stat-unit">Unit</span></div>
      </div>
    </div>
  </section>

  <!-- ===== DAFTAR POSYANDU PER DUSUN ===== -->
  <section class="posyandu-section" id="posyandu">
    <div class="wrap">
      <div class="section-head">
        <div class="badge-label">Data Posyandu</div>
        <h2>Posyandu di Wilayah Kandangan</h2>
        <p>Pilih posyandu sesuai dusun/wilayah untuk melihat data balita dan ibu hamil secara lengkap.</p>
      </div>

      <?php if (!empty($posyanduList)): ?>
        <div class="posyandu-grid">
          <?php foreach ($posyanduList as $i => $p): ?>
            <div class="posyandu-card">
              <div class="posyandu-card-head">
                <div class="num"><?= $i + 1 ?></div>
                <div>
                  <div class="name"><?= esc($p['nama_posyandu']) ?></div>
                  <div class="desa"><?= esc($p['desa_kelurahan'] ?? '') ?></div>
                </div>
              </div>
              <div class="posyandu-card-body">
                <div class="posyandu-meta">
                  <?php if (!empty($p['alamat'])): ?>
                    <div class="posyandu-meta-row">
                      <i class="fas fa-map-marker-alt"></i>
                      <span><?= esc($p['alamat']) ?></span>
                    </div>
                  <?php endif; ?>
                  <?php if (!empty($p['nama_ketua_kader'])): ?>
                    <div class="posyandu-meta-row">
                      <i class="fas fa-user-nurse"></i>
                      <span>Ketua: <?= esc($p['nama_ketua_kader']) ?></span>
                    </div>
                  <?php endif; ?>
                  <?php if (!empty($p['kontak'])): ?>
                    <div class="posyandu-meta-row">
                      <i class="fas fa-phone"></i>
                      <span><?= esc($p['kontak']) ?></span>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="posyandu-actions">
                  <a href="<?= site_url('posyandu-' . $p['id'] . '/balita') ?>" class="posyandu-btn primary">
                    <i class="fas fa-child"></i> Data Balita
                  </a>
                  <a href="<?= site_url('posyandu-' . $p['id'] . '/ibu-hamil') ?>" class="posyandu-btn outline">
                    <i class="fas fa-female"></i> Data Ibu Hamil
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div style="text-align:center;padding:48px;color:var(--muted);">
          <i class="fas fa-clinic-medical" style="font-size:48px;opacity:.3;margin-bottom:12px;display:block;"></i>
          <p>Belum ada data posyandu. Silakan tambahkan melalui panel admin.</p>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- ===== FITUR ===== -->
  <section class="features">
    <div class="wrap">
      <div class="section-head">
        <div class="badge-label">Fitur Unggulan</div>
        <h2>Apa yang bisa dilakukan SIPOSKA?</h2>
        <p>Platform terintegrasi untuk mengelola data kesehatan ibu dan anak di seluruh posyandu wilayah Kandangan.</p>
      </div>
      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-clinic-medical"></i></div>
          <h3>Manajemen Posyandu</h3>
          <p>Kelola data seluruh posyandu aktif dengan informasi lengkap: alamat, kader, dan kontak.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-child"></i></div>
          <h3>Data Balita</h3>
          <p>Pencatatan data balita secara digital termasuk NIK, identitas, dan status perkembangan.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-weight"></i></div>
          <h3>Pengukuran &amp; Gizi</h3>
          <p>Rekam hasil pengukuran BB/TB dan deteksi dini status gizi balita secara otomatis.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-female"></i></div>
          <h3>Data Ibu Hamil</h3>
          <p>Pantau kondisi ibu hamil mulai HPHT hingga taksiran persalinan dalam satu dashboard.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-file-pdf"></i></div>
          <h3>Cetak Laporan</h3>
          <p>Generate laporan PDF data balita dan pengukuran siap cetak kapan saja dan di mana saja.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-chart-bar"></i></div>
          <h3>Dashboard Statistik</h3>
          <p>Visualisasi data stunting, tren pengukuran, dan distribusi status gizi dalam grafik informatif.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== FOOTER ===== -->
  <footer>
    <p>&copy; Copyright SIPOSKA <?= date('Y') ?> &mdash; Sistem Informasi Posyandu Kandangan | Dibuat Oleh KKN 38 UINSA.
    </p>
  </footer>

  <script>
    /* ===== SLIDER ===== */
    (function () {
      let cur = 0;
      const slides = document.querySelectorAll('.slide');
      const dots = document.querySelectorAll('.dot');
      let timer;

      function go(n) {
        slides[cur].classList.remove('active');
        dots[cur].classList.remove('active');
        cur = ((n % slides.length) + slides.length) % slides.length;
        slides[cur].classList.add('active');
        dots[cur].classList.add('active');
      }

      function play() { timer = setInterval(() => go(cur + 1), 5000); }

      document.getElementById('arrowPrev').onclick = () => { clearInterval(timer); go(cur - 1); play(); };
      document.getElementById('arrowNext').onclick = () => { clearInterval(timer); go(cur + 1); play(); };
      dots.forEach((d, i) => d.onclick = () => { clearInterval(timer); go(i); play(); });
      play();
    })();

    /* ===== MOBILE NAV ===== */
    document.getElementById('navToggle').onclick = function () {
      document.getElementById('navLinks').classList.toggle('open');
    };
  </script>

  <?php if (session()->get('isLoggedIn') && in_array(session()->get('role'), ['admin', 'kader', 'bidan'])): ?>
    <?= view('admin_spa') ?>
  <?php endif; ?>

</body>

</html>