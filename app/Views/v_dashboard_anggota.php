<div class="col-sm-12">
    <?php
    if ($anggota['verifikasi'] == 1) { ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-check"></i> Akun Anda Sudah Terverifikasi !</h5>
    </div>
<?php } else { ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-times"></i> Akun Anda Belum Terverifikasi!</h5>
        Silahkan Menghubungi Petugas Perpustakaan Untuk Verifikasi Data !
    </div>
<?php } ?>

</div>

<div class="col-md-3">
    <!-- Profile Image -->
    <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            <div class="text-center">
                <img class="img-fluid" src="<?= base_url('foto/' . $anggota['foto']) ?>" width="250px">
            </div>
        </div>
    </div>
</div>

<div class="col-md-9">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Data <?= $judul ?></h3>
            <div class="card-tools">
                <button type="button" class="btn btn-primary btn-flat btn-sm" data-toggle="modal" data-target="#modal-sm">
                    <i class="fas fa-edit"></i> Edit Profile
                </button>
            </div>
        </div>
        <div class="card-body">

            <table class="table">
                <tr>
                    <th width="150px">NIS</th>
                    <th width="50px">:</th>
                    <td><?= $anggota['nis'] ?></td>
                </tr>
                <tr>
                    <th>Nama Siswa</th>
                    <th>:</th>
                    <td><?= $anggota['nama_siswa'] ?></td>
                </tr>
                <tr>
                    <th>Jenis Kelamin</th>
                    <th>:</th>
                    <td><?= $anggota['jenis_kelamin'] ?></td>
                </tr>
                <tr>
                    <th>Kelas</th>
                    <th>:</th>
                    <td><?= $anggota['nama_kelas'] ?></td>
                </tr>
                <tr>
                    <th>No Handphone</th>
                    <th>:</th>
                    <td><?= $anggota['no_hp'] ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>