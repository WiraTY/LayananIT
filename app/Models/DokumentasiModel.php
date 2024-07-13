<?php

namespace App\Models;

use CodeIgniter\Model;

class DokumentasiModel extends Model
{
    protected $table = 'tb_dokumentasi';
    protected $primaryKey = 'id_dokumentasi';
    protected $allowedFields = ['id_projek', 'deskripsi_dokumentasi', 'file_dokumentasi'];

}
