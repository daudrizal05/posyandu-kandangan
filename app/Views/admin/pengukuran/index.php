<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Ibu Hamil</h3>
            <div class="card-tools">
                <a href="<?= site_url('admin/pengukuran/create') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Ibu Hamil
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="" method="get" class="mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari NIK / Nama..." value="<?= esc($keyword) ?>">
                    </div>
                    <div class="col-md-3">
                        <select name="posyandu_id" class="form-control">
                            <option value="">Semua Posyandu</option>
                            <?php foreach ($posyandu as $p): ?>
                                <option value="<?= $p['id'] ?>" <?= $posyandu_id == $p['id'] ? 'selected' : '' ?>><?= esc($p['nama_posyandu']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="bulan" class="form-control">
                            <option value="">Semua Bulan</option>
                            <?php for($i=1; $i<=12; $i++): ?>
                                <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>" <?= $bulan == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' ?>><?= date('F', mktime(0, 0, 0, $i, 10)) ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="tahun" class="form-control">
                            <option value="">Semua Tahun</option>
                            <?php for($i=date('Y'); $i>=date('Y')-5; $i--): ?>
                                <option value="<?= $i ?>" <?= $tahun == $i ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-secondary btn-block">Filter</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover text-sm">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Tanggal</th>
                            <th>Balita (NIK)</th>
                            <th>Posyandu</th>
                            <th>Usia (Bln)</th>
                            <th>BB (kg)</th>
                            <th>TB (cm)</th>
                            <th>Status Gizi</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pengukuran)): ?>
                        <tr>
                            <td colspan="9" class="text-center">Belum ada data.</td>
                        </tr>
                        <?php else: ?>
                            <?php $no = 1 + (10 * ($pager->getCurrentPage('pengukuran') - 1)); ?>
                            <?php foreach ($pengukuran as $p): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= date('d-m-Y', strtotime($p['tanggal_pengukuran'])) ?></td>
                                <td><?= esc($p['nama_balita']) ?> <br><small><?= esc($p['nik']) ?></small></td>
                                <td><?= esc($p['nama_posyandu']) ?></td>
                                <td><?= $p['usia_bulan'] ?></td>
                                <td><?= $p['berat_badan'] ?></td>
                                <td><?= $p['tinggi_badan'] ?></td>
                                <td>
                                    <?php 
                                        $badge = 'secondary';
                                        if($p['status_gizi'] == 'normal') $badge = 'success';
                                        if($p['status_gizi'] == 'kurang') $badge = 'warning';
                                        if($p['status_gizi'] == 'stunting') $badge = 'danger';
                                        if($p['status_gizi'] == 'gizi_buruk') $badge = 'dark';
                                    ?>
                                    <span class="badge badge-<?= $badge ?>"><?= strtoupper(str_replace('_', ' ', $p['status_gizi'])) ?></span>
                                </td>
                                <td>
                                    <a href="<?= site_url('admin/pengukuran/edit/'.$p['id']) ?>" class="btn btn-xs btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?= site_url('admin/pengukuran/delete/'.$p['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-xs btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                <?= $pager->links('pengukuran', 'default_full') ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
