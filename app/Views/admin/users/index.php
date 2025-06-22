<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manajemen User</h1>
                </div>
                <div class="col-sm-6">
                    <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary float-right">
                        <i class="fas fa-plus"></i> Tambah User
                    </a>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <?php if (session()->getFlashdata('message')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('message') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-2">
                                <button type="button" class="btn btn-secondary btn-sm" id="btn-multi-select"><i class="fas fa-check-square"></i> Pilih Beberapa Data</button>
                                <button type="submit" class="btn btn-danger btn-sm d-none" id="btn-mass-delete" form="massDeleteForm" onclick="return confirm('Hapus semua user terpilih?')"><i class="fas fa-trash"></i> Hapus Terpilih</button>
                            </div>
                            <form id="massDeleteForm" action="<?= base_url('admin/users/mass_delete') ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="col-checkbox d-none"><input type="checkbox" id="select-all"></th>
                                                <th>No</th>
                                                <th>Foto</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($users as $user) : ?>
                                                <tr>
                                                    <td class="col-checkbox d-none"><input type="checkbox" name="user_ids[]" value="<?= $user['id'] ?>"></td>
                                                    <td><?= $i++ ?></td>
                                                    <td>
                                                        <?php if (isset($user['foto']) && $user['foto']) : ?>
                                                            <img src="<?= base_url('uploads/profile/' . $user['foto']) ?>" alt="Profile" class="img-thumbnail" style="width: 50px;">
                                                        <?php else : ?>
                                                            <img src="<?= base_url('assets/images/Logo.png') ?>" alt="Profile" class="img-thumbnail" style="width: 50px;">
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= isset($user['username']) ? $user['username'] : '-' ?></td>
                                                    <td><?= isset($user['email']) ? $user['email'] : '-' ?></td>
                                                    <td>
                                                        <?php
                                                        $badgeClass = '';
                                                        $role = isset($user['role']) ? $user['role'] : '';
                                                        switch ($role) {
                                                            case 'admin':
                                                                $badgeClass = 'bg-danger text-white';
                                                                break;
                                                            case 'guru':
                                                                $badgeClass = 'bg-success text-white';
                                                                break;
                                                            case 'siswa':
                                                                $badgeClass = 'bg-info text-white';
                                                                break;
                                                            default:
                                                                $badgeClass = 'bg-secondary text-white';
                                                        }
                                                        ?>
                                                        <span class="badge <?= $badgeClass ?>"><?= ucfirst($role) ?></span>
                                                    </td>
                                                    <td>
                                                        <a href="<?= base_url('admin/users/edit/' . $user['id']) ?>" class="btn btn-warning btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="<?= base_url('admin/users/delete/' . $user['id']) ?>" method="post" style="display:inline;">
                                                            <?= csrf_field() ?>
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    document.getElementById('btn-multi-select').onclick = function() {
        var checkCols = document.querySelectorAll('.col-checkbox');
        var btnMassDelete = document.getElementById('btn-mass-delete');
        for (var col of checkCols) col.classList.toggle('d-none');
        btnMassDelete.classList.toggle('d-none');
    };
    document.getElementById('select-all').onclick = function() {
        var checkboxes = document.querySelectorAll('input[name="user_ids[]"]');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    };
</script>
<?= $this->endSection() ?> 