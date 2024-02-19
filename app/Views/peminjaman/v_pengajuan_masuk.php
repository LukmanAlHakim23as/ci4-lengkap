<div class="col-md-12">
<?php
if (session()->getFlashdata('ditolak')) {
    echo '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-times"></i>';
    echo session()->getFlashdata('ditolak');
    echo '</h5></div>';
}
?>

<?php
if (session()->getFlashdata('diterima')) {
    echo '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i>';
    echo session()->getFlashdata('diterima');
    echo '</h5></div>';
}
?>
</div>

<?php
$db = \Config\Database::connect();

foreach ($pengajuanmasuk as $key => $value) {
    $buku = $db->table('tbl_peminjaman')
        ->join('tbl_buku', 'tbl_buku.id_buku = tbl_peminjaman.id_buku', 'left')
        ->where('id_anggota', $value['id_anggota'])
        ->where('status_pinjam', 'Diajukan')
        ->get()->getResultArray();
?>

    <div class="col-md-12">

        <!-- Widget: user widget style 2 -->
        <div class="card card-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-warning">
                <div class="widget-user-image">
                    <img class="img-circle elevation-2" src="<?= base_url('foto/' . $value['foto']) ?>">
                </div>
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username"><?= $value['nama_siswa'] ?> (<?= $value['qty'] ?> Buku)</h3>
                <h5 class="widget-user-desc"><?= $value['nama_kelas'] ?></h5>
            </div>
            <div class="card-footeer p-0">
                <table class="table table-hover">
                    <tr class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Cover</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Lama Pinjam</th>
                        <th>Tanggal Tempo</th>
                    </tr>
                    <?php $no = 1;
                    foreach ($buku as $key  => $data) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="text-center"><?= $data['tgl_pengajuan'] ?></td>
                            <td class="text-center">
                                <img src="<?= base_url('cover/' . $data['cover']) ?>" width="50px" height="60px">
                            </td>
                            <td><?= $data['judul_buku'] ?></td>
                            <td class="text-center"><?= $data['tgl_pinjam'] ?></td>
                            <td class="text-center"><?= $data['lama_pinjam'] ?></td>
                            <td class="text-center"><?= $data['tgl_harus_kembali'] ?></td>
                            <td class="text-center">
                                <button href="" class="btn btn-danger btn-xs btn-flat" data-toggle="modal" data-target="#ditolak<?= $data['id_pinjam'] ?>"><i class="fas fa-times"></i>Tolak</button>
                                <a href="<?= base_url('Admin/TerimaBuku/' . $data['id_pinjam']) ?>" class="btn btn-success btn-xs btn-flat"><i class="fas fa-check"></i>Terima</a>
                            </td>
                        </tr>

                        <!-- Modal Ditolak -->
                        <div class="modal fade" id="ditolak<?= $data['id_pinjam'] ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Tolak Buku <?= $data['judul_buku'] ?></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo form_open(base_url('Admin/TolakBuku/' . $data['id_pinjam'])) ?>
                                        <div class="form-group">
                                            <label>Keterangan</label>
                                            <textarea name="ket" rows="5" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-warning btn-flat">Tolak</button>
                                    </div>
                                    <?php echo form_close() ?>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>

<?php } ?>