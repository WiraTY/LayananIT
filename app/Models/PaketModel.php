<?php

namespace App\Models;

use CodeIgniter\Model;

class PaketModel extends Model
{
    protected $table = 'tb_paket';
    protected $primaryKey = 'id_paket';
    protected $allowedFields = ['id_layanan', 'nama_paket', 'detail_paket', 'harga_paket', 'icon_paket'];

    // Metode untuk mengambil semua paket berdasarkan id_layanan
    public function getPaketByLayanan($id_layanan)
    {
        return $this->where('id_layanan', $id_layanan)->findAll();
    }
}
