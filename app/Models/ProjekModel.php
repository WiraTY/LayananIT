<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjekModel extends Model
{
    protected $table = 'tb_projek';
    protected $primaryKey = 'id_projek';
    protected $allowedFields = ['id_pendaftar',    'id_paket',    'id_programmer', 'harga_projek', 'id_pembayaran', 'dp_projek', 'bukti_pembayaran', 'judul_projek', 'file_projek', 'approval', 'status_pembayaran'];

    public function updateProjek($id, $data)
    {
        // Update Projek data
        if ($this->update($id, $data)) {
            // If dp_projek or bukti_pembayaran is updated, update PembayaranModel
            if (isset($data['dp_projek']) || isset($data['bukti_pembayaran'])) {
                $pembayaranModel = new PembayaranModel();

                // Prepare the data for PembayaranModel update
                $updateData = [];
                if (isset($data['dp_projek'])) {
                    $updateData['total_pembayaran'] = $data['dp_projek'];
                }
                if (isset($data['bukti_pembayaran'])) {
                    $updateData['bukti_pembayaran'] = $data['bukti_pembayaran'];
                }

                // Update PembayaranModel
                return $pembayaranModel->where('id_projek', $id)->set($updateData)->update();
            }
            return true;
        }
        return false;
    }

    public function hitungStatusPembayaran()
    {
        $projeks = $this->findAll();

        foreach ($projeks as $projek) {
            // Hitung status_pembayaran
            $status_pembayaran = ($projek['sisa_tagihan'] == 0) ? 1 : 0;

            // Update status_pembayaran di database
            $this->update($projek['id_projek'], ['status_pembayaran' => $status_pembayaran]);
        }
    }
}
