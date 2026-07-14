<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Manajemen Posyandu</h3>
            <div class="card-tools">
                <a href="<?= site_url('admin/posyandu/create') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Posyandu
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="" method="get" class="mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari nama posyandu / kecamatan..." value="<?= esc($keyword) ?>">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="aktif" <?= $status == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= $status == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-secondary">Filter</button>
                        <a href="<?= site_url('admin/posyandu') ?>" class="btn btn-default">Reset</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Posyandu</th>
                            <th>Alamat</th>
                            <th>Desa / Kec</th>
                            <th>Ketua Kader</th>
                            <th>Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($posyandu)): ?>
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data.</td>
                        </tr>
                        <?php else: ?>
                            <?php $no = 1 + (10 * ($pager->getCurrentPage('posyandu') - 1)); ?>
                            <?php foreach ($posyandu as $p): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <?= esc($p['nama_posyandu']) ?><br>
                                    <?php if ($p['foto']): ?>
                                        <a href="<?= base_url('uploads/posyandu/' . $p['foto']) ?>" target="_blank" class="badge badge-info">Lihat Foto</a>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($p['alamat']) ?></td>
                                <td><?= esc($p['desa_kelurahan']) ?> / <?= esc($p['kecamatan']) ?></td>
                                <td><?= esc($p['nama_ketua_kader']) ?> <br> <small><?= esc($p['kontak']) ?></small></td>
                                <td>
                                    <?php if ($p['status'] == 'aktif'): ?>
                                        <span class="badge badge-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= site_url('admin/posyandu/edit/'.$p['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?= site_url('admin/posyandu/delete/'.$p['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
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
                <?= $pager->links('posyandu', 'default_full') ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
