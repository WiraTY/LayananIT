<?php

namespace App\Models;

use CodeIgniter\Model;

class LayananModel extends Model
{
    protected $table = 'tb_layanan'; // Nama tabel di database
    protected $primaryKey = 'id_layanan'; // Kolom primary key
    protected $allowedFields = ['nama_layanan', 'deskripsi_layanan', 'icon_layanan']; // Kolom yang diizinkan untuk diisi

    // Metode untuk mengambil semua data layanan
    public function getAllLayanan()
    {
        return $this->findAll();
    }
}
