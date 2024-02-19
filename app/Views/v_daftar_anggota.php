<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="<?= base_url('Auth') ?>" class="h2"><?= $judul ?></a>
        </div>
        <div class="card-body">
            <?php
            //notifikasi validasi
            $errors = session()->getFlashdata('errors');
            if (!empty($errors)) { ?>
                <div class="alert alert-danger" role="alert">
                    <h4>Periksa Entry Form</h4>
                    <ul>
                        <?php foreach ($errors as $key => $error) { ?>
                            <li><?= esc($error) ?></li>
                        <?php }  ?>
                    </ul>
                </div>
            <?php } ?>

            <?php
            if (session()->getFlashdata('pesan')) {
                echo '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i>';
                echo session()->getFlashdata('pesan');
                echo '</h5></div>';
            }
            ?>

            <?php echo form_open('Auth/Daftar') ?>

            <div class="form-group">
                <select name="id_kelas" class="form-control">
                    <option value="">-Pilih Kelas-</option>
                    <?php foreach ($kelas as $key => $value) { ?>
                        <option value="<?= $value['id_kelas'] ?>"><?= $value['nama_kelas'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <input class="form-control" name="nis" value="<?= old('nis') ?>" placeholder="NIS">
            </div>

            <div class="form-group">
                <input class="form-control" name="nama_siswa" value="<?= old('nama_siswa') ?>" placeholder="Nama Siswa">
            </div>

            <div class="form-group">
                <select name="jenis_kelamin" class="form-control">
                    <option value="">-Pilih Jenis Kelamin-</option>
                    <option value="Laki-Laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <input class="form-control" name="no_hp" value="<?= old('no_hp') ?>" placeholder="No Handphone">
            </div>

            <div class="form-group">
                <input type="password" class="form-control" value="<?= old('password') ?>" name="password" placeholder="Password">
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name="ulangi_password" value="<?= old('ulangi_password') ?>" placeholder="Ulangi Password">
            </div>



            <div class="row">
                <div class="col-sm-6">
                    <a class="btn btn-success btn-block" href="<?= base_url('Auth') ?>">Kembali</a>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                </div>
                <!-- /.col -->
            </div>
            <?php echo form_close() ?>

            <div class="social-auth-links text-center mb-3">
                <p>- OR -</p>
                <a href="<?= base_url('Auth/LoginAnggota') ?>" class="btn btn-block btn-warning">
                    <i class="fas fa-sign-in-alt"></i> Kembali Login
                </a>
            </div>

        </div>
        <!-- /.card-body -->
    </div>

</div>