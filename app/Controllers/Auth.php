<?php

namespace App\Controllers;

use App\Models\ModelAuth;
use App\Models\ModelKelas;

/**
 * @property ModelAuth $ModelAuth
 * @property ModelKelas $ModelKelas
 */
class Auth extends BaseController

{

    public function __construct()
    {
        helper('form');
        $this->ModelAuth = new ModelAuth;
        $this->ModelKelas = new ModelKelas;
    }


    public function index()
    {
        $data = [
            'judul' => 'Login',
            'page' => 'v_login'
        ];
        return view('v_template_login', $data);
    }

    public function LoginUser()
    {
        $data = [
            'judul' => 'Login User',
            'page' => 'v_login_user'
        ];
        return view('v_template_login', $data);
    }

    public function CekLoginUser()
    {
        if ($this->validate([
            'email' => [
                'label' => 'E-Mail',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => '{field} Masih Kosong !',
                    'valid_email' => '{field} Harus Format E-Mail !',
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Masih Kosong !',
                ]
            ]
        ])) {
            //jika entry valid
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $cek_login = $this->ModelAuth->loginUser($email, $password);
            if ($cek_login) {
                //jika login berhasil
                session()->set('id_user', $cek_login['id_user']);
                session()->set('nama_user', $cek_login['nama_user']);
                session()->set('email', $cek_login['email']);
                session()->set('level', $cek_login['level']);
                return redirect()->to(base_url('Admin'));
            } else {
                //jika gagal login krna password atau email salah
                session()->setFlashdata('pesan', 'E-Mail atau Password Salah !');
                return redirect()->to(base_url('Auth/LoginUser'));
            }
        } else {
            //jika entry tidak valid
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('Auth/LoginUser'));
        }
    }

    public function LoginAnggota()
    {
        $data = [
            'judul' => 'Login Anggota',
            'page' => 'v_login_anggota'
        ];
        return view('v_template_login', $data);
    }

    public function LogOut()
    {
        session()->remove('id_user');
        session()->remove('nama_user');
        session()->remove('email');
        session()->remove('level');
        session()->setFlashdata('pesan', 'Logout Sukses !');
        return redirect()->to(base_url('Auth/LoginUser'));
    }

    public function LogOutAnggota()
    {
        session()->remove('id_anggota');
        session()->remove('nama_siswa');
        session()->remove('level');
        session()->setFlashdata('pesan', 'Logout Sukses !');
        return redirect()->to(base_url('Auth/LoginAnggota'));
    }

    public function Register()
    {
        $data = [
            'judul' => 'Daftar Anggota',
            'page' => 'v_daftar_anggota',
            'kelas' => $this->ModelKelas->AllData()
        ];
        return view('v_template_login', $data);
    }

    public function Daftar()
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
                'label' => 'NIS',
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
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Masih Kosong !',
                ]
            ],
            'ulangi_password' => [
                'label' => 'Ulangi Password',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => '{field} Masih Kosong !',
                    'matches' => '{field} Tidak Sama Dengan Password Sebelumnya !',
                ]
            ],

        ])) {
            //jika lolos validasi
            $data = [
                'id_kelas' => $this->request->getPost('id_kelas'),
                'nis' => $this->request->getPost('nis'),
                'nama_siswa' => $this->request->getPost('nama_siswa'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'no_hp' => $this->request->getPost('no_hp'),
                'password' => $this->request->getPost('password'),
                'verifikasi' => '0',
            ];
            $this->ModelAuth->Daftar($data);
            session()->setFlashdata('pesan', 'Pendaftaran Berhasil, Silahkan Login !');
            return redirect()->to(base_url('Auth/Register'));
        } else {
            //jika tidak lolos validasi
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('Auth/Register'))->withInput('validation', \Config\Services::validation());
        }
    }

    public function CekLoginAnggota()
    {
        if ($this->validate([
            'nis' => [
                'label' => 'E-Mail',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Masih Kosong !',
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Masih Kosong !',
                ]
            ]
        ])) {
            //jika entry valid
            $nis = $this->request->getPost('nis');
            $password = $this->request->getPost('password');
            $cek_login = $this->ModelAuth->loginAnggota($nis, $password);
            if ($cek_login) {
                //jika login berhasil
                session()->set('id_anggota', $cek_login['id_anggota']);
                session()->set('nama_siswa', $cek_login['nama_siswa']);
                session()->set('level', 'Admin');
                return redirect()->to(base_url('DashboardAnggota'));
            } else {
                //jika gagal login krna password atau nis salah
                session()->setFlashdata('pesan', 'NIS atau Password Salah !');
                return redirect()->to(base_url('Auth/LoginAnggota'));
            }
        } else {
            //jika entry tidak valid
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('Auth/LoginAnggota'));
        }
    }

    public function LoginPustakawan()
    {
        $data = [
            'judul' => 'Login Pustakawan',
            'page' => 'v_login_pustakawan'
        ];
        return view('v_template_login', $data);
    }

    public function CekLoginPustakawan()
    {
        if ($this->validate([
            'email' => [
                'label' => 'E-Mail',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => '{field} Masih Kosong !',
                    'valid_email' => '{field} Harus Format E-Mail !',
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Masih Kosong !',
                ]
            ]
        ])) {
            //jika entry valid
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $cek_login = $this->ModelAuth->loginPustakawan($email, $password);
            if ($cek_login) {
                //jika login berhasil
                session()->set('nama_pustakawan', $cek_login['nama_pustakawan']);
                session()->set('email', $cek_login['email']);
                session()->set('level', $cek_login['level']);
                return redirect()->to(base_url('Pustakawan'));
            } else {
                //jika gagal login krna password atau email salah
                session()->setFlashdata('pesan', 'E-Mail atau Password Salah !');
                return redirect()->to(base_url('Auth/LoginPustakawan'));
            }
        } else {
            //jika entry tidak valid
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('Auth/LoginPustakawan'));
        }
    }
}
