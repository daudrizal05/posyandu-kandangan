<?php
ob_start(); ?>

<div class="page-hero">
  <h1><i class="fas fa-file-alt" style="margin-right:10px;opacity:.85;"></i><?= esc($halaman['judul'] ?? 'Halaman') ?></h1>
  <div class="breadcrumb-pub"><a href="<?= site_url('/') ?>">Home</a> / <?= esc($halaman['judul'] ?? 'Halaman') ?></div>
</div>

<main style="max-width:900px;margin:0 auto;padding:48px 20px;">
    <div style="background:#fff;border-radius:14px;border:1px solid #e2e8f0;padding:40px;box-shadow:0 2px 12px rgba(0,0,0,0.05);">
        <h2 style="font-size:24px;font-weight:700;margin-bottom:20px;color:#1e293b;"><?= esc($halaman['judul'] ?? 'Halaman') ?></h2>
        <hr style="border:none;border-top:1px solid #e2e8f0;margin-bottom:20px;">
        
        <div style="font-size:14px;line-height:1.8;color:#475569;" class="content-wrapper">
            <?= $halaman['konten'] ?? '' ?>
        </div>
    </div>
</main>

<style>
.content-wrapper p {
    margin-bottom: 15px;
}
.content-wrapper img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 15px 0;
}
.content-wrapper h1, .content-wrapper h2, .content-wrapper h3 {
    margin-top: 25px;
    margin-bottom: 15px;
    color: #1e293b;
}
.content-wrapper ul, .content-wrapper ol {
    margin-left: 20px;
    margin-bottom: 15px;
}
</style>

<?php
$content = ob_get_clean();
include __DIR__ . '/../_layout.php';
?>
