<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Balita</h3>
            <div class="card-tools">
                <a href="<?= site_url('admin/balita/create') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Balita
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="" method="get" class="mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari NIK / Nama Balita..." value="<?= esc($keyword) ?>">
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
                        <button type="submit" class="btn btn-secondary">Filter</button>
                        <a href="<?= site_url('admin/balita') ?>" class="btn btn-default">Reset</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>JK</th>
                            <th>Tgl Lahir</th>
                            <th>Nama Ortu</th>
                            <th>Posyandu</th>
                            <th>Berat</th>
                            <th>Tinggi</th>
                            <th>BB/U</th>
                            <th>ZS BB/U</th>
                            <th>TB/U</th>
                            <th>ZS TB/U</th>
                            <th>BB/TB</th>
                            <th>ZS BB/TB</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($balita)): ?>
                        <tr>
                            <td colspan="9" class="text-center">Belum ada data.</td>
                        </tr>
                        <?php else: ?>
                            <?php $no = 1 + (10 * ($pager->getCurrentPage('balita') - 1)); ?>
                            <?php foreach ($balita as $b): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($b['nama_balita']) ?></td>
                                <td><?= $b['jenis_kelamin'] == 'L' ? 'L' : 'P' ?></td>
                                <td><?= date('d-m-Y', strtotime($b['tanggal_lahir'])) ?></td>
                                <td><?= esc($b['nama_ibu'] ?? $b['nama_ayah'] ?? '-') ?></td>
                                <td><?= esc($b['nama_posyandu']) ?></td>
                                <td><?= esc($b['berat'] ?? '-') ?></td>
                                <td><?= esc($b['tinggi'] ?? '-') ?></td>
                                <td><?= esc($b['bb_u'] ?? '-') ?></td>
                                <td><?= esc($b['zs_bb_u'] ?? '-') ?></td>
                                <td><?= esc($b['tb_u'] ?? '-') ?></td>
                                <td><?= esc($b['zs_tb_u'] ?? '-') ?></td>
                                <td><?= esc($b['bb_tb'] ?? '-') ?></td>
                                <td><?= esc($b['zs_bb_tb'] ?? '-') ?></td>
                                <td>
                                    <a href="<?= site_url('admin/balita/edit/'.$b['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?= site_url('admin/balita/delete/'.$b['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
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
                <?= $pager->links('balita', 'default_full') ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
