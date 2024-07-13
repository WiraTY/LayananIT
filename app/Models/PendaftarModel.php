<?php

namespace App\Models;

use CodeIgniter\Model;

class PendaftarModel extends Model
{
    protected $table = 'tb_pendaftar';
    protected $primaryKey = 'id_pendaftar';
    protected $allowedFields = ['nama_pendaftar', 'alamat_pendaftar', 'no_pendaftar', 'email_pendaftar', 'username', 'password'];

    // Metode untuk mengambil semua data pendaftar
    public function getPendaftar()
    {
        return $this->findAll();
    }

    // Metode untuk menyimpan data pendaftar baru
    public function insertPendaftar($data)
    {
        return $this->insert($data);
    }

    // Metode untuk mengupdate data pendaftar
    public function updatePendaftar($id, $data)
    {
        return $this->update($id, $data);
    }

    // Metode untuk menghapus data pendaftar
    public function deletePendaftar($id)
    {
        return $this->delete($id);
    }

    public function getPendaftarById($id)
    {
        return $this->where('id_pendaftar', $id)->first();
    }
}
