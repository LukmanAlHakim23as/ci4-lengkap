<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPengaturan extends Model
{
    public function DetailWeb()
    {
        return $this->db->table('tbl_web')
            ->where('id_web', '1')
            ->get()->getRowArray();
    }

    public function UpdateWeb($data)
    {
        $this->db->table('tbl_web')
            ->where('id_web', $data['id_web'])
            ->update($data);
    }
}
