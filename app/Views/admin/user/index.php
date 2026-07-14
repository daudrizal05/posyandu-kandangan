<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Manajemen User</h3>
            <div class="card-tools">
                <a href="<?= site_url('admin/user/create') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah User
                </a>
            </div>
        </div>
        <div class="card-body">

            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Posyandu</th>
                            <th>Status</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data user.</td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1 + (10 * ($pager->getCurrentPage('users') - 1)); ?>
                            <?php foreach ($users as $u): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($u['name']) ?><br><small><?= esc($u['email']) ?></small></td>
                                    <td><?= esc($u['username']) ?></td>
                                    <td>
                                        <?php if ($u['role'] == 'admin'): ?>
                                            <span class="badge badge-danger">Admin</span>
                                        <?php elseif ($u['role'] == 'bidan'): ?>
                                            <span class="badge badge-info">Bidan</span>
                                        <?php else: ?>
                                            <span class="badge badge-primary">Kader</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($u['nama_posyandu'] ?? '-') ?></td>
                                    <td>
                                        <?php if ($u['is_active']): ?>
                                            <span class="badge badge-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= site_url('admin/user/edit/' . $u['id']) ?>" class="btn btn-sm btn-warning"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-info" title="Reset Password"
                                            data-toggle="modal" data-target="#resetModal"
                                            onclick="setResetTarget(<?= $u['id'] ?>, '<?= esc($u['name']) ?>')">
                                            <i class="fas fa-key"></i>
                                        </button>
                                        <?php if ($u['id'] != session()->get('id')): ?>
                                            <form action="<?= site_url('admin/user/delete/' . $u['id']) ?>" method="post"
                                                class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <?= $pager->links('users', 'default_full') ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reset Password -->
<div class="modal fade" id="resetModal" tabindex="-1" role="dialog" aria-labelledby="resetModalLabel">
    <div class="modal-dialog" role="document">
        <form id="resetForm" method="post" action="">
            <?= csrf_field() ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resetModalLabel"><i class="fas fa-key"></i> Reset Password User</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Reset password untuk: <strong id="resetUserName"></strong></p>
                    <div class="form-group">
                        <label>Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="new_password" class="form-control" required minlength="6"
                            placeholder="Min. 6 karakter">
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" name="confirm_password" class="form-control" required
                            placeholder="Ulangi password baru">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Reset Password</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
    function setResetTarget(userId, userName) {
        document.getElementById('resetUserName').textContent = userName;
        document.getElementById('resetForm').action = '<?= site_url('admin/user/reset_password/') ?>' + userId;
    }
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>