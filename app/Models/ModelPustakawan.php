<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPustakawan extends Model
{
    public function TotalBuku()
    {
       
    }

    public function TotalPustakawan()
    {
       return $this->db->table('tbl_perpustakawan')->countAll();
    }
}