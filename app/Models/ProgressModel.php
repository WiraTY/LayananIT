<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgressModel extends Model
{
    protected $table = 'tb_progress';
    protected $primaryKey = 'id_progress';
    protected $allowedFields = ['id_projek', 'progress_projek', 'tanggal_dokumentasi'];

    public function saveProgress($id_projek, $progress)
    {
        $existingProgress = $this->where('id_projek', $id_projek)->first();

        if ($existingProgress) {
            // Jika sudah ada, lakukan update
            return $this->update($existingProgress['id_progress'], ['progress_projek' => $progress]);
        } else {
            // Jika belum ada, tambahkan data baru
            return $this->save([
                'id_projek' => $id_projek,
                'progress_projek' => $progress
            ]);
        }
    }
}
