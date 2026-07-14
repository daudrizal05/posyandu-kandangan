<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tambah Data Lansia</h3>
                </div>

                <?php if (session()->has('errors')): ?>
                    <div class="alert alert-danger mx-3 mt-3">
                        <ul class="mb-0">
                            <?php foreach (session('errors') as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= site_url('admin/ibu_hamil/store') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="posyandu_id">Posyandu <span class="text-danger">*</span></label>
                            <select class="form-control" id="posyandu_id" name="posyandu_id" required>
                                <option value="">Pilih Posyandu</option>
                                <?php foreach ($posyandu as $p): ?>
                                    <option value="<?= $p['id'] ?>" <?= old('posyandu_id') == $p['id'] ? 'selected' : '' ?>><?= esc($p['nama_posyandu']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik">NIK <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nik" name="nik" value="<?= old('nik') ?>" required maxlength="16" placeholder="16 digit NIK">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">Nama <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama') ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2" required><?= old('alamat') ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= old('tanggal_lahir') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="umur">Umur <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="umur" name="umur" value="<?= old('umur') ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="lingkar_lengan_atas">Lingkar Lengan Atas (cm) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" id="lingkar_lengan_atas" name="lingkar_lengan_atas" value="<?= old('lingkar_lengan_atas') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bb">Berat Badan (kg) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" id="bb" name="bb" value="<?= old('bb') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tb">Tinggi Badan (cm) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" id="tb" name="tb" value="<?= old('tb') ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lingkar_pinggang">Lingkar Pinggang (cm) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" id="lingkar_pinggang" name="lingkar_pinggang" value="<?= old('lingkar_pinggang') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="imt">Indeks Massa Tubuh <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" id="imt" name="imt" value="<?= old('imt') ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_bpjs">No BPJS <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="no_bpjs" name="no_bpjs" value="<?= old('no_bpjs') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tensi">Tensi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="tensi" name="tensi" value="<?= old('tensi') ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="keluhan">Keluhan <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="keluhan" name="keluhan" rows="2" required><?= old('keluhan') ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="obat">Obat <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="obat" name="obat" rows="2" required><?= old('obat') ?></textarea>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?= site_url('admin/ibu_hamil') ?>" class="btn btn-default float-right">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
