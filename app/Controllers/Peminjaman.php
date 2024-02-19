<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ModelAnggota;
use App\Models\ModelPeminjaman;
use App\Models\ModelBuku;
use CodeIgniter\I18n\Time;

/**
 * @property ModelAnggota $ModelAnggota
 * @property ModelBuku $ModelBuku
 * @property ModelPeminjaman $ModelPeminjaman
 */
class Peminjaman extends BaseController
{

    public function __construct()
    {
        helper('form');
        $this->ModelAnggota = new ModelAnggota;
        $this->ModelBuku = new ModelBuku;
        $this->ModelPeminjaman = new ModelPeminjaman;
    }

    public function index()
    {
        //
    }

    public function Pengajuan()
    {
        $id_anggota = session()->get('id_anggota');
        $data = [
            'menu' => 'peminjaman',
            'submenu' => 'pengajuan',
            'judul' => 'Pengajuan Peminjaman Buku',
            'page' => 'peminjaman/v_pengajuan',
            'anggota' => $this->ModelAnggota->profileAnggota($id_anggota),
            'buku' => $this->ModelBuku->AllData(),
            'pengajuanbuku' => $this->ModelPeminjaman->PengajuanBuku($id_anggota),
        ];
        return view('v_template_anggota', $data);

    }

    public function AddPengajuan()
    {
        if ($this->validate([
            'id_buku' => [
                'label' => 'Judul Buku ',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Dipilih !',
                ]
            ],
        ])) {
            //mencari tanggal harus kembali
            $time = Time::parse($this->request->getPost('tgl_pinjam'));
            $thn_pjm = $time->getYear();   
            $bln_pjm  = $time->getMonth();  
            $tgl_pjm =  $time->getDay(); 
            $lama_pinjam = $this->request->getPost('lama_pinjam');
            $tgl_harus_kembali = date("Y-m-d",mktime(0,0,0, $bln_pjm, $tgl_pjm + $lama_pinjam, $thn_pjm));

            
            $data = [
                'no_pinjam' => $this->request->getPost('no_pinjam'),
                'tgl_pengajuan' =>date('Y-m-d'),
                'id_anggota' => session()->get('id_anggota'),
                'tgl_pinjam' => $this->request->getPost('tgl_pinjam'),
                'id_buku'  =>  $this->request->getPost('id_buku'),
                'qty' => '1',
                'lama_pinjam' =>  $this->request->getPost('lama_pinjam'),
                'tgl_harus_kembali' => $tgl_harus_kembali,
                'status_pinjam' => 'Diajukan',
            ];
            $this->ModelPeminjaman->AddData($data);
            session()->setFlashdata('pesan', 'buku Berhasil Diajukan !');
            return redirect()->to(base_url('Peminjaman/Pengajuan'));
        }else {
            //jika tidak lolos validasi
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('Peminjaman/Pengajuan'));
        }
    }
    public function DeleteData($id_pinjam)
    {
        $data = ['id_pinjam' => $id_pinjam];
        $this->ModelPeminjaman->DeleteData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus !');
        return redirect()->to(base_url('Peminjaman/Pengajuan'));
    }

    public function PengajuanDiterima()
    {
        $id_anggota = session()->get('id_anggota');
        $data = [
            'menu' => 'peminjaman',
            'submenu' => 'diterima',
            'judul' => 'Pengajuan Peminjaman Buku Diterima',
            'page' => 'peminjaman/v_diterima',
            'anggota' => $this->ModelAnggota->profileAnggota($id_anggota),
            'buku' => $this->ModelBuku->AllData(),
            'pengajuanditerima' => $this->ModelPeminjaman->PengajuanBukuDiterima($id_anggota),
        ];
        return view('v_template_anggota', $data);
    }

    public function PengajuanDitolak()
    {
        $id_anggota = session()->get('id_anggota');
        $data = [
            'menu' => 'peminjaman',
            'submenu' => 'ditolak',
            'judul' => 'Pengajuan Peminjaman Buku Ditolak',
            'page' => 'peminjaman/v_ditolak',
            'anggota' => $this->ModelAnggota->profileAnggota($id_anggota),
            'buku' => $this->ModelBuku->AllData(),
            'pengajuanditolak' => $this->ModelPeminjaman->PengajuanBukuDitolak($id_anggota),
        ];
        return view('v_template_anggota', $data);
    }
}