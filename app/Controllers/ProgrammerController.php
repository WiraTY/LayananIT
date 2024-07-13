<?php

namespace App\Controllers;

use App\Models\ProjekModel;
use App\Models\ProgressModel;
use App\Models\DokumentasiModel;

class ProgrammerController extends BaseController
{
    public function index()
    {
        // Dapatkan ID programmer yang sedang login menggunakan Myth Auth
        $userId = service('authentication')->id();

        // Inisialisasi ProjekModel
        $projekModel = new ProjekModel();

        // Query data projek berdasarkan id_programmer yang sedang login
        $data['projek'] = $projekModel->where('id_programmer', $userId)
            ->join('tb_paket', 'tb_paket.id_paket = tb_projek.id_paket')
            ->join('tb_layanan', 'tb_layanan.id_layanan = tb_paket.id_layanan')
            ->join('tb_pendaftar', 'tb_pendaftar.id_pendaftar = tb_projek.id_pendaftar')
            ->where('tb_projek.id_programmer', $userId)
            ->select('tb_projek.*, tb_paket.nama_paket, tb_layanan.nama_layanan, tb_pendaftar.nama_pendaftar')
            ->findAll();

        // Tampilkan view dengan data projek yang sudah diambil
        return view('programmer/index', $data);
    }

    public function progress($id_projek)
    {
        // Lakukan query untuk mendapatkan data projek berdasarkan $id_projek
        $projekModel = new ProjekModel();
        $progressModel = new ProgressModel();
        $dokumentasiModel = new DokumentasiModel();

        $data['projek'] = $projekModel
            ->join('tb_paket', 'tb_paket.id_paket = tb_projek.id_paket')
            ->join('tb_layanan', 'tb_layanan.id_layanan = tb_paket.id_layanan')
            ->join('tb_pendaftar', 'tb_pendaftar.id_pendaftar = tb_projek.id_pendaftar')
            ->find($id_projek);

        $data['progress'] = $progressModel->where('id_projek', $id_projek)->first();
        $data['dokumentasi'] = $dokumentasiModel->where('id_projek', $id_projek)->findAll();


        // Tampilkan view halaman progress dengan data projek
        return view('programmer/progress', $data);
    }

    public function simpanProgress($id_projek)
    {
        // Validasi input progress (misalnya dengan form validation dari CodeIgniter)
        $validationRules = [
            'progress' => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[100]'
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('error', 'Masukkan persentase progress yang valid (0-100).');
        }

        // Dapatkan data progress baru dari input
        $newProgress = $this->request->getPost('progress');

        // Inisialisasi ProjekModel dan ProgressModel
        $projekModel = new ProjekModel();
        $progressModel = new ProgressModel();

        // Cek apakah sudah ada progress untuk projek ini di tb_progress
        $existingProgress = $progressModel->where('id_projek', $id_projek)->first();

        if ($existingProgress) {
            // Tambahkan progress baru dengan progress saat ini
            $totalProgress = $existingProgress['progress_projek'] + $newProgress;

            // Pastikan total progress tidak melebihi 100%
            if ($totalProgress > 100) {
                return redirect()->back()->withInput()->with('error', 'Total progress tidak boleh lebih dari 100%.');
            }

            // Jika valid, lakukan update
            $progressModel->update($existingProgress['id_progress'], ['progress_projek' => $totalProgress]);
        } else {
            // Jika belum ada, pastikan progress baru tidak melebihi 100%
            if ($newProgress > 100) {
                return redirect()->back()->withInput()->with('error', 'Total progress tidak boleh lebih dari 100%.');
            }

            // Tambahkan data baru
            $progressModel->save([
                'id_projek' => $id_projek,
                'progress_projek' => $newProgress
            ]);
        }

        // Redirect kembali ke halaman progress dengan pesan sukses
        return redirect()->to("/programmer/progress/{$id_projek}")->with('success', 'Progress berhasil disimpan.');
    }




    public function uploadProgressFile($id_projek)
    {
        $dokumentasiModel = new DokumentasiModel();
        $file = $this->request->getFile('file_dokumentasi');
        $deskripsi = $this->request->getPost('deskripsi_dokumentasi');

        if ($file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads', $fileName); // Simpan file di public/uploads

            // Simpan data dokumentasi dengan tanggal_dokumentasi yang sesuai
            $currentDateTime = date('Y-m-d H:i:s');
            $dokumentasiModel->save([
                'id_projek' => $id_projek,
                'file_dokumentasi' => $fileName,
                'deskripsi_dokumentasi' => $deskripsi,
                'tanggal_dokumentasi' => $currentDateTime
            ]);
        }

        return redirect()->to("/programmer/progress/{$id_projek}")->with('success', 'File progress berhasil diupload.');
    }


    public function updateDokumentasi($id_dokumentasi)
    {
        $dokumentasiModel = new DokumentasiModel();
        $data = $this->request->getPost();

        // Validasi dan update data dokumentasi
        if ($this->validate([
            'deskripsi_dokumentasi' => 'required'
        ])) {
            $dokumentasiModel->update($id_dokumentasi, ['deskripsi_dokumentasi' => $data['deskripsi_dokumentasi']]);
            return redirect()->back()->with('success', 'Deskripsi dokumentasi berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Deskripsi dokumentasi tidak boleh kosong.');
        }
    }

    public function deleteDokumentasi($id_dokumentasi)
    {
        $dokumentasiModel = new DokumentasiModel();

        // Hapus data dokumentasi
        $dokumentasiModel->delete($id_dokumentasi);
        return redirect()->back()->with('success', 'Dokumentasi berhasil dihapus.');
    }
}
