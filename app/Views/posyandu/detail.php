
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($title) ?></title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    *,*::before,*::after{margin:0;padding:0;box-sizing:border-box;}
    :root{--blue:#1a56db;--blue-dk:#1344b0;--blue-lt:#eff4ff;--gray-bg:#f1f5fb;--text:#1e293b;--muted:#64748b;--border:#e2e8f0;}
    body{font-family:'Poppins',sans-serif;color:var(--text);background:#fff;}
    a{text-decoration:none;color:inherit;}

    .navbar{background:#fff;box-shadow:0 1px 0 var(--border),0 4px 16px rgba(0,0,0,.06);position:sticky;top:0;z-index:999;}
    .navbar .wrap{max-width:1200px;margin:0 auto;padding:0 20px;display:flex;align-items:center;height:64px;gap:0;}
    .nav-logo{display:flex;align-items:center;gap:10px;margin-right:28px;}
    .nav-logo img{width:36px;height:36px;object-fit:contain;border-radius:6px;}
    .logo-title{font-size:16px;font-weight:700;color:var(--blue);display:block;}
    .logo-sub{font-size:9px;color:var(--muted);}
    .nav-links{display:flex;align-items:center;flex:1;gap:2px;}
    .nav-links>a,.dd-trigger{padding:8px 13px;font-size:13.5px;font-weight:500;color:var(--text);border-radius:7px;transition:all .18s;cursor:pointer;border:none;background:none;font-family:inherit;}
    .nav-links>a:hover,.dd-trigger:hover,.nav-links>a.active{color:var(--blue);background:var(--blue-lt);}
    .dd{position:relative;}
    .dd-panel{display:none;position:absolute;top:calc(100% + 8px);left:0;background:#fff;border-radius:12px;min-width:220px;box-shadow:0 10px 36px rgba(0,0,0,.12);border:1px solid var(--border);overflow:hidden;z-index:1000;padding:6px 0;}
    .dd:hover .dd-panel{display:block;}
    .dd-panel a{display:flex;align-items:center;gap:10px;padding:10px 16px;font-size:13px;color:var(--text);}
    .dd-panel a:hover{background:var(--blue-lt);color:var(--blue);}
    .dd-panel a i{width:16px;text-align:center;color:var(--muted);font-size:12px;}
    .dd-header{padding:6px 16px 4px;font-size:10px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:var(--muted);}
    .btn-login{margin-left:auto;padding:9px 22px;background:var(--blue);color:#fff;border-radius:8px;font-size:13.5px;font-weight:600;transition:all .2s;}
    .btn-login:hover{background:var(--blue-dk);}
    /* page content */
    .page-header{background:linear-gradient(135deg,var(--blue) 0%,var(--blue-dk) 100%);padding:48px 20px;color:#fff;}
    .page-header .wrap{max-width:1200px;margin:0 auto;}
    .breadcrumb{font-size:12.5px;margin-bottom:12px;opacity:.75;}
    .breadcrumb a{color:rgba(255,255,255,.8);}
    .breadcrumb a:hover{color:#fff;}
    .breadcrumb span{margin:0 8px;}
    .page-header h1{font-size:28px;font-weight:700;margin-bottom:8px;}
    .page-header p{font-size:13.5px;opacity:.8;max-width:500px;line-height:1.7;}
    .page-content{max-width:1200px;margin:0 auto;padding:40px 20px;}
    .info-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:36px;}
    .info-card{background:var(--gray-bg);border-radius:12px;padding:24px;border:1px solid var(--border);text-align:center;}
    .info-card .val{font-size:32px;font-weight:800;color:var(--blue);margin-bottom:4px;}
    .info-card .lbl{font-size:12px;color:var(--muted);font-weight:500;}
    .detail-section{background:var(--gray-bg);border-radius:14px;padding:28px;border:1px solid var(--border);margin-bottom:24px;}
    .detail-section h3{font-size:16px;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px;}
    .detail-section h3 i{color:var(--blue);}
    .detail-row{display:flex;gap:12px;margin-bottom:12px;font-size:13.5px;}
    .detail-row .key{width:160px;flex-shrink:0;color:var(--muted);}
    .detail-row .val{font-weight:500;}
    .action-buttons{display:flex;gap:12px;flex-wrap:wrap;}
    .btn-act{display:inline-flex;align-items:center;gap:8px;padding:11px 22px;border-radius:9px;font-size:13.5px;font-weight:600;transition:all .2s;}
    .btn-act.primary{background:var(--blue);color:#fff;}
    .btn-act.primary:hover{background:var(--blue-dk);box-shadow:0 4px 14px rgba(26,86,219,.3);}
    .btn-act.outline{background:#fff;color:var(--blue);border:1.5px solid var(--blue);}
    .btn-act.outline:hover{background:var(--blue-lt);}
    footer{background:var(--blue-dk);color:rgba(255,255,255,.8);text-align:center;padding:20px;font-size:12.5px;}
    footer strong{color:#fff;}
  </style>
</head>
<body>

<nav class="navbar">
  <div class="wrap">
    <a href="<?= site_url('/') ?>" class="nav-logo">
      <img src="<?= base_url('assets/img/logo-siposka.png') ?>" alt="Logo">
      <div>
        <span class="logo-title">SIPOSKA</span>
        <span class="logo-sub">Sistem Informasi Posyandu Kandangan</span>
      </div>
    </a>
    <div class="nav-links">
      <a href="<?= site_url('/') ?>">Home</a>
      <div class="dd">
        <button class="dd-trigger active">Data Posyandu <i class="fas fa-chevron-down" style="font-size:9px;opacity:.5;"></i></button>
        <div class="dd-panel">
          <div class="dd-header">Pilih Posyandu</div>
          <?php foreach ($posyanduList as $p): ?>
            <a href="<?= site_url('posyandu-' . $p['id']) ?>" <?= $p['id'] == $posyandu['id'] ? 'style="color:var(--blue);background:var(--blue-lt);"' : '' ?>>
              <i class="fas fa-clinic-medical"></i> <?= esc($p['nama_posyandu']) ?>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
      <a href="#">Infografis</a>
      <a href="#">Berita</a>
    </div>
    <a href="<?= site_url('login') ?>" class="btn-login">Login</a>
  </div>
</nav>

<!-- Page Header -->
<div class="page-header">
  <div class="wrap">
    <div class="breadcrumb">
      <a href="<?= site_url('/') ?>">Home</a><span>›</span>
      <a href="#">Data Posyandu</a><span>›</span>
      <?= esc($posyandu['nama_posyandu']) ?>
    </div>
    <h1><i class="fas fa-clinic-medical" style="margin-right:10px;"></i><?= esc($posyandu['nama_posyandu']) ?></h1>
    <p><?= esc($posyandu['alamat'] ?? '') ?> &mdash; <?= esc($posyandu['desa_kelurahan'] ?? '') ?></p>
  </div>
</div>

<!-- Content -->
<div class="page-content">

  <!-- Stats -->
  <div class="info-grid">
    <div class="info-card">
      <div class="val"><?= $totalBalita ?></div>
      <div class="lbl"><i class="fas fa-child"></i> Total Balita</div>
    </div>
    <div class="info-card">
      <div class="val"><?= $balitaL ?></div>
      <div class="lbl"><i class="fas fa-mars"></i> Balita Laki-laki</div>
    </div>
    <div class="info-card">
      <div class="val"><?= $balitaP ?></div>
      <div class="lbl"><i class="fas fa-venus"></i> Balita Perempuan</div>
    </div>
  </div>

  <!-- Info Posyandu -->
  <div class="detail-section">
    <h3><i class="fas fa-info-circle"></i> Informasi Posyandu</h3>
    <div class="detail-row"><div class="key">Nama Posyandu</div><div class="val"><?= esc($posyandu['nama_posyandu']) ?></div></div>
    <div class="detail-row"><div class="key">Alamat</div><div class="val"><?= esc($posyandu['alamat'] ?? '-') ?></div></div>
    <div class="detail-row"><div class="key">Desa/Kelurahan</div><div class="val"><?= esc($posyandu['desa_kelurahan'] ?? '-') ?></div></div>
    <div class="detail-row"><div class="key">Kecamatan</div><div class="val"><?= esc($posyandu['kecamatan'] ?? '-') ?></div></div>
    <div class="detail-row"><div class="key">Ketua Kader</div><div class="val"><?= esc($posyandu['nama_ketua_kader'] ?? '-') ?></div></div>
    <div class="detail-row"><div class="key">Kontak</div><div class="val"><?= esc($posyandu['kontak'] ?? '-') ?></div></div>
    <div class="detail-row"><div class="key">Status</div><div class="val"><span style="background:#d1fae5;color:#065f46;padding:3px 10px;border-radius:50px;font-size:12px;"><?= ucfirst($posyandu['status']) ?></span></div></div>
  </div>

  <!-- Actions -->
  <div class="action-buttons">
    <a href="<?= site_url('posyandu-' . $posyandu['id'] . '/balita') ?>" class="btn-act primary">
      <i class="fas fa-child"></i> Lihat Data Balita
    </a>
    <a href="<?= site_url('posyandu-' . $posyandu['id'] . '/ibu-hamil') ?>" class="btn-act outline">
      <i class="fas fa-female"></i> Lihat Data Ibu Hamil
    </a>
    <a href="<?= site_url('/') ?>" class="btn-act outline">
      <i class="fas fa-arrow-left"></i> Kembali ke Beranda
    </a>
  </div>

</div>

<footer>
  <p>&copy; <?= date('Y') ?> <strong>SIPOSKA</strong> &mdash; Sistem Informasi Posyandu Kandangan</p>
</footer>

</body>
</html>
