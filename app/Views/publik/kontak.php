<?= $this->extend('publik/_layout') ?>

<?= $this->section('content') ?>
<div class="py-5" style="background:#f8fafc; min-height:60vh; text-align:center;">
    <div class="container">
        <h2 style="color:#1e40af; font-weight:700; margin-bottom:20px;">Kontak Kami</h2>
        <p style="color:#475569; font-size:18px; max-width:600px; margin:0 auto 40px;">
            Ada pertanyaan atau butuh bantuan? Jangan ragu untuk menghubungi kami melalui form pesan atau kontak yang tersedia.
        </p>
        <div style="background:#ffffff; padding:40px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.05); max-width:600px; margin:0 auto;">
            <i class="fas fa-envelope" style="font-size:40px; color:#1a56db; margin-bottom:20px;"></i>
            <h4 style="color:#1e293b; margin-bottom:10px;">Kirim Pesan</h4>
            <p style="color:#64748b; margin-bottom:20px;">Untuk mengirim pesan kepada administrator, silakan kembali ke halaman utama dan gunakan fitur pengiriman pesan di sana.</p>
            <a href="<?= site_url() ?>" style="display:inline-block; padding:10px 25px; background:#1a56db; color:#fff; text-decoration:none; border-radius:6px; font-weight:500;">Kembali ke Beranda</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
