<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAuth extends Model
{
    public function LoginUser($email, $password)
    {
        return $this->db->table('tbl_user')
            ->where([
                'email' => $email,
                'password' => $password,
            ])->get()->getRowArray();
    }

    public function Daftar($data)
    {
        $this->db->table('tbl_anggota')->insert($data);
    }

    public function LoginAnggota($nis, $password)
    {
        return $this->db->table('tbl_anggota')
            ->where([
                'nis' => $nis,
                'password' => $password,
            ])->get()->getRowArray();
    }

    public function LoginPustakawan($email, $password)
    {
        return $this->db->table('tbl_perpustakawan')
            ->where([
                'email' => $email,
                'password' => $password,
            ])->get()->getRowArray();
    }
}
