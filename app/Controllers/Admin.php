<?php

namespace App\Controllers;

use App\Models\ModelAdmin;
use App\Models\ModelPeminjaman;

/**
 * @property ModelAdmin $ModelAdmin
 * @property ModelPeminjaman $ModelPeminjaman
 */

class Admin extends BaseController
{

    public function __construct()
    {
        helper('form');
        $this->ModelAdmin = new ModelAdmin;
        $this->ModelPeminjaman = new ModelPeminjaman;
    }

    public function index()
    {
        $data = [
            'menu' => 'dashboard',
            'submenu' => '',
            'judul' => 'Dashboard',
            'page' => 'v_admin',
            'total_anggota' => $this->ModelAdmin->TotalAnggota(),
        ];
        return view('v_template_admin', $data);
    }

    public function PengajuanMasuk()
    {
        $data = [
            'menu' => 'peminjaman',
            'submenu' => 'pengajuanmasuk',
            'judul' => 'Pengajuan Masuk',
            'page' => 'peminjaman/v_pengajuan_masuk',
            'pengajuanmasuk' => $this->ModelPeminjaman->PengajuanMasuk(),
        ];
        return view('v_template_admin', $data);
    }

    public function TolakBuku($id_pinjam)
    {
        $data = [
            'id_pinjam' => $id_pinjam,
            'status_pinjam' => 'Ditolak',
            'ket' => $this->request->getPost('ket'),
        ];
        $this->ModelPeminjaman->EditData($data);
        session()->setFlashdata('ditolak', 'Buku Berhasil Ditolak');
        return redirect()->to(base_url('Admin/PengajuanMasuk'));
    }

    public function TerimaBuku($id_pinjam)
    {
        $data = [
            'id_pinjam' => $id_pinjam,
            'status_pinjam' => 'Diterima',
        ];
        $this->ModelPeminjaman->EditData($data);
        session()->setFlashdata('diterima', 'Pengajuan Peminjaman Buku Diterima !');
        return redirect()->to(base_url('Admin/PengajuanMasuk'));
    }

    public function PengajuanDiterima()
    {
        $data = [
            'menu' => 'peminjaman',
            'submenu' => 'pengajuanditerima',
            'judul' => 'Pengajuan Diterima',
            'page' => 'peminjaman/v_pengajuan_diterima',
            'pengajuanditerima' => $this->ModelPeminjaman->PengajuanDiterima(),
        ];
        return view('v_template_admin', $data);
    }

    public function PengajuanDitolak()
    {
        $data = [
            'menu' => 'peminjaman',
            'submenu' => 'pengajuanditolak',
            'judul' => 'Pengajuan Ditolak',
            'page' => 'peminjaman/v_pengajuan_ditolak',
            'pengajuanditolak' => $this->ModelPeminjaman->PengajuanDitolak(),
        ];
        return view('v_template_admin', $data);
    }
}