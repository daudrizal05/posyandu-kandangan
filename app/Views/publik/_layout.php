<?php
/**
 * Publik Layout Partial — Navbar & Footer
 * Dipakai oleh semua halaman publik dengan cara include partial ini
 * atau melalui view helper yang konsisten.
 *
 * Variabel yang perlu dikirim dari controller:
 *   $title       — judul halaman
 *   $activePage  — menu aktif: 'home'|'berita'|'galeri'|'infografis'|'download'|'profil'|'kontak'
 *   $posyanduList — array posyandu aktif (dari getNavData())
 */
?>
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

    .nav-toggle {
      display: none;
      margin-left: auto;
      background: none;
      border: none;
      font-size: 22px;
      color: #fff;
      cursor: pointer;
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

    /* ========== PAGE HERO (dipakai halaman konten) ========== */
    .page-hero {
      background: linear-gradient(135deg, var(--blue) 0%, var(--blue-dk) 100%);
      padding: 48px 20px;
      text-align: center;
      color: #fff;
    }

    .page-hero h1 {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 8px;
    }

    .page-hero p {
      font-size: 14px;
      opacity: .85;
      max-width: 500px;
      margin: 0 auto;
    }

    .page-hero .breadcrumb-pub {
      margin-top: 16px;
      font-size: 12px;
      opacity: .7;
    }

    .page-hero .breadcrumb-pub a {
      color: #fff;
      opacity: .8;
    }

    .page-hero .breadcrumb-pub a:hover {
      opacity: 1;
    }

    /* ========== RESPONSIVE ========== */
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
    }

    <?= $extraCss ?? '' ?>
  </style>
</head>

<body>



  <!-- ===== NAVBAR ===== -->
  <nav class="navbar">
    <div class="wrap">
      <a href="<?= site_url('/') ?>" class="nav-logo">
        <img src="<?= base_url('assets/img/logo-siposka.png') ?>" alt="Logo Ngawi">
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
            <a href="<?= site_url('halaman/visi-misi') ?>"><i class="fas fa-bullseye"></i> Visi &amp; Misi</a>
            <a href="<?= site_url('halaman/struktur-organisasi') ?>"><i class="fas fa-sitemap"></i> Struktur
              Organisasi</a>
          </div>
        </div>

        <!-- Dropdown Data Posyandu -->
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
              <div style="font-size:11px;color:var(--muted);">
                <?= ucfirst(str_replace('_', ' ', session()->get('role'))) ?>
              </div>
            </div>
            <a href="<?= site_url('admin/dashboard') ?>"><i class="fas fa-tachometer-alt"></i> Buka Panel Admin</a>
            <div class="dd-divider"></div>
            <a href="<?= site_url('logout') ?>" style="color:#e11d48;"><i class="fas fa-sign-out-alt"></i> Logout</a>
          </div>
        </div>
      <?php else: ?>
        <a href="<?= site_url('login') ?>" class="btn-login">Login</a>
      <?php endif; ?>
    </div>
  </nav>

  <!-- ===== KONTEN HALAMAN ===== -->
  <?= $content ?? '' ?>

  <!-- ===== FOOTER ===== -->
  <footer>
    <p>&copy; Copyright SIPOSKA <?= date('Y') ?> &mdash; Sistem Informasi Posyandu Kandangan | Dibuat Oleh KKN 38 UINSA.
    </p>
  </footer>

  <script>
    document.getElementById('navToggle').onclick = function () {
      document.getElementById('navLinks').classList.toggle('open');
    };
    <?= $extraJs ?? '' ?>
  </script>
</body>

</html>