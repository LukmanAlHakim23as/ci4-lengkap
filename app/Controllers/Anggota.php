<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelAnggota;
use App\Models\ModelKelas;

/**
 * @property ModelAnggota $ModelAnggota
 * @property ModelKelas $ModelKelas
 */

class Anggota extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelAnggota = new ModelAnggota;
        $this->ModelKelas = new ModelKelas;

    }

    public function index()
    {
        $data = [
            'menu' => 'masteranggota',
            'submenu' => 'anggota',
            'judul' => 'Anggota',
            'page' => 'anggota/v_index',
            'anggota' =>$this->ModelAnggota->AllData(),
        ];
        return view('v_template_admin',$data);
    }

    public function Verifikasi($id_anggota)
    {
        $data = [
            'id_anggota' => $id_anggota,
            'verifikasi'=> '1',
        ];
        $this->ModelAnggota->EditData($data);
        session()->setFlashdata('pesan', 'Anggota Berhasil Di Verifikasi');
        return redirect()->to(base_url('Anggota'));
    }

    public function AddData()
    {
        $data = [
            'menu' => 'masteranggota',
            'submenu' => 'anggota',
            'judul' => 'Tambah Data Anggota',
            'page' => 'anggota/v_adddata',
            'kelas' => $this->ModelKelas->AllData()

        ];
        return view('v_template_admin', $data);
    }

    public function SimpanData()
    {
        if ($this->validate([
            'id_kelas' => [
                'label' => 'Kelas',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Belum Dipilih !',
                ]
            ],
            'nis' => [
                'label' => 'Nis',
                'rules' => 'required|is_unique[tbl_anggota.nis]',
                'errors' => [
                    'required' => '{field} Masih Kosong !',
                    'is_unique' => '{field} Sudah Terdaftar !',
                ]
                ], 
                'nama_siswa' => [
                    'label' => 'Nama Siswa',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Masih Kosong !',
                    ]
                ],
                'jenis_kelamin' => [
                    'label' => 'Jenis Kelamin',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Masih Kosong !',
                    ]
                ],
                'no_hp' => [
                    'label' => 'No Handphone',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Masih Kosong !',
                    ]
                ],
                'password' => [
                    'label' => 'Email',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Masih Kosong !',
                    ]
                ],
                'alamat' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Masih Kosong !',
                    ]
                ],
                'foto' => [
                    'label' => 'Foto Anggota',
                    'rules' => 'uploaded[foto]|max_size[foto,1024]|mime_in[foto,image/jpg,image/jpeg]',
                    'errors' => [
                        'uploaded' => '{field} Wajib Diisi !',
                        'max_size' => '{field} Max 1024 Kb !',
                        'mime_in' => 'Format {field} Harus JPG atau JPEG !',
                    ]
                ],
                    
                ])) {
                    //jika lolos validasi
                    $foto = $this->request->getFile('foto');
                    $nama_file = $foto->getRandomName();
                    $data = [
                        'id_kelas' => $this->request->getPost('id_kelas'),
                        'nis' => $this->request->getPost('nis'),
                        'nama_siswa' => $this->request->getPost('nama_siswa'),
                        'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                        'no_hp' => $this->request->getPost('no_hp'),
                        'password' => $this->request->getPost('password'),
                        'alamat' => $this->request->getPost('alamat'),
                        'verifikasi' => '1',
                        'foto' => $nama_file,
                    ];
                    //memindahkan/upload file foto ke dalam folder foto
                    $foto->move('foto', $nama_file);
                    $this->ModelAnggota->AddData($data);
                    session()->setFlashdata('pesan', 'Data Anggota Berhasil Disimpan !');
                    return redirect()->to(base_url('Anggota/AddData'));
                }else {
                    //jika tidak lolos validasi
                    session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
                    return redirect()->to(base_url('Anggota/AddData'))->withInput('validation', \Config\Services::validation());
                }
            }

    public function EditData($id_anggota)
    {
        $data = [
            'menu' => 'masteranggota',
            'submenu' => 'anggota',
            'judul' => 'Edit Data Anggota',
            'page' => 'anggota/v_editdata',
            'kelas' => $this->ModelKelas->AllData(),
            'anggota' => $this->ModelAnggota->DetailData($id_anggota),
        ];
        return view('v_template_admin', $data);
    } 
    
    public function UpdateData($id_anggota)
    {
        if ($this->validate([
            'id_kelas' => [
                'label' => 'Kelas',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Belum Dipilih !',
                ]
            ],
            'nis' => [
                'label' => 'Nis',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Masih Kosong !',
                    'is_unique' => '{field} Sudah Terdaftar !',
                ]
                ], 
                'nama_siswa' => [
                    'label' => 'Nama Siswa',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Masih Kosong !',
                    ]
                ],
                'jenis_kelamin' => [
                    'label' => 'Jenis Kelamin',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Masih Kosong !',
                    ]
                ],
                'no_hp' => [
                    'label' => 'No Handphone',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Masih Kosong !',
                    ]
                ],
                'password' => [
                    'label' => 'Email',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Masih Kosong !',
                    ]
                ],
                'alamat' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Masih Kosong !',
                    ]
                ],
                'foto' => [
                    'label' => 'Foto Anggota',
                    'rules' =>  'max_size[foto,1024]|mime_in[foto,image/jpg,image/jpeg]',
                    'errors' => [
                        'max_size' => '{field} Max 1024 Kb !',
                        'mime_in' => 'Format {field} Harus JPG atau JPEG !',
                    ]
                ],
                    
                ])) {
                    //jika lolos validasi
                    $foto = $this->request->getFile('foto');
                    if ($foto->getError() == 4) {
                            //jika tidak ganti gambar
                            $data = [
                                'id_anggota' => $id_anggota,
                                'id_kelas' => $this->request->getPost('id_kelas'),
                                'nis' => $this->request->getPost('nis'),
                                'nama_siswa' => $this->request->getPost('nama_siswa'),
                                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                                'no_hp' => $this->request->getPost('no_hp'),
                                'password' => $this->request->getPost('password'),
                                'alamat' => $this->request->getPost('alamat'),
                                'verifikasi' => '1',
                            ];
                            //memindahkan/upload file foto ke dalam folder foto
                            $this->ModelAnggota->EditData($data);
                        }else { 
                            //hapus foto lama
                            $anggota = $this->ModelAnggota->DetailData($id_anggota);
                            if ($anggota['foto'] <> '') {
                                unlink('foto/' . $anggota['foto']);
                            }
                        //jika tidak ganti gambar/foto
                        $nama_file = $foto->getRandomName();
                        $data = [
                            'id_anggota' => $id_anggota,
                            'id_kelas' => $this->request->getPost('id_kelas'),
                            'nis' => $this->request->getPost('nis'),
                            'nama_siswa' => $this->request->getPost('nama_siswa'),
                            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                            'no_hp' => $this->request->getPost('no_hp'),
                            'password' => $this->request->getPost('password'),
                            'alamat' => $this->request->getPost('alamat'),
                            'verifikasi' => '1',
                            'foto' => $nama_file,
                        ];
                        //memindahkan/upload file foto ke dalam folder foto
                        $foto->move('foto', $nama_file);
                        $this->ModelAnggota->EditData($data);
                    }
                    session()->setFlashdata('pesan', 'Data Anggota Berhasil Diupdate !');
                    return redirect()->to(base_url('Anggota'));
                }else {
                    //jika tidak lolos validasi
                    session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
                    return redirect()->to(base_url('Anggota/EditData/' . $id_anggota));
                }
    }
    
    public function DeleteData ($id_anggota)
    {
        //hapus foto
        $anggota = $this->ModelAnggota->DetailData($id_anggota);
                            if ($anggota['foto'] <> '') {
                                unlink('foto/' . $anggota['foto']);
                            }

        $data = ['id_anggota'=> $id_anggota];
        $this->ModelAnggota->DeleteData($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus !');
        return redirect()->to(base_url('Anggota'));
                        }
                    }