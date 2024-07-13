<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table = 'tb_pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $allowedFields = ['id_projek', 'total_pembayaran', 'bukti_pembayaran', 'approval_pembayaran', 'created_at'];

}
