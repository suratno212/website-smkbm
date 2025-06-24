<?= $this->extend('layout/public') ?>
<?= $this->section('content') ?>
<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<!-- SPMB Index: tampilkan info pendaftaran SPMB, form, dsb, sesuai kebutuhan. -->
<?= $this->endSection() ?> 