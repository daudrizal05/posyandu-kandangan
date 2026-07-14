<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tambah Pengukuran</h3>
                </div>
                
                <?php if(session()->has('errors')): ?>
                    <div class="alert alert-danger mx-3 mt-3">
                        <ul class="mb-0">
                            <?php foreach(session('errors') as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= site_url('admin/pengukuran/store') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="posyandu_id">Posyandu <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="posyandu_id" name="posyandu_id" required>
                                        <option value="">Pilih Posyandu</option>
                                        <?php foreach($posyandu as $p): ?>
                                            <option value="<?= $p['id'] ?>" <?= old('posyandu_id') == $p['id'] ? 'selected' : '' ?>><?= esc($p['nama_posyandu']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="balita_id">Balita <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="balita_id" name="balita_id" required>
                                        <option value="">Pilih Balita</option>
                                        <?php foreach($balita as $b): ?>
                                            <option value="<?= $b['id'] ?>" <?= old('balita_id') == $b['id'] ? 'selected' : '' ?>><?= esc($b['nik']) ?> - <?= esc($b['nama_balita']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tanggal_pengukuran">Tanggal Pengukuran <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="tanggal_pengukuran" name="tanggal_pengukuran" value="<?= old('tanggal_pengukuran', date('Y-m-d')) ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="berat_badan">Berat Badan (kg) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" id="berat_badan" name="berat_badan" value="<?= old('berat_badan') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tinggi_badan">Tinggi Badan (cm) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" id="tinggi_badan" name="tinggi_badan" value="<?= old('tinggi_badan') ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan / Intervensi</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="2" placeholder="Opsional..."><?= old('keterangan') ?></textarea>
                            <small class="text-muted d-block mt-1"><i class="fas fa-info-circle"></i> Catatan: Status Gizi dan Nilai Z-Score (BB/U, TB/U, BB/TB) akan dihitung secara otomatis berdasarkan standar WHO 2006 setelah data disimpan.</small>
                        </div>
                        
                        <input type="hidden" name="petugas_id" value="<?= session()->get('id') ?>">
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?= site_url('admin/pengukuran') ?>" class="btn btn-default float-right">Batal</a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Sub Tabel Riwayat Pengukuran -->
        <div class="col-md-12 mt-4">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Pengukuran Terakhir (Sub Tabel)</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-sm mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>JK</th>
                                    <th>Tgl Lahir</th>
                                    <th>Nama Ortu</th>
                                    <th>Posyandu</th>
                                    <th>Berat (kg)</th>
                                    <th>Tinggi (cm)</th>
                                    <th>BB/U</th>
                                    <th>ZS BB/U</th>
                                    <th>TB/U</th>
                                    <th>ZS TB/U</th>
                                    <th>BB/TB</th>
                                    <th>ZS BB/TB</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($recent)): ?>
                                    <tr><td colspan="14" class="text-center">Belum ada riwayat pengukuran.</td></tr>
                                <?php else: ?>
                                    <?php $no=1; foreach($recent as $r): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= esc($r['nama_balita']) ?></td>
                                        <td><?= esc($r['jenis_kelamin'] == 'L' ? 'L' : 'P') ?></td>
                                        <td><?= date('d/m/Y', strtotime($r['tanggal_lahir'])) ?></td>
                                        <td><?= esc($r['nama_ibu'] ?? $r['nama_ayah']) ?></td>
                                        <td><?= esc($r['nama_posyandu']) ?></td>
                                        <td><?= $r['berat_badan'] ?></td>
                                        <td><?= $r['tinggi_badan'] ?></td>
                                        
                                        <!-- BB/U -->
                                        <td>
                                            <?php 
                                            $bbu = 'Normal';
                                            if($r['zscore_bb_u'] < -3) $bbu = 'Sangat Kurang';
                                            elseif($r['zscore_bb_u'] < -2) $bbu = 'Kurang';
                                            elseif($r['zscore_bb_u'] > 1) $bbu = 'Risiko Lebih';
                                            ?>
                                            <?= $bbu ?>
                                        </td>
                                        <td><?= number_format($r['zscore_bb_u'], 2) ?></td>
                                        
                                        <!-- TB/U -->
                                        <td>
                                            <?php 
                                            $tbu = 'Normal';
                                            if($r['zscore_tb_u'] < -3) $tbu = 'Sangat Pendek';
                                            elseif($r['zscore_tb_u'] < -2) $tbu = 'Pendek (Stunting)';
                                            elseif($r['zscore_tb_u'] > 3) $tbu = 'Tinggi';
                                            ?>
                                            <?= $tbu ?>
                                        </td>
                                        <td><?= number_format($r['zscore_tb_u'], 2) ?></td>
                                        
                                        <!-- BB/TB -->
                                        <td>
                                            <?php 
                                            $bbtb = 'Gizi Baik';
                                            if($r['zscore_bb_tb'] < -3) $bbtb = 'Gizi Buruk';
                                            elseif($r['zscore_bb_tb'] < -2) $bbtb = 'Gizi Kurang';
                                            elseif($r['zscore_bb_tb'] > 3) $bbtb = 'Obesitas';
                                            elseif($r['zscore_bb_tb'] > 2) $bbtb = 'Gizi Lebih';
                                            elseif($r['zscore_bb_tb'] > 1) $bbtb = 'Risiko Lebih';
                                            ?>
                                            <?= $bbtb ?>
                                        </td>
                                        <td><?= number_format($r['zscore_bb_tb'], 2) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection() ?>
