<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Lansia</h3>
            <div class="card-tools">
                <a href="<?= site_url('admin/ibu_hamil/create') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Lansia
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Filter -->
            <form action="" method="get" class="mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari NIK / Nama Ibu..." value="<?= esc($keyword) ?>">
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
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="aktif"   <?= $status == 'aktif'   ? 'selected' : '' ?>>Aktif</option>
                            <option value="selesai" <?= $status == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                            <option value="pindah"  <?= $status == 'pindah'  ? 'selected' : '' ?>>Pindah</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-secondary">Filter</button>
                        <a href="<?= site_url('admin/ibu_hamil') ?>" class="btn btn-default">Reset</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Tgl Lahir</th>
                            <th>Umur</th>
                            <th>Lingkar Lengan</th>
                            <th>BB</th>
                            <th>TB</th>
                            <th>Lingkar Pinggang</th>
                            <th>IMT</th>
                            <th>NIK</th>
                            <th>No BPJS</th>
                            <th>Keluhan</th>
                            <th>Tensi</th>
                            <th>Obat</th>
                            <th width="12%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($ibu_hamil)): ?>
                        <tr>
                            <td colspan="9" class="text-center">Belum ada data.</td>
                        </tr>
                        <?php else: ?>
                            <?php $no = 1 + (10 * ($pager->getCurrentPage('ibu_hamil') - 1)); ?>
                            <?php foreach ($ibu_hamil as $ih): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($ih['nama_ibu']) ?></td>
                                <td><?= esc($ih['alamat'] ?? '-') ?></td>
                                <td><?= $ih['tanggal_lahir'] ? date('d-m-Y', strtotime($ih['tanggal_lahir'])) : '-' ?></td>
                                <td><?= esc($ih['umur'] ?? '-') ?></td>
                                <td><?= esc($ih['lingkar_lengan'] ?? '-') ?></td>
                                <td><?= esc($ih['berat'] ?? '-') ?></td>
                                <td><?= esc($ih['tinggi'] ?? '-') ?></td>
                                <td><?= esc($ih['lingkar_pinggang'] ?? '-') ?></td>
                                <td><?= esc($ih['imt'] ?? '-') ?></td>
                                <td><?= esc($ih['nik']) ?></td>
                                <td><?= esc($ih['no_bpjs'] ?? '-') ?></td>
                                <td><?= esc($ih['keluhan'] ?? '-') ?></td>
                                <td><?= esc($ih['tensi'] ?? '-') ?></td>
                                <td><?= esc($ih['obat'] ?? '-') ?></td>
                                <td>
                                    <a href="<?= site_url('admin/ibu_hamil/edit/' . $ih['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?= site_url('admin/ibu_hamil/delete/' . $ih['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
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
                <?= $pager->links('ibu_hamil', 'default_full') ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
