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
    .navbar .wrap{max-width:1200px;margin:0 auto;padding:0 20px;display:flex;align-items:center;height:64px;}
    .nav-logo{display:flex;align-items:center;gap:10px;margin-right:28px;}
    .nav-logo img{width:36px;height:36px;object-fit:contain;border-radius:6px;}
    .logo-title{font-size:16px;font-weight:700;color:var(--blue);display:block;}
    .logo-sub{font-size:9px;color:var(--muted);}
    .nav-links{display:flex;align-items:center;flex:1;gap:2px;}
    .nav-links>a,.dd-trigger{padding:8px 13px;font-size:13.5px;font-weight:500;color:var(--text);border-radius:7px;transition:all .18s;cursor:pointer;border:none;background:none;font-family:inherit;}
    .nav-links>a:hover,.dd-trigger:hover,.nav-links>a.active{color:var(--blue);background:var(--blue-lt);}
    .dd{position:relative;}
    .dd-panel{display:none;position:absolute;top:calc(100% + 8px);left:0;background:#fff;border-radius:12px;min-width:220px;box-shadow:0 10px 36px rgba(0,0,0,.12);border:1px solid var(--border);padding:6px 0;z-index:1000;}
    .dd:hover .dd-panel{display:block;}
    .dd-panel a{display:flex;align-items:center;gap:10px;padding:10px 16px;font-size:13px;color:var(--text);}
    .dd-panel a:hover{background:var(--blue-lt);color:var(--blue);}
    .dd-panel a i{width:16px;text-align:center;color:var(--muted);font-size:12px;}
    .dd-header{padding:6px 16px 4px;font-size:10px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:var(--muted);}
    .btn-login{margin-left:auto;padding:9px 22px;background:var(--blue);color:#fff;border-radius:8px;font-size:13.5px;font-weight:600;}
    .page-header{background:linear-gradient(135deg,#7c3aed 0%,#5b21b6 100%);padding:40px 20px;color:#fff;}
    .page-header .wrap{max-width:1200px;margin:0 auto;}
    .breadcrumb{font-size:12px;margin-bottom:12px;opacity:.75;}
    .breadcrumb a{color:rgba(255,255,255,.8);}
    .breadcrumb span{margin:0 8px;}
    .page-header h1{font-size:24px;font-weight:700;margin-bottom:6px;}
    .page-header p{font-size:13px;opacity:.8;}
    .page-content{max-width:1200px;margin:0 auto;padding:36px 20px;}
    .filter-bar{background:var(--gray-bg);border:1px solid var(--border);border-radius:12px;padding:18px 20px;margin-bottom:28px;display:flex;gap:12px;align-items:center;}
    .filter-bar input{flex:1;padding:10px 14px;border:1.5px solid var(--border);border-radius:8px;font-size:13.5px;font-family:'Poppins',sans-serif;}
    .filter-bar input:focus{outline:none;border-color:var(--blue);}
    .filter-bar button{padding:10px 22px;background:#7c3aed;color:#fff;border:none;border-radius:8px;font-size:13.5px;font-family:'Poppins',sans-serif;font-weight:600;cursor:pointer;}
    .table-wrap{background:#fff;border-radius:14px;border:1px solid var(--border);overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.05);}
    .table-head{background:#7c3aed;color:#fff;padding:16px 20px;}
    .table-head h3{font-size:15px;font-weight:600;}
    table{width:100%;border-collapse:collapse;}
    th{background:var(--gray-bg);padding:12px 14px;text-align:left;font-size:12px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;border-bottom:1px solid var(--border);}
    td{padding:13px 14px;font-size:13.5px;border-bottom:1px solid var(--border);}
    tr:last-child td{border-bottom:none;}
    tr:hover td{background:#fafbff;}
    .badge{display:inline-block;padding:3px 10px;border-radius:50px;font-size:11.5px;font-weight:600;}
    .badge-aktif{background:#d1fae5;color:#065f46;}
    .badge-lain{background:#fef3c7;color:#92400e;}
    .empty{padding:48px;text-align:center;color:var(--muted);}
    .empty i{font-size:44px;opacity:.3;margin-bottom:12px;display:block;}
    .pagination{padding:16px 20px;display:flex;justify-content:flex-end;}
    .back-btn{display:inline-flex;align-items:center;gap:8px;margin-bottom:24px;font-size:13.5px;color:var(--muted);}
    .back-btn:hover{color:var(--blue);}
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

<div class="page-header">
  <div class="wrap">
    <div class="breadcrumb">
      <a href="<?= site_url('/') ?>">Home</a><span>›</span>
      <a href="<?= site_url('posyandu-' . $posyandu['id']) ?>"><?= esc($posyandu['nama_posyandu']) ?></a><span>›</span>
      Data Ibu Hamil
    </div>
    <h1><i class="fas fa-female" style="margin-right:10px;"></i>Data Ibu Hamil – <?= esc($posyandu['nama_posyandu']) ?></h1>
    <p>Daftar ibu hamil aktif yang terdaftar di posyandu ini.</p>
  </div>
</div>

<div class="page-content">
  <a href="<?= site_url('posyandu-' . $posyandu['id']) ?>" class="back-btn">
    <i class="fas fa-arrow-left"></i> Kembali ke Detail Posyandu
  </a>

  <form class="filter-bar" method="get">
    <input type="text" name="keyword" placeholder="Cari NIK atau nama ibu..." value="<?= esc($keyword ?? '') ?>">
    <button type="submit"><i class="fas fa-search"></i> Cari</button>
    <?php if (!empty($keyword)): ?>
      <a href="<?= site_url('posyandu-' . $posyandu['id'] . '/ibu-hamil') ?>" style="padding:10px 18px;color:var(--muted);font-size:13.5px;">Reset</a>
    <?php endif; ?>
  </form>

  <div class="table-wrap">
    <div class="table-head">
      <h3><i class="fas fa-list" style="margin-right:8px;"></i>Daftar Ibu Hamil</h3>
    </div>
    <?php if (!empty($ibuHamil)): ?>
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>NIK</th>
          <th>Nama Ibu</th>
          <th>Nama Suami</th>
          <th>No. HP</th>
          <th>Taksiran Lahir</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1 + (10 * ($pager->getCurrentPage('ibu_hamil') - 1)); ?>
        <?php foreach ($ibuHamil as $ih): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= esc($ih['nik']) ?></td>
          <td><strong><?= esc($ih['nama_ibu']) ?></strong></td>
          <td><?= esc($ih['nama_suami'] ?? '-') ?></td>
          <td><?= esc($ih['no_hp'] ?? '-') ?></td>
          <td><?= $ih['taksiran_lahir'] ? date('d/m/Y', strtotime($ih['taksiran_lahir'])) : '-' ?></td>
          <td>
            <?php if ($ih['status'] === 'aktif'): ?>
              <span class="badge badge-aktif">Aktif</span>
            <?php else: ?>
              <span class="badge badge-lain"><?= ucfirst($ih['status']) ?></span>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="pagination">
      <?= $pager->links('ibu_hamil', 'default_full') ?>
    </div>
    <?php else: ?>
    <div class="empty">
      <i class="fas fa-female"></i>
      <p>Belum ada data ibu hamil<?= !empty($keyword) ? ' dengan pencarian "<strong>' . esc($keyword) . '</strong>"' : '' ?>.</p>
    </div>
    <?php endif; ?>
  </div>
</div>

<footer>
  <p>&copy; <?= date('Y') ?> <strong>SIPOSKA</strong> &mdash; Sistem Informasi Posyandu Kandangan</p>
</footer>

</body>
</html>
