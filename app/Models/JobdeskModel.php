<?php

namespace App\Models;

use CodeIgniter\Model;

class JobdeskModel extends Model
{
    protected $table = 'tb_jobdesk';
    protected $primaryKey = 'id_jobdesk';
    protected $allowedFields = ['id_programmer', 'deskripsi_jobdesk'];

    // Metode untuk mengambil semua data jobdesk
    public function getJobdesk()
    {
        return $this->findAll();
    }

    // Metode untuk menyimpan data jobdesk baru
    public function insertJobdesk($data)
    {
        return $this->insert($data);
    }

    // Metode untuk mengupdate data jobdesk
    public function updateJobdesk($id, $data)
    {
        return $this->update($id, $data);
    }

    // Metode untuk menghapus data jobdesk
    public function deleteJobdesk($id)
    {
        return $this->delete($id);
    }
}
