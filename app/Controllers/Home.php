<?php

namespace App\Controllers;

use App\Models\LayananModel;
use App\Models\PaketModel;
use App\Models\PendaftarModel;
use App\Models\ProjekModel;
use App\Models\DokumentasiModel;
use App\Models\ProgressModel;
use App\Models\PembayaranModel;

class Home extends BaseController
{
    public function index()
    {
        $model = new LayananModel();
        $data['layanan'] = $model->getAllLayanan();
        return view('pendaftar/index', $data);
    }

    public function paket($id_layanan)
    {
        $model = new LayananModel();
        $data['layanan'] = $model->getAllLayanan();
        $paketModel = new PaketModel();
        $data['paket'] = $paketModel->getPaketByLayanan($id_layanan);

        if ($id_layanan == 1) {
            $data['section_title'] = 'nama board';
        } else {
            $data['section_title'] = 'pilihan paket';
        }

        return view('pendaftar/paket', $data);
    }

    public function profilPerusahaan()
    {
        $model = new LayananModel();
        $data['layanan'] = $model->getAllLayanan();
        return view('pendaftar/profil_perusahaan', $data);
    }

    public function strukturPerusahaan()
    {
        $model = new LayananModel();
        $data['layanan'] = $model->getAllLayanan();
        return view('pendaftar/struktur_perusahaan', $data);
    }

    public function tataKelolaPerusahaan()
    {
        $model = new LayananModel();
        $data['layanan'] = $model->getAllLayanan();
        return view('pendaftar/tata_kelola_perusahaan', $data);
    }

    public function visiMisi()
    {
        $model = new LayananModel();
        $data['layanan'] = $model->getAllLayanan();
        return view('pendaftar/visi_misi', $data);
    }

    public function linkZoom()
    {
        $model = new LayananModel();
        $data['layanan'] = $model->getAllLayanan();
        return view('pendaftar/link_zoom', $data);
    }

    public function pendaftaran($id_paket)
    {
        $model = new LayananModel();
        $data['layanan'] = $model->getAllLayanan();

        $paketModel = new PaketModel();
        $paket = $paketModel->find($id_paket);

        // Pastikan $paket tidak kosong
        if ($paket) {
            $data['nama_paket'] = $paket['nama_paket'];
            $data['detail_paket'] = $paket['detail_paket'];
            $data['id_paket'] = $paket['id_paket'];
        } else {
            $data['nama_paket'] = '';
            $data['detail_paket'] = '';
        }

        return view('pendaftar/pendaftaran', $data);
    }

    public function submitPendaftaran()
    {
        $nama_pendaftar = $this->request->getPost('nama');
        $alamat_pendaftar = $this->request->getPost('alamat');
        $no_pendaftar = $this->request->getPost('telp');
        $email_pendaftar = $this->request->getPost('email');
        $id_paket = $this->request->getPost('id_paket');
        $harga_projek = $this->request->getPost('harga');
        $bukti_pembayaran = $this->request->getFile('uploadBukti');
        $dp_projek = $this->request->getPost('dp');
        $judul_projek = $this->request->getPost('judul');
        $file_projek = $this->request->getFile('uploadFile');

        if ($bukti_pembayaran->isValid() && !$bukti_pembayaran->hasMoved()) {
            $fileName = $bukti_pembayaran->getRandomName();
            $bukti_pembayaran->move(ROOTPATH . 'public/uploads', $fileName);
        }

        if ($file_projek->isValid() && !$file_projek->hasMoved()) {
            $fileName = $file_projek->getRandomName();
            $file_projek->move(ROOTPATH . 'public/uploads', $fileName);
        }

        $pendaftarModel = new PendaftarModel();
        $dataPendaftar = [
            'nama_pendaftar' => $nama_pendaftar,
            'alamat_pendaftar' => $alamat_pendaftar,
            'no_pendaftar' => $no_pendaftar,
            'email_pendaftar' => $email_pendaftar,
            'username' => '',
            'password' => '',
        ];
        $pendaftarModel->insertPendaftar($dataPendaftar);

        // Ambil id_pendaftar yang baru saja dimasukkan
        $id_pendaftar = $pendaftarModel->insertID();

        $projekModel = new ProjekModel();
        $dataProjek = [
            'id_pendaftar' => $id_pendaftar,
            'id_paket' => $id_paket,
            'harga_projek' => $harga_projek,
            'dp_projek' => $dp_projek,
            'bukti_pembayaran' => $bukti_pembayaran->getName(),
            'judul_projek' => $judul_projek,
            'file_projek' => $file_projek->getName(),
            'approval' => 0,
            'status_pembayaran' => 0,
        ];
        $projekModel->insert($dataProjek);

        $pembayaranModel = new PembayaranModel();
        $dataPembayaran = [
            'id_projek' => $projekModel->insertID(), // Ambil ID projek yang baru saja dimasukkan
            'total_pembayaran' => $dp_projek,
            'bukti_pembayaran' => $bukti_pembayaran->getName(),
            'approval_pembayaran' => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $pembayaranModel->insert($dataPembayaran);

        return redirect()->to('/');
    }

    public function login()
    {
        $model = new LayananModel();
        $data['layanan'] = $model->getAllLayanan();
        return view('pendaftar/login', $data);
    }

    public function processLogin()
    {
        $session = session();

        // Ambil data dari form
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Validasi input
        if (empty($username) || empty($password)) {
            $session->setFlashdata('error', 'Username dan password harus diisi.');
            return redirect()->to('/pendaftar/login')->withInput();
        }

        // Validasi username dan password
        $model = new PendaftarModel();
        $user = $model->where('username', $username)
            ->first();

        if ($user) {
            // Jika username ditemukan, verifikasi password
            if (password_verify($password, $user['password'])) {
                // Jika password benar, set session dan arahkan ke halaman dashboard atau lainnya
                $session->set('username', $user['username']);
                $session->set('id_pendaftar', $user['id_pendaftar']); // Simpan id_pendaftar ke dalam sesi
                return redirect()->to('/pendaftar/progress'); // Ganti dengan halaman dashboard yang sesuai
            } else {
                // Jika password salah
                $session->setFlashdata('error', 'Password salah.');
                return redirect()->to('/pendaftar/login')->withInput(); // Redirect kembali ke halaman login dengan input sebelumnya
            }
        } else {
            // Jika username tidak ditemukan
            $session->setFlashdata('error', 'Username tidak ditemukan.');
            return redirect()->to('/pendaftar/login')->withInput(); // Redirect kembali ke halaman login dengan input sebelumnya
        }
    }


    public function logout()
    {
        $session = session();

        // Hapus semua data session
        $session->destroy();

        // Redirect ke halaman login atau halaman lain yang sesuai
        return redirect()->to('/'); // Ganti dengan halaman yang sesuai setelah logout
    }

    public function progress()
    {
        $session = session();

        // Pastikan hanya pendaftar yang bisa mengakses halaman progress, sesuai kebutuhan aplikasi
        if (!$session->get('username')) {
            return redirect()->to('/pendaftar/login'); // Redirect jika belum login
        }

        // Ambil data projek yang sedang dikerjakan berdasarkan id_pendaftar
        $pendaftarModel = new PendaftarModel();
        $projekModel = new ProjekModel();

        // Ambil id_pendaftar berdasarkan username dari session
        $username = $session->get('username');
        $pendaftar = $pendaftarModel->where('username', $username)->first();

        if (!$pendaftar) {
            // Handle jika pendaftar tidak ditemukan
            return redirect()->to('/pendaftar/login')->with('error', 'Pendaftar not found.');
        }

        // Query data projek berdasarkan id_pendaftar
        $data['projek'] = $projekModel->where('id_pendaftar', $pendaftar['id_pendaftar'])
            ->join('tb_paket', 'tb_paket.id_paket = tb_projek.id_paket')
            ->join('tb_layanan', 'tb_layanan.id_layanan = tb_paket.id_layanan')
            ->join('users', 'users.id = tb_projek.id_programmer', 'left')
            ->select('tb_projek.*, tb_paket.nama_paket, tb_layanan.nama_layanan, users.username as nama_programmer')
            ->findAll();

        // Tampilkan view dengan data projek yang sudah diambil
        return view('pendaftar/progress', $data);
    }

    public function progressDetail($id_projek)
    {
        // Inisialisasi model
        $projekModel = new ProjekModel();
        $progressModel = new ProgressModel();
        $dokumentasiModel = new DokumentasiModel();

        // Query untuk mendapatkan data projek berdasarkan id_projek
        $projek = $projekModel
            ->join('tb_paket', 'tb_paket.id_paket = tb_projek.id_paket')
            ->join('tb_layanan', 'tb_layanan.id_layanan = tb_paket.id_layanan')
            ->join('users', 'users.id = tb_projek.id_programmer', 'left')
            ->select('tb_projek.*, tb_paket.nama_paket, tb_paket.detail_paket, tb_layanan.nama_layanan, users.username as nama_programmer')
            ->find($id_projek);

        // Query untuk mendapatkan dokumentasi projek berdasarkan id_projek
        $dokumentasi = $dokumentasiModel->where('id_projek', $id_projek)->findAll();

        // Query untuk mendapatkan progress projek berdasarkan id_projek
        $progress = $progressModel->where('id_projek', $id_projek)->first();

        foreach ($dokumentasi as &$file) {
            $file['tanggal_dokumentasi'] = date('Y-m-d H:i:s', strtotime($file['tanggal_dokumentasi']));
        }

        // Jika projek ditemukan, tampilkan view detail progress
        if ($projek) {
            $data = [
                'projek' => $projek,
                'dokumentasi' => $dokumentasi,
                'progress' => $progress
            ];

            return view('pendaftar/detail_progress', $data);
        } else {
            // Jika projek tidak ditemukan, redirect atau tampilkan pesan kesalahan
            return redirect()->back()->with('error', 'Projek tidak ditemukan.');
        }
    }

    public function detailPembayaran($id_projek)
    {
        $projekModel = new ProjekModel();
        $pendaftarModel = new PendaftarModel();
        $pembayaranModel = new PembayaranModel();

        // Fetch project details
        $project = $projekModel->find($id_projek);

        if (!$project) {
            // Handle project not found, redirect or show error
            return redirect()->back()->with('error', 'Project not found.');
        }

        // Fetch registrant name from PendaftarModel using id_pendaftar
        $pendaftar = $pendaftarModel->find($project['id_pendaftar']);

        // Initialize totalPaid
        $totalPaid = 0;

        // Fetch payments related to the project
        $payments = $pembayaranModel->where('id_projek', $id_projek)->findAll();

        // Calculate totalPaid only for approved payments
        foreach ($payments as $item) {
            if ($item['approval_pembayaran'] == 1) {
                $totalPaid += $item['total_pembayaran'];
            }
        }

        // Calculate remaining balance
        $remainingBalance = $project['harga_projek'] - $totalPaid;

        // Determine status_pembayaran based on remaining balance
        $statusPembayaran = $remainingBalance == 0 ? 1 : 0; // 1 for paid, 0 for unpaid

        // Prepare data for view
        $data = [
            'id_projek' => $id_projek,
            'nama_projek' => $project['judul_projek'],
            'nama_pendaftar' => $pendaftar ? $pendaftar['nama_pendaftar'] : 'Unknown', // Handle if pendaftar not found
            'harga_projek' => $project['harga_projek'],
            'total_dibayar' => $totalPaid,
            'sisa_tagihan' => $remainingBalance,
            'status_pembayaran' => $statusPembayaran,
            'pembayaran' => $payments, // Send payments data to the view
        ];

        // Pass data to view
        return view('pendaftar/detail_pembayaran', $data);
    }

    // public function tambahRiwayatPembayaranForm($id_projek)
    // {
    //     $data = ['id_projek' => $id_projek];
    //     return view('pendaftar/tambah_pembayaran', $data);
    // }

    public function tambahRiwayatPembayaran($id_projek)
    {
        $pembayaranModel = new PembayaranModel();

        $file = $this->request->getFile('bukti_pembayaran');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads', $newName);

            $data = [
                'id_projek' => $id_projek,
                'total_pembayaran' => $this->request->getPost('total_pembayaran'),
                'bukti_pembayaran' => $newName,
                'approval_pembayaran' => 0, // Set default approval to 0
                'created_at' => date('Y-m-d H:i:s')
            ];

            $pembayaranModel->insert($data);

            return redirect()->to(base_url("pendaftar/detail-pembayaran/{$id_projek}"))->with('success', 'Riwayat pembayaran berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Gagal mengunggah bukti pembayaran.');
        }
    }

    public function profile()
    {
        $session = session();
        $id = $session->get('id_pendaftar'); // Asumsi id_pendaftar disimpan di sesi setelah login

        if (!$id) {
            // Handle case when id_pendaftar is not set in session
            return redirect()->to('/pendaftar/login'); // Redirect to login page or handle accordingly
        }

        $pendaftarModel = new PendaftarModel();
        $pendaftar = $pendaftarModel->getPendaftarById($id);

        if (!$pendaftar) {
            // Handle case when pendaftar data is not found
            return redirect()->to('/pendaftar/login'); // Redirect to login page or handle accordingly
        }

        return view('pendaftar/profile', ['pendaftar' => $pendaftar]);
    }


    public function updateProfile()
    {
        $session = session();
        $id = $session->get('id_pendaftar');

        // Ambil data dari form
        $nama_pendaftar = $this->request->getPost('nama_pendaftar');
        $alamat_pendaftar = $this->request->getPost('alamat_pendaftar');
        $nomor_pendaftar = $this->request->getPost('nomor_pendaftar');
        $email_pendaftar = $this->request->getPost('email_pendaftar');
        $username = $this->request->getPost('username');
        $password_lama = $this->request->getPost('password_lama');
        $password_baru = $this->request->getPost('password_baru');
        $ulangi_password = $this->request->getPost('ulangi_password');

        // Validasi input
        if (empty($nama_pendaftar) || empty($alamat_pendaftar) || empty($nomor_pendaftar) || empty($email_pendaftar) || empty($username)) {
            $session->setFlashdata('error', 'Semua kolom harus diisi.');
            return redirect()->back()->withInput();
        }

        // Validasi password lama
        $pendaftarModel = new PendaftarModel();
        $pendaftar = $pendaftarModel->find($id);

        if (!password_verify($password_lama, $pendaftar['password'])) {
            $session->setFlashdata('error', 'Password lama salah.');
            return redirect()->back()->withInput();
        }

        // Validasi password baru
        if ($password_baru !== $ulangi_password) {
            $session->setFlashdata('error', 'Password baru dan konfirmasi tidak sesuai.');
            return redirect()->back()->withInput();
        }

        // Update profil dan password baru
        $data = [
            'nama_pendaftar' => $nama_pendaftar,
            'alamat_pendaftar' => $alamat_pendaftar,
            'no_pendaftar' => $nomor_pendaftar,
            'email_pendaftar' => $email_pendaftar,
            'username' => $username,
            'password' => password_hash($password_baru, PASSWORD_DEFAULT), // Hash password baru
        ];

        $pendaftarModel->update($id, $data);

        $session->setFlashdata('success', 'Profil berhasil diperbarui.');

        return redirect()->to('/pendaftar/profile');
    }
}
