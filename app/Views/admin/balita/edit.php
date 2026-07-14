<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Edit Data Balita</h3>
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

                <form action="<?= site_url('admin/balita/update/'.$balita['id']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="posyandu_id">Posyandu <span class="text-danger">*</span></label>
                            <select class="form-control" id="posyandu_id" name="posyandu_id" required>
                                <option value="">Pilih Posyandu</option>
                                <?php foreach($posyandu as $p): ?>
                                    <option value="<?= $p['id'] ?>" <?= old('posyandu_id', $balita['posyandu_id']) == $p['id'] ? 'selected' : '' ?>><?= esc($p['nama_posyandu']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik">NIK Balita <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nik" name="nik" value="<?= old('nik', $balita['nik']) ?>" required maxlength="16">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_balita">Nama Balita <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_balita" name="nama_balita" value="<?= old('nama_balita', $balita['nama_balita']) ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="L" <?= old('jenis_kelamin', $balita['jenis_kelamin']) == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                        <option value="P" <?= old('jenis_kelamin', $balita['jenis_kelamin']) == 'P' ? 'selected' : '' ?>>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?= old('tempat_lahir', $balita['tempat_lahir']) ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= old('tanggal_lahir', $balita['tanggal_lahir']) ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_ayah">Nama Ayah</label>
                                    <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" value="<?= old('nama_ayah', $balita['nama_ayah']) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_ibu">Nama Ibu</label>
                                    <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" value="<?= old('nama_ibu', $balita['nama_ibu']) ?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2"><?= old('alamat', $balita['alamat']) ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="berat_lahir">Berat Lahir (kg)</label>
                                    <input type="number" step="0.01" class="form-control" id="berat_lahir" name="berat_lahir" value="<?= old('berat_lahir', $balita['berat_lahir']) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tinggi_lahir">Tinggi Lahir (cm)</label>
                                    <input type="number" step="0.01" class="form-control" id="tinggi_lahir" name="tinggi_lahir" value="<?= old('tinggi_lahir', $balita['tinggi_lahir']) ?>">
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h5 class="mb-3 text-warning">Data Pengukuran / Gizi</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="berat">Berat Saat Ini (kg)</label>
                                    <input type="number" step="0.01" class="form-control" id="berat" name="berat" value="<?= old('berat', $balita['berat']) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tinggi">Tinggi Saat Ini (cm)</label>
                                    <input type="number" step="0.01" class="form-control" id="tinggi" name="tinggi" value="<?= old('tinggi', $balita['tinggi']) ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="bb_u">BB/U</label>
                                    <input type="text" class="form-control" id="bb_u" name="bb_u" value="<?= old('bb_u', $balita['bb_u']) ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="zs_bb_u">ZS BB/U</label>
                                    <input type="number" step="0.01" class="form-control" id="zs_bb_u" name="zs_bb_u" value="<?= old('zs_bb_u', $balita['zs_bb_u']) ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tb_u">TB/U</label>
                                    <input type="text" class="form-control" id="tb_u" name="tb_u" value="<?= old('tb_u', $balita['tb_u']) ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="zs_tb_u">ZS TB/U</label>
                                    <input type="number" step="0.01" class="form-control" id="zs_tb_u" name="zs_tb_u" value="<?= old('zs_tb_u', $balita['zs_tb_u']) ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bb_tb">BB/TB</label>
                                    <input type="text" class="form-control" id="bb_tb" name="bb_tb" value="<?= old('bb_tb', $balita['bb_tb']) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="zs_bb_tb">ZS BB/TB</label>
                                    <input type="number" step="0.01" class="form-control" id="zs_bb_tb" name="zs_bb_tb" value="<?= old('zs_bb_tb', $balita['zs_bb_tb']) ?>">
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="aktif" <?= old('status', $balita['status']) == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                <option value="pindah" <?= old('status', $balita['status']) == 'pindah' ? 'selected' : '' ?>>Pindah</option>
                                <option value="meninggal" <?= old('status', $balita['status']) == 'meninggal' ? 'selected' : '' ?>>Meninggal</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">Update</button>
                        <a href="<?= site_url('admin/balita') ?>" class="btn btn-default float-right">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
