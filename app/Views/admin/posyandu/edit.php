<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Edit Posyandu</h3>
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

                <form action="<?= site_url('admin/posyandu/update/'.$posyandu['id']) ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_posyandu">Nama Posyandu <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_posyandu" name="nama_posyandu" value="<?= old('nama_posyandu', $posyandu['nama_posyandu']) ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="alamat">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= old('alamat', $posyandu['alamat']) ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="desa_kelurahan">Desa / Kelurahan</label>
                                    <input type="text" class="form-control" id="desa_kelurahan" name="desa_kelurahan" value="<?= old('desa_kelurahan', $posyandu['desa_kelurahan']) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kecamatan">Kecamatan</label>
                                    <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="<?= old('kecamatan', $posyandu['kecamatan']) ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_ketua_kader">Nama Ketua Kader</label>
                                    <input type="text" class="form-control" id="nama_ketua_kader" name="nama_ketua_kader" value="<?= old('nama_ketua_kader', $posyandu['nama_ketua_kader']) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kontak">Kontak / No. HP</label>
                                    <input type="text" class="form-control" id="kontak" name="kontak" value="<?= old('kontak', $posyandu['kontak']) ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="latitude">Latitude (Opsional)</label>
                                    <input type="text" class="form-control" id="latitude" name="latitude" value="<?= old('latitude', $posyandu['latitude']) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="longitude">Longitude (Opsional)</label>
                                    <input type="text" class="form-control" id="longitude" name="longitude" value="<?= old('longitude', $posyandu['longitude']) ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="foto">Foto Posyandu (Opsional)</label>
                            <?php if($posyandu['foto']): ?>
                                <div class="mb-2">
                                    <img src="<?= base_url('uploads/posyandu/'.$posyandu['foto']) ?>" alt="Foto Posyandu" class="img-thumbnail" width="200">
                                </div>
                            <?php endif; ?>
                            <input type="file" class="form-control-file" id="foto" name="foto" accept="image/png, image/jpeg, image/jpg">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto. Maksimal 2MB, format JPG/PNG.</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="aktif" <?= old('status', $posyandu['status']) == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                <option value="nonaktif" <?= old('status', $posyandu['status']) == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">Update</button>
                        <a href="<?= site_url('admin/posyandu') ?>" class="btn btn-default float-right">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
