<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgrammerModel extends Model
{
    protected $table = 'tb_programmer';
    protected $primaryKey = 'id_programmer';
    protected $allowedFields = ['nama_programmer', 'skill_programmer'];

    // Metode untuk mengambil semua data programmer
    public function getProgrammer()
    {
        return $this->findAll();
    }

    // Metode untuk menyimpan data programmer baru
    public function insertProgrammer($data)
    {
        return $this->insert($data);
    }

    // Metode untuk mengupdate data programmer
    public function updateProgrammer($id, $data)
    {
        return $this->update($id, $data);
    }

    // Metode untuk menghapus data programmer
    public function deleteProgrammer($id)
    {
        return $this->delete($id);
    }
}
