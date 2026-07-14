<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Edit User</h3>
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

                <form action="<?= site_url('admin/user/update/'.$user['id']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= old('name', $user['name']) ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= old('username', $user['username']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $user['email']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password Baru (Opsional)</label>
                            <input type="password" class="form-control" id="password" name="password" minlength="6">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password.</small>
                        </div>

                        <div class="form-group">
                            <label for="role">Role <span class="text-danger">*</span></label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="kader" <?= old('role', $user['role']) == 'kader' ? 'selected' : '' ?>>Kader</option>
                                <option value="bidan" <?= old('role', $user['role']) == 'bidan' ? 'selected' : '' ?>>Bidan</option>
                                <option value="admin" <?= old('role', $user['role']) == 'admin' ? 'selected' : '' ?>>Admin</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="posyandu_id">Pilih Posyandu (Opsional)</label>
                            <select class="form-control" id="posyandu_id" name="posyandu_id">
                                <option value="">Tidak ada / Semua Posyandu</option>
                                <?php foreach($posyandu as $p): ?>
                                    <option value="<?= $p['id'] ?>" <?= old('posyandu_id', $user['posyandu_id']) == $p['id'] ? 'selected' : '' ?>><?= esc($p['nama_posyandu']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Pilih posyandu jika role adalah Kader.</small>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" <?= $user['is_active'] ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="is_active">User Aktif</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">Update</button>
                        <a href="<?= site_url('admin/user') ?>" class="btn btn-default float-right">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
