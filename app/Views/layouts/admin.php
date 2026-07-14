<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?? 'Panel Admin' ?> | SIPOSKA</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">

  <!-- Icons & Libs -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <!-- Watermark removed by user request: <link rel="stylesheet" href="<?= base_url('assets/css/watermark.css') ?>"> -->

  <style>
    /* ============================================================
       BASE
    ============================================================ */
    *, *::before, *::after { box-sizing: border-box; }

    body,
    .main-sidebar,
    .nav-sidebar .nav-link,
    .content-header,
    .main-header,
    .main-footer {
      font-family: 'Inter', sans-serif !important;
    }

    /* ============================================================
       SIDEBAR
    ============================================================ */
    .main-sidebar {
      background: #1b2a4a !important;   /* navy deep */
      width: 248px !important;
      box-shadow: 2px 0 12px rgba(0,0,0,0.18) !important;
    }

    /* ---- Brand ---- */
    .brand-link {
      background: #162239 !important;
      border-bottom: 1px solid rgba(255,255,255,0.07) !important;
      padding: 0 16px !important;
      display: flex !important;
      align-items: center !important;
      gap: 11px !important;
      height: 60px !important;
    }
    .brand-link:hover { background: #0f1c2e !important; }

    .main-header {
      height: 60px !important;
      border-bottom: 1px solid #e9ecef !important;
    }

    .sidebar-brand-logo {
      width: 38px !important;
      height: 38px !important;
      object-fit: contain;
      border-radius: 6px;
      flex-shrink: 0;
      border: 1px solid rgba(255,255,255,0.12);
    }

    .sidebar-brand-text-wrap { line-height: 1.25; }

    .sidebar-brand-title {
      color: #ffffff !important;
      font-size: 15px !important;
      font-weight: 700 !important;
      letter-spacing: 0.5px;
      display: block;
    }
    .sidebar-brand-sub {
      color: rgba(255,255,255,0.5) !important;
      font-size: 9px !important;
      font-weight: 400;
      display: block;
      letter-spacing: 0.3px;
    }

    /* ---- User Panel ---- */
    .user-panel {
      background: rgba(0,0,0,0.15) !important;
      border-bottom: 1px solid rgba(255,255,255,0.07) !important;
      padding: 12px 16px !important;
      margin: 0 !important;
    }
    .user-panel .info a {
      color: #ffffff !important;
      font-size: 13px !important;
      font-weight: 600 !important;
    }
    .user-panel .info small {
      color: rgba(255,255,255,0.5) !important;
      font-size: 10.5px !important;
    }

    /* ---- Nav Section Labels ---- */
    .nav-sidebar .nav-header {
      color: rgba(255,255,255,0.35) !important;
      font-size: 9.5px !important;
      font-weight: 700 !important;
      letter-spacing: 1.2px !important;
      padding: 14px 16px 5px !important;
      text-transform: uppercase !important;
    }

    /* ---- Nav Items ---- */
    .nav-sidebar > .nav-item > .nav-link {
      color: rgba(255,255,255,0.72) !important;
      font-size: 13px !important;
      font-weight: 400 !important;
      padding: 9px 16px !important;
      border-radius: 0 !important;
      margin: 0 !important;
      transition: background 0.18s, color 0.18s !important;
      border-left: 3px solid transparent !important;
    }

    .nav-sidebar > .nav-item > .nav-link .nav-icon {
      font-size: 13px !important;
      width: 20px !important;
      margin-right: 10px !important;
      text-align: center !important;
      color: rgba(255,255,255,0.45) !important;
      transition: color 0.18s !important;
    }

    /* Active */
    .nav-sidebar > .nav-item > .nav-link.active,
    .nav-sidebar > .nav-item > .nav-link.active:focus {
      background: rgba(255,255,255,0.10) !important;
      color: #ffffff !important;
      font-weight: 600 !important;
      border-left-color: #4d8ef0 !important;
    }
    .nav-sidebar > .nav-item > .nav-link.active .nav-icon {
      color: #4d8ef0 !important;
    }

    /* Hover */
    .nav-sidebar > .nav-item > .nav-link:not(.active):hover {
      background: rgba(255,255,255,0.06) !important;
      color: #ffffff !important;
      border-left-color: rgba(77,142,240,0.5) !important;
    }
    .nav-sidebar > .nav-item > .nav-link:not(.active):hover .nav-icon {
      color: rgba(255,255,255,0.75) !important;
    }

    /* Sidebar scroll */
    .sidebar {
      overflow-y: auto !important;
      overflow-x: hidden !important;
      padding-bottom: 24px;
    }
    .sidebar::-webkit-scrollbar { width: 4px; }
    .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 4px; }

    /* ============================================================
       TOPBAR / MAIN HEADER
    ============================================================ */
    .main-header {
      border-bottom: 1px solid #e9ecef !important;
      box-shadow: 0 1px 6px rgba(0,0,0,0.06) !important;
      height: 56px !important;
    }

    .main-header .navbar-nav .nav-link {
      font-size: 14px !important;
      color: #4a5568 !important;
    }

    .main-header .navbar-nav .nav-link:hover {
      color: #1b2a4a !important;
    }

    /* ============================================================
       CONTENT AREA
    ============================================================ */
    .content-wrapper {
      background: #f4f6f9 !important;
    }

    .content-header h1 {
      font-size: 22px !important;
      font-weight: 700 !important;
      color: #1b2a4a !important;
    }

    .breadcrumb {
      background: transparent !important;
      padding: 0 !important;
    }
    .breadcrumb-item a { color: #4d8ef0 !important; }
    .breadcrumb-item.active { color: #6b7280 !important; }
    .breadcrumb-item + .breadcrumb-item::before { color: #9ca3af !important; }

    /* ============================================================
       STAT CARDS (custom small-box override)
    ============================================================ */
    .small-box {
      border-radius: 10px !important;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0,0,0,0.10) !important;
      transition: transform 0.22s, box-shadow 0.22s !important;
    }
    .small-box:hover {
      transform: translateY(-4px) !important;
      box-shadow: 0 10px 32px rgba(0,0,0,0.16) !important;
    }

    .small-box > .inner h3 {
      font-size: 38px !important;
      font-weight: 800 !important;
      font-family: 'Inter', sans-serif !important;
    }

    .small-box > .inner p {
      font-size: 13px !important;
      font-weight: 500 !important;
      letter-spacing: 0.2px !important;
    }

    .small-box > .icon > i {
      font-size: 72px !important;
      top: 10px !important;
      right: 12px !important;
    }

    .small-box .small-box-footer {
      padding: 8px !important;
      font-size: 12.5px !important;
      font-weight: 500 !important;
      background: rgba(0,0,0,0.12) !important;
      transition: background 0.18s !important;
    }
    .small-box .small-box-footer:hover {
      background: rgba(0,0,0,0.2) !important;
    }

    /* Custom colors */
    .bg-teal    { background-color: #0f9d8c !important; }
    .bg-indigo  { background-color: #4f46e5 !important; }
    .bg-amber   { background-color: #d97706 !important; }
    .bg-rose    { background-color: #e11d48 !important; }
    .bg-slate   { background-color: #475569 !important; }

    /* ============================================================
       CHART CARDS
    ============================================================ */
    .chart-card {
      background: #fff;
      border-radius: 12px;
      border: 1px solid #e9ecef;
      overflow: hidden;
      box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }
    .chart-card-header {
      padding: 16px 20px;
      border-bottom: 1px solid #f1f3f5;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .chart-card-header h3 {
      font-size: 14px;
      font-weight: 600;
      color: #1b2a4a;
      margin: 0;
    }
    .chart-card-header .chart-icon {
      width: 32px; height: 32px; border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      font-size: 14px;
    }
    .chart-card-body { padding: 20px; }

    /* ============================================================
       FOOTER
    ============================================================ */
    .main-footer {
      background: #fff !important;
      border-top: 1px solid #e9ecef !important;
      color: #6b7280 !important;
      font-size: 12.5px !important;
      padding: 12px 24px !important;
    }
    .main-footer strong { color: #1b2a4a !important; }

    /* ============================================================
       SIDEBAR WIDTH OFFSET FOR CONTENT
    ============================================================ */
    @media (min-width: 768px) {
      .sidebar-mini.sidebar-open .content-wrapper,
      .sidebar-mini .content-wrapper,
      .sidebar-mini .main-header,
      .sidebar-mini .main-footer {
        margin-left: 248px !important;
      }
      .sidebar-mini.sidebar-collapse .content-wrapper,
      .sidebar-mini.sidebar-collapse .main-header,
      .sidebar-mini.sidebar-collapse .main-footer {
        margin-left: 4.6rem !important;
      }
    }

    /* ============================================================
       FLASH ALERTS
    ============================================================ */
    .alert {
      border-radius: 8px !important;
      border: none !important;
      font-size: 13.5px !important;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- ======================== TOPBAR ======================== -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
          <i class="fas fa-bars"></i>
        </a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" style="display:flex;align-items:center;gap:8px;">
          <span style="width:30px;height:30px;border-radius:50%;background:#1b2a4a;display:flex;align-items:center;justify-content:center;">
            <i class="fas fa-user" style="color:#fff;font-size:12px;"></i>
          </span>
          <span style="font-size:13.5px;font-weight:600;color:#374151;"><?= session()->get('name') ?></span>
          <i class="fas fa-chevron-down" style="font-size:10px;color:#9ca3af;"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" style="border-radius:10px;border:1px solid #e9ecef;box-shadow:0 8px 24px rgba(0,0,0,0.10);min-width:200px;padding:8px 0;">
          <div style="padding:10px 16px;border-bottom:1px solid #f3f4f6;">
            <div style="font-size:13px;font-weight:600;color:#1b2a4a;"><?= session()->get('name') ?></div>
            <div style="font-size:11.5px;color:#6b7280;"><?= ucfirst(str_replace('_', ' ', session()->get('role'))) ?></div>
          </div>
          <a href="<?= site_url('logout') ?>" class="dropdown-item" style="font-size:13px;padding:10px 16px;color:#e11d48;">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- ======================== SIDEBAR ======================== -->
  <aside class="main-sidebar sidebar-dark-primary elevation-0">

    <!-- Brand -->
    <a href="<?= site_url('admin/dashboard') ?>" class="brand-link" style="display: flex; align-items: center; justify-content: center; padding: 15px 0; border-bottom: 1px solid #e2e8f0;">
      <img src="<?= base_url('assets/img/logo-siposka-horizontal.png') ?>" alt="Logo SIPOSKA" style="width: auto; height: 35px; border-radius: 0;">
    </a>

    <div class="sidebar">

      <!-- User Panel -->
      <div class="user-panel mt-0 pb-0 mb-0 d-flex align-items-center">
        <div class="image" style="display:flex;align-items:center;margin-right:10px;">
          <span style="width:34px;height:34px;border-radius:50%;background:rgba(77,142,240,0.2);display:flex;align-items:center;justify-content:center;border:1px solid rgba(77,142,240,0.3);">
            <i class="fas fa-user" style="color:#4d8ef0;font-size:14px;"></i>
          </span>
        </div>
        <div class="info">
          <a href="#" class="d-block" style="font-size:13px;"><?= session()->get('name') ?></a>
          <small><?= ucfirst(str_replace('_', ' ', session()->get('role'))) ?></small>
        </div>
      </div>

      <!-- Nav Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <!-- UTAMA -->
          <li class="nav-header">UTAMA</li>
          <li class="nav-item">
            <a href="<?= site_url('admin/dashboard') ?>"
               class="nav-link <?= (uri_string() === 'admin/dashboard') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <!-- DATA KESEHATAN -->
          <li class="nav-header">DATA KESEHATAN</li>
          <?php if (in_array(session()->get('role'), ['superadmin', 'admin_dinas', 'admin'])): ?>
          <li class="nav-item">
            <a href="<?= site_url('admin/posyandu') ?>"
               class="nav-link <?= str_starts_with(uri_string(), 'admin/posyandu') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-clinic-medical"></i>
              <p>Manajemen Posyandu</p>
            </a>
          </li>
          <?php endif; ?>
          <li class="nav-item">
            <a href="<?= site_url('admin/balita') ?>"
               class="nav-link <?= str_starts_with(uri_string(), 'admin/balita') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-child"></i>
              <p>Data Balita</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= site_url('admin/pengukuran') ?>"
               class="nav-link <?= str_starts_with(uri_string(), 'admin/pengukuran') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-weight"></i>
              <p>Data Pengukuran Balita</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= site_url('admin/ibu_hamil') ?>"
               class="nav-link <?= str_starts_with(uri_string(), 'admin/ibu_hamil') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-female"></i>
              <p>Data Ibu Hamil</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= site_url('admin/remaja') ?>"
               class="nav-link <?= str_starts_with(uri_string(), 'admin/remaja') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-user-graduate"></i>
              <p>Data Remaja</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= site_url('admin/usia_produktif') ?>"
               class="nav-link <?= str_starts_with(uri_string(), 'admin/usia_produktif') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-briefcase"></i>
              <p>Data Usia Produktif</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= site_url('admin/lansia') ?>"
               class="nav-link <?= str_starts_with(uri_string(), 'admin/lansia') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>Data Lansia</p>
            </a>
          </li>

          <!-- PENGATURAN -->
          <?php if (in_array(session()->get('role'), ['superadmin', 'admin'])): ?>
          <li class="nav-header">PENGATURAN</li>
          <li class="nav-item">
            <a href="<?= site_url('admin/user') ?>"
               class="nav-link <?= str_starts_with(uri_string(), 'admin/user') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>Manajemen User</p>
            </a>
          </li>
          <?php endif; ?>

        </ul>
      </nav>
    </div>
  </aside>

  <!-- ======================== CONTENT ======================== -->
  <div class="content-wrapper watermark-bg">

    <!-- Content Header -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <h1 class="mb-0"><?= $title ?? 'Panel Admin' ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right mb-0">
              <li class="breadcrumb-item"><a href="<?= site_url('admin/dashboard') ?>">Home</a></li>
              <li class="breadcrumb-item active"><?= $title ?? '' ?></li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Flash Messages -->
    <section class="content pt-0">
      <div class="container-fluid">

        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
          </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
          </div>
        <?php endif; ?>

      </div>
    </section>

    <!-- Main Content -->
    <section class="content">
      <?= $this->renderSection('content') ?>
    </section>

  </div>
  <!-- /.content-wrapper -->

  <!-- ======================== FOOTER ======================== -->
  <footer class="main-footer">
    <strong>&copy; <?= date('Y') ?> SIPOSKA &mdash; Sistem Informasi Posyandu Kandangan.</strong>
    <div class="float-right d-none d-sm-block">
      <b>Versi</b> 1.0.0
    </div>
  </footer>

</div>
<!-- /.wrapper -->

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<?= $this->renderSection('scripts') ?>

</body>
</html>