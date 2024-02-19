<div class="col-md-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <h3 class="card-title">Data <?= $judul ?></h3>
        </div>

        <div class="card-body">
            <?php
            //notifikasi
            $errors = session()->getFlashdata('errors');
            if (!empty($errors)) { ?>
                <div class="alert alert-danger" role="alert">
                    <h4>Periksa Entry Form</h4>
                    <ul>
                        <?php foreach ($errors as $key => $error) { ?>
                            <li><?= esc($error) ?></li>
                        <?php } ?>
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

            <table class="table table-bordered">
                <tr class="text-center">
                    <th>NO</th>
                    <th>No Pinjam</th>
                    <th>Cover</th>
                    <th>Data Buku</th>
                    <th>Peminjaman</th>
                    <th>Status</th>
                </tr>
                <?php $no = 1;
                foreach ($pengajuanditerima as $key => $value) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td class="text-center"><?= $value['no_pinjam'] ?></td>
                        <td class="text-center">
                            <img src="<?= base_url('cover/' . $value['cover']) ?>" width="125px" height="150px">
                            <p><?= $value['kode_buku'] ?></p>
                        </td>
                        <td>
                            <p>
                            <h5 class="text-primary"><?= $value['judul_buku'] ?></h5>
                            </p>
                            <p><b>Kategori : </b> <?= $value['nama_kategori'] ?> <br>
                                <b>Penulis : </b> <?= $value['nama_penulis'] ?><br>
                                <b>Penerbit :</b> <?= $value['nama_penerbit'] ?><br>
                                <b>Lokasi : </b> <?= $value['nama_rak'] ?> Lantai <?= $value['lantai_rak'] ?><br>
                                <b>Halaman :</b> <?= $value['halaman'] ?><br>
                                <b>Bahasa :</b> <?= $value['bahasa'] ?><br>
                                <b>ISBN :</b> <?= $value['isbn'] ?><br>
                                <b>Tahun :</b> <?= $value['tahun'] ?><br>
                            </p>
                        </td>
                        <td>
                            <b>Tanggal Pengajuan :</b> <?= $value['tgl_pengajuan'] ?><br>
                            <b>Tanggal Pinjam :</b> <?= $value['tgl_pinjam'] ?><br>
                            <b>Lama Pinjam :</b> <?= $value['lama_pinjam'] ?><br>
                            <b>Tanggal Harus Kembali :</b> <?= $value['tgl_harus_kembali'] ?><br>
                        </td>
                        <td class="text-center">
                            <span class="right badge badge-success"><?= $value['status_pinjam'] ?></span>
                        </td>

                    </tr>
                <?php } ?>
            </table>

        </div>
    </div>
</div>