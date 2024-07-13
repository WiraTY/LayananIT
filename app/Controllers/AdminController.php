<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PendaftarModel;
use App\Models\ProjekModel;
use App\Models\PaketModel;
use App\Models\ProgrammerModel;
use App\Models\PembayaranModel;
use Myth\Auth\Models\UserModel;
use TCPDF;
use Myth\Auth\Entities\User;
use App\Libraries\CustomTCPDF;

class AdminController extends Controller
{
    public function index()
    {
        $pendaftarModel = new PendaftarModel();
        $data['pendaftar'] = $pendaftarModel->findAll();

        return view('admin/index', $data);
    }

    public function tambah_pendaftar()
    {
        // Contoh mendapatkan data $paket dari PaketModel
        $paketModel = new PaketModel();
        $data['paket'] = $paketModel->findAll(); // Adjust this to fit your logic

        return view('admin/tambah_pendaftar', $data);
    }

    public function simpan()
    {
        $pendaftarModel = new PendaftarModel();
        $projekModel = new ProjekModel();
        $pembayaranModel = new PembayaranModel();

        $dataPendaftar = [
            'nama_pendaftar' => $this->request->getPost('nama'),
            'alamat_pendaftar' => $this->request->getPost('alamat'),
            'no_pendaftar' => $this->request->getPost('telp'),
            'email_pendaftar' => $this->request->getPost('email'),
            'username' => '',
            'password' => '',
        ];

        // Insert data pendaftar
        $pendaftarModel->insert($dataPendaftar);
        $id_pendaftar = $pendaftarModel->insertID();

        // Upload file bukti pembayaran
        $bukti_pembayaran = $this->request->getFile('uploadBukti');
        $fileName = $bukti_pembayaran->getRandomName();
        $bukti_pembayaran->move(ROOTPATH . 'public/uploads', $fileName);

        // Upload file proposal
        $file_projek = $this->request->getFile('uploadFile');
        $fileName = $file_projek->getRandomName();
        $file_projek->move(ROOTPATH . 'public/uploads', $fileName);

        // Insert data projek
        $dataProjek = [
            'id_pendaftar' => $id_pendaftar,
            'id_paket' => $this->request->getPost('id_paket'),
            'harga_projek' => $this->request->getPost('harga'),
            'dp_projek' => $this->request->getPost('dp'),
            'bukti_pembayaran' => $bukti_pembayaran->getName(),
            'judul_projek' => $this->request->getPost('judul'),
            'file_projek' => $file_projek->getName(),
            'approval' => 0,
            'status_pembayaran' => 0,
        ];
        $projekModel->insert($dataProjek);
        $id_projek = $projekModel->insertID();

        // Insert data pembayaran
        $dataPembayaran = [
            'id_projek' => $id_projek,
            'total_pembayaran' => $this->request->getPost('dp'),
            'bukti_pembayaran' => $bukti_pembayaran->getName(),
            'approval_pembayaran' => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $pembayaranModel->insert($dataPembayaran);

        return redirect()->to('/admin/pendaftar')->with('success', 'Data pendaftar berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pendaftarModel = new PendaftarModel();
        $data['pendaftar'] = $pendaftarModel->find($id);

        return view('admin/edit_pendaftar', $data);
    }

    public function update($id)
    {
        $pendaftarModel = new PendaftarModel();

        $data = [
            'nama_pendaftar' => $this->request->getPost('nama'),
            'alamat_pendaftar' => $this->request->getPost('alamat'),
            'no_pendaftar' => $this->request->getPost('telp'),
            'email_pendaftar' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            // 'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];

        if ($pendaftarModel->updatePendaftar($id, $data)) {
            return redirect()->to('/admin/pendaftar');
        } else {
            return redirect()->back()->withInput()->with('error', 'Data gagal diperbarui.');
        }
    }

    public function delete($id)
    {
        $pendaftarModel = new PendaftarModel();
        $pendaftarModel->deletePendaftar($id);

        return redirect()->to('/admin/pendaftar')->with('success', 'Data pendaftar berhasil dihapus.');
    }

    public function detail_projek($id_pendaftar)
    {
        $projekModel = new ProjekModel();
        $pendaftarModel = new PendaftarModel();
        $paketModel = new PaketModel();
        $programmerModel = new ProgrammerModel();

        $projek = $projekModel->where('id_pendaftar', $id_pendaftar)->first();

        if ($projek) {
            $data['projek'] = $projek;
            $data['pendaftar'] = $pendaftarModel->find($projek['id_pendaftar']);
            $data['paket'] = $paketModel->find($projek['id_paket']);
            $data['programmers'] = $programmerModel->getProgrammers();

            $data['all_pakets'] = $paketModel->findAll();

            $existingPendaftar = $pendaftarModel->find($data['projek']['id_pendaftar']);
            if ($existingPendaftar['username'] && $existingPendaftar['password']) {
                // Jika sudah ada, gunakan nilai yang sudah ada
                $data['username'] = $existingPendaftar['username'];
                $data['password'] = $existingPendaftar['password'];
            } else {
                // Jika belum ada, gunakan nilai default
                $data['username'] = $existingPendaftar['nama_pendaftar'] . $existingPendaftar['id_pendaftar'];
                $data['password'] = '12345678';
            }

            $data['selected_programmer_id'] = $data['projek']['id_programmer'] ?? '';

            return view('admin/detail_projek', $data);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Projek with ID Pendaftar ' . $id_pendaftar . ' not found');
        }
    }

    public function editHargaDP($id)
    {
        $projekModel = new ProjekModel();
        $pembayaranModel = new PembayaranModel();

        $data = [
            'harga_projek' => $this->request->getPost('harga_projek'),
            'dp_projek' => $this->request->getPost('dp_projek'),
        ];

        if ($projekModel->update($id, $data)) {
            $projek = $projekModel->find($id);
            $projekId = $projek['id_pembayaran']; // Pastikan ini adalah id_pembayaran yang benar

            // Ambil data total_pembayaran yang ada di PembayaranModel
            $pembayaran = $pembayaranModel->where('id_pembayaran', $projekId)->first();

            if ($pembayaran) {
                // Update total_pembayaran di PembayaranModel
                $dataPembayaran = [
                    'total_pembayaran' => $this->request->getPost('dp_projek'),
                ];

                $pembayaranModel->update($pembayaran['id_pembayaran'], $dataPembayaran); // Gunakan id dari $pembayaran, bukan $projekId

                return redirect()->to('/admin/projek/' .  $projek['id_pendaftar'])->with('success', 'Harga projek dan DP projek berhasil diperbarui.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Data pembayaran tidak ditemukan.');
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui harga projek dan DP projek.');
        }
    }

    public function editDetailHargaDP($id_projek)
    {
        $projekModel = new ProjekModel();
        $pembayaranModel = new PembayaranModel();

        $dataProjek = [
            'judul_projek' => $this->request->getPost('judul_projek'),
            'harga_projek' => $this->request->getPost('harga_projek'),
            'dp_projek' => $this->request->getPost('dp_projek'),
        ];

        // Update data projek dengan klausa where
        if ($projekModel->where('id_projek', $id_projek)->update($dataProjek)) {
            // Ambil data pembayaran yang sesuai dengan id_projek
            $pembayaran = $pembayaranModel->where('id_projek', $id_projek)->first();

            if ($pembayaran) {
                // Update total_pembayaran di PembayaranModel
                $dataPembayaran = [
                    'total_pembayaran' => $this->request->getPost('dp_projek'),
                ];

                // Update data pembayaran dengan klausa where
                $pembayaranModel->where('id_projek', $id_projek)->update($dataPembayaran);

                // Ambil kembali data projek setelah update
                $projek = $projekModel->find($id_projek);

                return redirect()->to('/admin/detail_projek/' . $projek['id_pendaftar'])->with('success', 'Detail projek berhasil diperbarui.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Data pembayaran tidak ditemukan.');
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui detail projek.');
        }
    }




    public function uploadBuktiPembayaran()
    {
        $projekModel = new ProjekModel();
        $pembayaranModel = new PembayaranModel();

        $projekId = $this->request->getPost('projek_id');

        $file = $this->request->getFile('bukti_pembayaran');
        if ($file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads', $fileName); // Simpan file di public/uploads

            // Update bukti_pembayaran di ProjekModel
            $projekModel->update($projekId, ['bukti_pembayaran' => $fileName]);

            // Ambil id_pembayaran dari PembayaranModel berdasarkan id_projek
            $pembayaran = $pembayaranModel->where('id_projek', $projekId)->first();

            if ($pembayaran) {
                // Update bukti_pembayaran di PembayaranModel
                $dataPembayaran = [
                    'bukti_pembayaran' => $fileName,
                ];
                $affectedRows = $pembayaranModel->update($pembayaran['id_pembayaran'], $dataPembayaran);

                if ($affectedRows > 0) {
                    // Redirect dengan pesan sukses jika ada baris yang terpengaruh
                    return redirect()->to('/admin/projek/' . $projekModel->find($projekId)['id_pendaftar'])->with('success', 'Bukti pembayaran berhasil diupload.');
                } else {
                    // Redirect dengan pesan error jika tidak ada baris yang terpengaruh
                    return redirect()->to('/admin/projek/' . $projekId)->with('error', 'Gagal mengupdate bukti pembayaran.');
                }
            } else {
                return redirect()->to('/admin/projek/' . $projekId)->with('error', 'Data pembayaran tidak ditemukan.');
            }
        }

        return redirect()->to('/admin/projek/' . $projekId)->with('error', 'Gagal mengupload bukti pembayaran.');
    }

    public function deleteBuktiPembayaran($id)
    {
        $projekModel = new ProjekModel();
        $projek = $projekModel->find($id);

        if ($projek && $projek['bukti_pembayaran']) {
            // Hapus file fisik
            $filePath = ROOTPATH . 'public/uploads/' . $projek['bukti_pembayaran'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Hapus referensi di database
            $projekModel->update($id, ['bukti_pembayaran' => null]);
            $id_pendaftar = $projek['id_pendaftar'];
        }

        return redirect()->to('/admin/projek/' . $id_pendaftar)->with('success', 'Bukti pembayaran berhasil dihapus.');
    }

    public function uploadFileProjek()
    {
        $projekModel = new ProjekModel();
        $projekId = $this->request->getPost('projek_id');

        $file = $this->request->getFile('file_projek');
        if ($file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads', $fileName); // Simpan file di public/uploads
            $projekModel->update($projekId, ['file_projek' => $fileName]);
        }

        // Ambil id_pendaftar dari projek
        $projek = $projekModel->find($projekId);
        $id_pendaftar = $projek['id_pendaftar'];

        return redirect()->to('/admin/projek/' . $id_pendaftar)->with('success', 'File projek berhasil diupload.');
    }


    public function deleteFileProjek($id)
    {
        $projekModel = new ProjekModel();
        $projek = $projekModel->find($id);
        $id_pendaftar = $projek['id_pendaftar'];

        if ($projek && $projek['file_projek']) {
            // Hapus file fisik
            $filePath = ROOTPATH . 'public/uploads/' . $projek['file_projek'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Hapus referensi di database
            $projekModel->update($id, ['file_projek' => null]);
        }

        return redirect()->to('/admin/projek/' . $id_pendaftar)->with('success', 'File projek berhasil dihapus.');
    }

    public function assignProgrammer()
    {
        $projekModel = new ProjekModel();
        $projekId = $this->request->getPost('projek_id');
        $programmerId = $this->request->getPost('programmer_id');

        $projekModel->update($projekId, ['id_programmer' => $programmerId]);

        return redirect()->to('/admin/projek/' . $projekModel->find($projekId)['id_pendaftar'])->with('success', 'Programmer berhasil ditugaskan.');
    }

    public function simpanDanApprove($pendaftarId, $projekId)
    {
        $pendaftarModel = new PendaftarModel();
        $projekModel = new ProjekModel();
        $paketModel = new PaketModel();

        // $projek = $projekModel->find($projekId);
        if ($projek['approval'] == 1) {
            return redirect()->to('/admin/projek/' . $pendaftarId)->with('info', 'Projek ini sudah disetujui sebelumnya.');
        }

        // Ambil data username dan password dari request
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $plaintextPassword = $password;

        // Data untuk simpan username dan password
        $data = [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ];

        // Periksa apakah data sudah ada untuk id_pendaftar
        $existingPendaftar = $pendaftarModel->find($pendaftarId);
        if ($existingPendaftar) {
            // Jika sudah ada, lakukan update
            $pendaftarModel->update($pendaftarId, $data);
        } else {
            // Jika belum ada, lakukan insert baru
            $data['id_pendaftar'] = $pendaftarId;
            $pendaftarModel->insert($data);
        }

        // Setujui projek
        $action = $this->request->getPost('action');
        $approvalStatus = 0;

        if ($action === 'approve') {
            $approvalStatus = 1;
        } elseif ($action === 'reject') {
            $approvalStatus = 2;
        }

        // Simpan status approval hanya jika semua operasi selesai tanpa error
        $success = true;

        if (!$projekModel->update($projekId, ['approval' => $approvalStatus])) {
            $success = false;
        }

        // Kirim email
        $projek = $projekModel->find($projekId);
        $pendaftar = $pendaftarModel->find($projek['id_pendaftar']);
        $paket = $paketModel->find($projek['id_paket']);

        $harga_projek = number_format($projek['harga_projek'], 0, ',', '.');
        $dp_projek = number_format($projek['dp_projek'], 0, ',', '.');

        if ($projek && $pendaftar && $paket) {
            $nama_pendaftar = $pendaftar['nama_pendaftar'];
            $alamat_pendaftar = $pendaftar['alamat_pendaftar'];
            $no_pendaftar = $pendaftar['no_pendaftar'];

            $judul_projek = $projek['judul_projek'];
            $harga_projek = number_format($projek['harga_projek'], 0, ',', '.');

            $username = $pendaftar['username'];
            $password = $plaintextPassword;

            // Buat objek TCPDF
            $pdf = new CustomTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // Set header data dengan menggunakan konstanta yang sudah ditetapkan
            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Nama Penulis');
            $pdf->SetTitle('Judul PDF');
            $pdf->SetSubject('Subjek PDF');
            $pdf->SetKeywords('TCPDF, PDF, contoh, header, kode php');
            $pdf->setPrintHeader(true);
            $pdf->setPrintFooter(true);
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // $imagePath = K_PATH_IMAGES . 'cv2.jpg';


            $htmlContent = "
            <head>
            <style>
                ol {
                    font-size: 9px;
                    text-align: justify;
                }
            </style>
            </head>            
            <body>
                <table>
                    <tr>
                        <td width=\"100px\">Nama Pendaftar</td><td>: {$nama_pendaftar}</td>
                    </tr>
                    <tr>
                        <td>Alamat Pendaftar</td><td>: {$alamat_pendaftar}</td>
                    </tr>
                    <tr>
                        <td>No. Pendaftar</td><td>: {$no_pendaftar}</td>
                    </tr>
                    <tr><td colspan=\"2\">Dengan ini saya meminta bantuan kepada CV. HAIKAL TEKNO KREASI untuk membimbing dengan</td></tr>
                    <tr>
                        <td>Judul Projek</td><td>: {$projek['judul_projek']}</td>
                    </tr>
                    <tr>
                        <td>Nama Paket</td><td>: {$paket['nama_paket']}</td>
                    </tr>
                    <tr>
                        <td>Harga Projek</td><td>: Rp. {$harga_projek}</td>
                    </tr>
                </table>
                <p>Peraturan dan Ketentuan:</p>
                <ol>
                    <li>Dengan klik SETUJU pada saat awal pendaftaran maka pendaftar telah menandatangani isi dalam peraturan ini.</li>
                    <li>Membebaskan CV. HAIKAL TEKNO KREASI segala tuntutan hukum terhadap penyalahgunaan layanan atau produk CV. HAIKAL TEKNO KREASI yang dilakukan customer. (Peraturan untuk Semua Jenis Pendaftaran)</li>
                    <li>Gratis Revisi 5x untuk LAPORAN, REVISI PROGRAM/SOFTWARE setelah Berita Acara Pengambilan (BAP) atau SAAT PROGRAM/ALAT DIKERJAKAN akan dikenakan BIAYA TAMBAHAN. (Peraturan untuk Semua Jenis Pendaftaran)</li>
                    <li>Paket Pendaftaran atau uang yang masuk TIDAK DAPAT DICAIRKAN/DIKEMBALIKAN/DIMINTA dengan alasan apapun. (Peraturan untuk Semua Jenis Pendaftaran)</li>
                    <li>Paket pendaftaran ini HANGUS apabila pendaftar tidak memberikan kabar progres penelitiannya ke CV. HAIKAL TEKNO KREASI selama maksimal 1 bulan (Khusus Pendaftar Paket IT Research/Paket C/Paket A)</li>
                    <li>Prosedur bimbingan pendaftar paket C yang diberikan adalah pendaftar mengerjakan sambil di bimbing oleh CV. HAIKAL TEKNO KREASI dalam bentuk materi konsultasi berupa konsep, praktek dan contoh perbab laporan serta source code program dengan durasi konsultasi maksimal 2 jam/hari kerja kantor setiap hari Senin s/d Jum'at jam 08.00 - 16.00 dan Sabtu 08.00-13.00. Sedangkan paket A tanpa program, peraturan poin ini khusus untuk Paket IT Research. Jika pendaftar membatalkan pendaftaran atau tidak melanjutkan atau nomer telepon tidak dapat dihubungi/tidak membalas pesan/telepon sampai lebih dari 1 bulan dari CV. HAIKAL TEKNO KREASI, maka pendaftaran dan uang masuk HANGUS. (Peraturan untuk Semua Jenis Pendaftaran)</li>
                    <li>Jika pendaftar membatalkan atau tidak melanjutkan atau nomer telepon tidak dapat dihungi/tidak membalas pesan/telepon sampai lebih dari 1 bulan dari CV. HAIKEL TEKNO KREASI, maka pendaftaran dan uang masuk HANGUS</li>
                    <li>Apabila riset atau revisi yang diminta pendaftar mempunyai tingkat kesulitan tinggi, maka prosesnya akan memakan waktu yang lebih lama. Oleh karena itu CV. HAIKAL TEKNO KREASI tidak bertanggung jawab atas kerugian yang dialami pendaftar karena batas masa studi habis atau batas berlakunya SK judul telah habis. (Peraturan untuk Paket IT Research)</li>
                    <li>Paket pendaftaran tidak termasuk jurnal, abstrak, daftar isi, data penelitian dari tempat yang di teliti, alat, excel dan slide power point. (Peraturan untuk Paket IT Research)</li>
                    <li>CV. HAIKAL TEKNO KREASI TIDAK BERTANGGUNGJAWAB atas: 1. Kerugian dialami pendaftar dikarenakan masa studi habis; 2. Program/alat/laporan yang tidak diambil melebihi 2 minggu dari tanggal selesai sehingga terjadinya ERROR/Kendala/Ketidaksesuaian BUKAN TANGGUNGJAWAB KAMI; 3. Program/alat/laporan yang tidak diambil melebihi 1 Bulan dari tanggal selesai, kami anggap sudah selesai mengerjakan LAPORAN/PROGRAM tersebut dan KAMI TIDAK MENERIMA COMPLAIN APAPUN serta PENDAFTARAN kami nyatakan HANGUS. (Peraturan untuk Paket IT Research)</li>
                    <li>Apabila terjadi protes atau gangguan di luar tugas CV. HAIKAL TEKNO KREASI maka sepenuhnya di tanggung oleh pendaftar. (Peraturan untuk Semua Jenis Pendaftaran)</li>
                    <li>Setiap pendaftar paket A dan C apabila mengajak temannya yang mau daftar akan diberikan potongan harga sebesar 100 rb per 1 orang pendaftar (potongan harga tidak berlaku jika yang mengajak sudah selesai). (Peraturan untuk Paket IT Research)</li>
                </ol>
                <table cellspacing=\"0\" cellpadding=\"1\" border=\"0\">
                    <tr>
                        <td style=\"width: 50%; text-align: left;\">
                            <br>
                            <b>Pendaftar,</b>
                            <br><br><br><br>
                            _______________________
                            <br>
                            <b>Nama</b>
                        </td>
                        <td style=\"width: 50%; text-align: right;\">
                            <br>
                            <b>Admin CV. Haikal Tekno Kreasi<br>
                            Malang, " . date('d/m/Y') . "</b>
                            <br><br><br>
                            <b>Yusi</b>
                        </td>
                    </tr>
                </table>
            </body>";
            $pdf->AddPage();
            $pdf->writeHTML($htmlContent, true, false, true, false, '');


            // Simpan PDF ke server (opsional, jika ingin menyimpan ke server)
            $pdfFilePath = WRITEPATH . 'uploads/invoice_' . date('YmdHis') . '.pdf';
            $pdf->Output($pdfFilePath, 'F'); // 'F' untuk menyimpan ke file

            $htmlMessage = "
            <h3>Terima kasih telah mempercayakan CV. HAIKAL TEKNO KREASI. Berukut user akses login:</h3>
            <br><br>
            <table>
                <tr>
                    <td>Username</td>
                    <td>: {$username}</td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>: {$password}</td>
                </tr>
                <tr>
                    <td>Terdaftar Paket</td>
                    <td>: {$paket['nama_paket']}</td>
                </tr>
                <tr>
                    <td>Harga Paket</td>
                    <td>: Rp. {$harga_projek}</td>
                </tr>
            </table>
            <p>Simpan username dan password dengan baik. Username dan password tersebut dapat digunakan untuk login ke website www.cvhaikaltekno.com. Setelah login, Anda dapat melihat proses pengerjaan program yang sedang Anda pesan angsuran/cicilan paket pendaftaran. Berikut file formulir pendaftaran yang telah Anda isi.</p>
            ";

            // Atau, langsung kirim sebagai lampiran email
            $email = service('email');
            $email->setTo($pendaftar['email_pendaftar']);
            $email->setFrom('iyatapitidak@gmail.com', 'Tes OJT');
            $email->setSubject('INVOICE');
            $email->setMessage($htmlMessage);
            $email->attach($pdfFilePath);

            $emailSent = $email->send();

            if (!$emailSent) {
                $data = $email->printDebugger(['header']);
                print_r($data);
                return redirect()->to('/admin/projek/' . $pendaftarId)->with('error', 'Gagal mengirim email. Projek berhasil di-' . ($action === 'approve' ? 'approve' : 'reject') . '.');
            }
        } else {
            return redirect()->to('/admin/projek/' . $pendaftarId)->with('error', 'Data projek, pendaftar, atau paket tidak ditemukan.');
        }

        // Kirim pesan WhatsApp
        $message = "*INVOICE PROJEK*\n\n";
        $message .= "Saudara {$pendaftar['nama_pendaftar']}, berikut adalah rincian proyek Anda:\n\n";
        $message .= "Nama Paket: {$paket['nama_paket']}\n";
        $message .= "Judul Projek: {$projek['judul_projek']}\n";
        $message .= "Harga Projek: Rp. {$harga_projek}\n";
        $message .= "DP yang sudah dibayar: Rp. {$dp_projek}\n";
        $message .= "Username: {$username}\n";
        $message .= "Password: {$password}";

        $token = "";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $pendaftar['no_pendaftar'],
                'message' => $message,
                'countryCode' => '62'
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $token
            ),
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $success = false;
        }

        curl_close($curl);

        $decoded_response = json_decode($response, true);

        if (isset($decoded_response['status']) && $decoded_response['status'] != "success") {
            $success = false;
        }

        // Jika terjadi error pada salah satu operasi, status approval tidak diubah
        if (!$success) {
            $projekModel->update($projekId, ['approval' => 0]); // Reset status approval menjadi 0
            return redirect()->to('/admin/projek/' . $pendaftarId)->with('error', 'Terjadi kesalahan. Status approval tidak diubah.');
        }

        // Jika semua operasi sukses, redirect dengan pesan sukses
        return redirect()->to('/admin/projek/' . $pendaftarId)->with('success', 'Username dan password berhasil disimpan. Projek berhasil di-' . ($action === 'approve' ? 'approve' : 'reject') . '. Email dan pesan WhatsApp berhasil terkirim.');
    }


    // public function simpanDanApprove($pendaftarId, $projekId)
    // {
    //     $pendaftarModel = new PendaftarModel();
    //     $projekModel = new ProjekModel();
    //     $paketModel = new PaketModel();

    //     $projek = $projekModel->find($projekId);
    //     if ($projek['approval'] == 1) {
    //         return redirect()->to('/admin/projek/' . $pendaftarId)->with('info', 'Projek ini sudah disetujui sebelumnya.');
    //     }

    //     // Ambil data username dan password dari request
    //     $username = $this->request->getPost('username');
    //     $password = $this->request->getPost('password');

    //     // Data untuk simpan username dan password
    //     $data = [
    //         'username' => $username,
    //         'password' => password_hash($password, PASSWORD_DEFAULT),
    //     ];

    //     // Periksa apakah data sudah ada untuk id_pendaftar
    //     $existingPendaftar = $pendaftarModel->find($pendaftarId);
    //     if ($existingPendaftar) {
    //         // Jika sudah ada, lakukan update
    //         $pendaftarModel->update($pendaftarId, $data);
    //     } else {
    //         // Jika belum ada, lakukan insert baru
    //         $data['id_pendaftar'] = $pendaftarId;
    //         $pendaftarModel->insert($data);
    //     }

    //     // Setujui projek
    //     $action = $this->request->getPost('action');
    //     $approvalStatus = 0;

    //     if ($action === 'approve') {
    //         $approvalStatus = 1;
    //     } elseif ($action === 'reject') {
    //         $approvalStatus = 2;
    //     }

    //     if (!$projekModel->update($projekId, ['approval' => $approvalStatus])) {
    //         return redirect()->to('/admin/projek/' . $pendaftarId)->with('error', 'Gagal memperbarui status projek.');
    //     }

    //     // Kirim email
    //     $projek = $projekModel->find($projekId);
    //     $pendaftar = $pendaftarModel->find($projek['id_pendaftar']);
    //     $paket = $paketModel->find($projek['id_paket']);

    //     $harga_projek = number_format($projek['harga_projek'], 0, ',', '.');
    //     $dp_projek = number_format($projek['dp_projek'], 0, ',', '.');

    //     if ($projek && $pendaftar && $paket) {
    //         $email = service('email');
    //         $email->setTo($pendaftar['email_pendaftar']);
    //         $email->setFrom('iyatapitidak@gmail.com', 'Tes OJT');
    //         $email->setSubject('INVOICE');
    //         $email->setMessage("
    //     <h1>Invoice Proyek</h1>
    //     <p>Berikut adalah rincian projek Anda:</p>
    //     <table>
    //         <tr>
    //             <th>Deskripsi</th><th>Jumlah</th>
    //         </tr>
    //         <tr>
    //             <td>Nama Paket</td><td>: {$paket['nama_paket']}</td>
    //         </tr>
    //         <tr>
    //             <td>Judul Projek</td><td>: {$projek['judul_projek']}</td>
    //         </tr>
    //         <tr>
    //             <td>Harga Projek</td><td>: Rp. {$harga_projek}</td>
    //         </tr>
    //         <tr>
    //             <td>DP yang sudah dibayar</td><td>: RP. {$dp_projek}</td>
    //         </tr>
    //         <tr>
    //             <td>Username</td><td>: {$username}</td>
    //         </tr>
    //         <tr>
    //             <td>Password</td><td>: {$password}</td>
    //         </tr>
    //     </table>
    //     ");

    //         $emailSent = $email->send();

    //         if (!$emailSent) {
    //             $data = $email->printDebugger(['header']);
    //             print_r($data);
    //             return redirect()->to('/admin/projek/' . $pendaftarId)->with('error', 'Gagal mengirim email. Projek berhasil di-' . ($action === 'approve' ? 'approve' : 'reject') . '.');
    //         }
    //     } else {
    //         return redirect()->to('/admin/projek/' . $pendaftarId)->with('error', 'Data projek, pendaftar, atau paket tidak ditemukan.');
    //     }

    //     // Kirim pesan WhatsApp
    //     $message = "*INVOICE PROJEK*\n\n";
    //     $message .= "Saudara {$pendaftar['nama_pendaftar']}, berikut adalah rincian proyek Anda:\n\n";
    //     $message .= "Nama Paket: {$paket['nama_paket']}\n";
    //     $message .= "Judul Projek: {$projek['judul_projek']}\n";
    //     $message .= "Harga Projek: Rp. {$harga_projek}\n";
    //     $message .= "DP yang sudah dibayar: Rp. {$dp_projek}\n";
    //     $message .= "Username: {$username}\n";
    //     $message .= "Password: {$password}";

    //     $token = "6uvnt+rm7NH7m3weN5zs";

    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => 'https://api.fonnte.com/send',
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => '',
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => 'POST',
    //         CURLOPT_POSTFIELDS => array(
    //             'target' => $pendaftar['no_pendaftar'],
    //             'message' => $message,
    //             'countryCode' => '62'
    //         ),
    //         CURLOPT_HTTPHEADER => array(
    //             'Authorization: ' . $token
    //         ),
    //     ));

    //     $response = curl_exec($curl);

    //     if (curl_errno($curl)) {
    //         $error_msg = curl_error($curl);
    //         curl_close($curl);
    //         return redirect()->to('/admin/projek/' . $pendaftarId)->with('error', 'Gagal mengirim WhatsApp: ' . $error_msg);
    //     }

    //     curl_close($curl);

    //     $decoded_response = json_decode($response, true);

    //     if (isset($decoded_response['status']) && $decoded_response['status'] == "success") {
    //         return redirect()->to('/admin/projek/' . $pendaftarId)->with('success', 'Username dan password berhasil disimpan. Projek berhasil di-' . ($action === 'approve' ? 'approve' : 'reject') . '. Email dan pesan WhatsApp berhasil terkirim.');
    //     } else {
    //         return redirect()->to('/admin/projek/' . $pendaftarId)->with('error', 'Gagal mengirim WhatsApp: ' . $response);
    //     }
    // }

    public function listProgrammers()
    {
        $programmerModel = new ProgrammerModel();

        $data['programmers'] = $programmerModel->getProgrammers();

        return view('admin/list_programmer', $data);
    }

    public function lihatJobdesk($id)
    {
        // Inisialisasi ProjekModel
        $projekModel = new ProjekModel();

        // Query data projek berdasarkan id_programmer yang dipilih
        $data['projek'] = $projekModel->where('id_programmer', $id)
            ->join('tb_paket', 'tb_paket.id_paket = tb_projek.id_paket')
            ->join('tb_layanan', 'tb_layanan.id_layanan = tb_paket.id_layanan')
            ->join('tb_pendaftar', 'tb_pendaftar.id_pendaftar = tb_projek.id_pendaftar')
            ->join('tb_progress', 'tb_progress.id_projek = tb_projek.id_projek', 'left')
            ->select('tb_projek.*, tb_paket.nama_paket, tb_layanan.nama_layanan, tb_pendaftar.nama_pendaftar, tb_progress.progress_projek')
            ->findAll();

        // Tampilkan view dengan data projek yang sudah diambil
        return view('admin/lihat_jobdesk', $data);
    }


    public function createProgrammer()
    {
        return view('admin/create_programmer');
    }

    public function storeProgrammer()
    {
        $rules = [
            'email' => 'required|valid_email|is_unique[users.email]',
            'username' => 'required|alpha_numeric|min_length[3]|is_unique[users.username]',
            'password' => 'required|min_length[5]',
        ];

        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembalikan dengan pesan error
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Create a new user entity
        $user = new User([
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'active'   => 1,
        ]);

        // Save the user using the UserModel
        $userModel = new UserModel();
        $userId = $userModel->insert($user);

        if (!$userId) {
            // Jika gagal menyimpan, kembali dengan error dari model
            return redirect()->back()->with('errors', $userModel->errors())->withInput();
        }

        // Langkah berikutnya untuk menambahkan user ke dalam grup dengan id 2 (programmer)
        $auth = \Config\Services::authorization();
        $auth->addUserToGroup($userId, 2);

        // Redirect ke halaman list programmer dengan pesan sukses
        return redirect()->to('/admin/list-programmer')->with('message', 'Programmer created successfully');
    }



    public function editProgrammer($id = null)
    {
        $programmerModel = new ProgrammerModel();

        $programmer = $programmerModel->find($id);

        if (!$programmer) {
            // Programmer not found, redirect or show error
            return redirect()->back()->with('error', 'Programmer not found');
        }

        // Load view for editing programmer
        $data['programmer'] = $programmer;
        return view('admin/edit_programmer', $data);
    }

    public function updateProgrammer($id = null)
    {
        $programmerModel = new ProgrammerModel();

        $programmer = $programmerModel->find($id);

        if (!$programmer) {
            // Programmer not found, redirect or show error
            return redirect()->back()->with('error', 'Programmer not found');
        }

        // Process form submission and update programmer data
        $updatedData = [
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            // Add other fields as needed
        ];

        // Update the programmer record
        $programmerModel->update($id, $updatedData);

        return redirect()->to('/admin/list-programmer')->with('message', 'Programmer updated successfully');
    }

    public function deleteProgrammer($id = null)
    {
        $programmerModel = new ProgrammerModel();

        $programmer = $programmerModel->find($id);

        if (!$programmer) {
            // Programmer not found, redirect or show error
            return redirect()->back()->with('error', 'Programmer not found');
        }

        // Delete the programmer record
        $programmerModel->delete($id);

        return redirect()->to('/admin/list-programmer')->with('message', 'Programmer deleted successfully');
    }

    public function detailPembayaran($id_pendaftar)
    {
        $projekModel = new ProjekModel();
        $pendaftarModel = new PendaftarModel();
        $pembayaranModel = new PembayaranModel();

        // Fetch project details
        $project = $projekModel->where('id_pendaftar', $id_pendaftar)->first();

        if (!$project) {
            // Handle project not found, redirect or show error
            return redirect()->back()->with('error', 'Project not found.');
        }

        // Fetch registrant name from PendaftarModel using id_pendaftar
        $pendaftar = $pendaftarModel->find($id_pendaftar);

        // Initialize totalPaid
        $totalPaid = 0;

        // Fetch payments related to the project
        $payments = $pembayaranModel->where('id_projek', $project['id_projek'])->findAll();

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
            'nama_projek' => $project['judul_projek'],
            'nama_pendaftar' => $pendaftar ? $pendaftar['nama_pendaftar'] : 'Unknown', // Handle if pendaftar not found
            'harga_projek' => $project['harga_projek'],
            'total_dibayar' => $totalPaid,
            'sisa_tagihan' => $remainingBalance,
            'status_pembayaran' => $statusPembayaran,
            'pembayaran' => $payments, // Send payments data to the view
        ];

        // Pass data to view
        return view('admin/detail_pembayaran', $data);
    }



    // public function setujuiBatalkanPembayaran($id_pembayaran)
    // {
    //     $pembayaranModel = new PembayaranModel();

    //     // Cari data pembayaran berdasarkan id_pembayaran
    //     $pembayaran = $pembayaranModel->find($id_pembayaran);

    //     if (!$pembayaran) {
    //         // Handle jika data pembayaran tidak ditemukan
    //         return redirect()->back()->with('error', 'Pembayaran not found.');
    //     }

    //     // Tentukan aksi berdasarkan nilai approval_pembayaran saat ini
    //     if ($pembayaran['approval_pembayaran'] == 0) {
    //         // Lakukan update nilai approval_pembayaran menjadi 1 (sudah disetujui)
    //         $updateData = ['approval_pembayaran' => 1];
    //         $message = 'Pembayaran successfully approved.';
    //     } elseif ($pembayaran['approval_pembayaran'] == 1) {
    //         // Lakukan update nilai approval_pembayaran menjadi 0 (belum disetujui)
    //         $updateData = ['approval_pembayaran' => 0];
    //         $message = 'Approval successfully canceled.';
    //     } else {
    //         // Handle kasus nilai approval_pembayaran yang tidak valid (opsional)
    //         return redirect()->back()->with('error', 'Invalid approval status.');
    //     }

    //     // Lakukan update dan cek hasilnya
    //     $result = $pembayaranModel->update($id_pembayaran, $updateData);

    //     if ($result) {
    //         // Redirect dengan pesan sukses
    //         return redirect()->back()->with('success', $message);
    //     } else {
    //         // Handle jika gagal melakukan update
    //         return redirect()->back()->with('error', 'Failed to update pembayaran.');
    //     }
    // }

    public function setujuiPembayaran($id_pembayaran)
    {
        $pembayaranModel = new PembayaranModel();

        // Cari data pembayaran berdasarkan id_pembayaran
        $pembayaran = $pembayaranModel->find($id_pembayaran);

        if (!$pembayaran) {
            // Handle jika data pembayaran tidak ditemukan
            return redirect()->back()->with('error', 'Pembayaran tidak ditemukan.');
        }

        if ($pembayaran['approval_pembayaran'] == 1) {
            // Jika sudah disetujui, beri pesan bahwa pembayaran sudah disetujui sebelumnya
            return redirect()->back()->with('info', 'Pembayaran sudah disetujui sebelumnya.');
        }

        // Lakukan update nilai approval_pembayaran menjadi 1 (sudah disetujui)
        $updateData = ['approval_pembayaran' => 1];
        $result = $pembayaranModel->update($id_pembayaran, $updateData);

        if ($result) {
            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Pembayaran berhasil disetujui.');
        } else {
            // Handle jika gagal melakukan update
            return redirect()->back()->with('error', 'Gagal menyetujui pembayaran.');
        }
    }

    public function batalkanPembayaran($id_pembayaran)
    {
        $pembayaranModel = new PembayaranModel();

        // Cari data pembayaran berdasarkan id_pembayaran
        $pembayaran = $pembayaranModel->find($id_pembayaran);

        if (!$pembayaran) {
            // Handle jika data pembayaran tidak ditemukan
            return redirect()->back()->with('error', 'Pembayaran tidak ditemukan.');
        }

        if ($pembayaran['approval_pembayaran'] == 0) {
            // Jika belum disetujui, beri pesan bahwa pembayaran belum disetujui sebelumnya
            return redirect()->back()->with('info', 'Pembayaran belum disetujui sebelumnya.');
        }

        // Lakukan update nilai approval_pembayaran menjadi 0 (belum disetujui)
        $updateData = ['approval_pembayaran' => 0];
        $result = $pembayaranModel->update($id_pembayaran, $updateData);

        if ($result) {
            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Pembatalan persetujuan pembayaran berhasil.');
        } else {
            // Handle jika gagal melakukan update
            return redirect()->back()->with('error', 'Gagal membatalkan persetujuan pembayaran.');
        }
    }






    // public function kirimEmail($projekId)
    // {
    //     $projekModel = new ProjekModel();
    //     $pendaftarModel = new PendaftarModel();
    //     $paketModel = new PaketModel();

    //     $projek = $projekModel->find($projekId);
    //     $pendaftar = $pendaftarModel->find($projek['id_pendaftar']);
    //     $paket = $paketModel->find($projek['id_paket']);

    //     $harga_projek = number_format($projek['harga_projek'], 0, ',', '.');
    //     $dp_projek = number_format($projek['dp_projek'], 0, ',', '.');

    //     if ($projek && $pendaftar && $paket) {
    //         $email = service('email');
    //         $email->setTo($pendaftar['email_pendaftar']);
    //         $email->setFrom('iyatapitidak@gmail.com', 'Tes OJT');
    //         $email->setSubject('INVOICE');
    //         $email->setMessage("
    //         <h1>Invoice Proyek</h1>
    //         <p>Berikut adalah rincian proyek Anda:</p>
    //         <table>
    //             <tr>
    //                 <th>Deskripsi</th><th>Jumlah</th>
    //             </tr>
    //             <tr>
    //                 <td>Nama Paket</td><td>: {$paket['nama_paket']}</td>
    //             </tr>
    //             <tr>
    //                 <td>Judul Projek</td><td>: {$projek['judul_projek']}</td>
    //             </tr>
    //             <tr>
    //                 <td>Harga Projek</td><td>Rp: . {$harga_projek}</td>
    //             </tr>
    //             <tr>
    //                 <td>DP yang harus dibayar</td><td>: RP. {$dp_projek}</td>
    //             </tr>

    //         </table>
    //         ");

    //         if ($email->send()) {
    //             return redirect()->to('/admin/projek/' . $projekId)->with('success', 'Email berhasil terkirim.');
    //         } else {
    //             $data = $email->printDebugger(['header']);
    //             print_r($data);
    //             return redirect()->to('/admin/projek/' . $projekId)->with('error', 'Gagal mengirim email.');
    //         }
    //     } else {
    //         return redirect()->to('/admin/projek/' . $projekId)->with('error', 'Data projek, pendaftar, atau paket tidak ditemukan.');
    //     }
    // }

    // public function sendWhatsAppMessage($projekId)
    // {
    //     $projekModel = new ProjekModel();
    //     $pendaftarModel = new PendaftarModel();
    //     $paketModel = new PaketModel();

    //     $projek = $projekModel->find($projekId);
    //     $pendaftar = $pendaftarModel->find($projek['id_pendaftar']);
    //     $paket = $paketModel->find($projek['id_paket']);

    //     if ($projek && $pendaftar && $paket) {
    //         $harga_projek = number_format($projek['harga_projek'], 0, ',', '.');
    //         $dp_projek = number_format($projek['dp_projek'], 0, ',', '.');

    //         $message = "*INOICE PROYEK*\n\n";
    //         $message .= "Saudara {$pendaftar['nama_pendaftar']}, berikut adalah rincian proyek Anda:\n\n";
    //         $message .= "Nama Paket: {$paket['nama_paket']}\n";
    //         $message .= "Judul Projek: {$projek['judul_projek']}\n";
    //         $message .= "Harga Projek: Rp. {$harga_projek}\n";
    //         $message .= "DP yang harus dibayar: Rp. {$dp_projek}";

    //         $token = "6uvnt+rm7NH7m3weN5z";

    //         $curl = curl_init();

    //         curl_setopt_array($curl, array(
    //             CURLOPT_URL => 'https://api.fonnte.com/send',
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_ENCODING => '',
    //             CURLOPT_MAXREDIRS => 10,
    //             CURLOPT_TIMEOUT => 0,
    //             CURLOPT_FOLLOWLOCATION => true,
    //             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //             CURLOPT_CUSTOMREQUEST => 'POST',
    //             CURLOPT_POSTFIELDS => array(
    //                 'target' => $pendaftar['no_pendaftar'],
    //                 'message' => $message,
    //                 'countryCode' => '62'
    //             ),
    //             CURLOPT_HTTPHEADER => array(
    //                 'Authorization: ' . $token
    //             ),
    //         ));

    //         $response = curl_exec($curl);

    //         if (curl_errno($curl)) {
    //             $error_msg = curl_error($curl);
    //             curl_close($curl);
    //             return redirect()->to('/admin/projek/' . $projekId)->with('error', 'Gagal mengirim WhatsApp: ' . $error_msg);
    //         }

    //         curl_close($curl);

    //         $decoded_response = json_decode($response, true);

    //         if (isset($decoded_response['status']) && $decoded_response['status'] == "success") {
    //             return redirect()->to('/admin/projek/' . $projekId)->with('success', 'Pesan WhatsApp berhasil dikirim.');
    //         } else {
    //             return redirect()->to('/admin/projek/' . $projekId)->with('error', 'Gagal mengirim WhatsApp: ' . $response);
    //         }
    //     } else {
    //         return redirect()->to('/admin/projek/' . $projekId)->with('error', 'Data projek, pendaftar, atau paket tidak ditemukan.');
    //     }
    // }

    // public function simpanUsernamePassword($pendaftarId)
    // {
    //     $pendaftarModel = new PendaftarModel();

    //     $data = [
    //         'username' => $this->request->getPost('username'),
    //         'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
    //     ];

    //     // Periksa apakah data sudah ada untuk id_pendaftar
    //     $existingPendaftar = $pendaftarModel->find($pendaftarId);
    //     if ($existingPendaftar) {
    //         // Jika sudah ada, lakukan update
    //         $pendaftarModel->update($pendaftarId, $data);
    //     } else {
    //         // Jika belum ada, lakukan insert baru
    //         $data['id_pendaftar'] = $pendaftarId;
    //         $pendaftarModel->insert($data);
    //     }

    //     return redirect()->to('/admin/pendaftar')->with('success', 'Username dan password berhasil disimpan.');
    // }

    // public function approveProjek($projekId)
    // {
    //     $projekModel = new ProjekModel();

    //     $action = $this->request->getPost('action');
    //     $approvalStatus = 0;

    //     if ($action === 'approve') {
    //         $approvalStatus = 1;
    //     } elseif ($action === 'reject') {
    //         $approvalStatus = 2;
    //     }

    //     if ($projekModel->update($projekId, ['approval' => $approvalStatus])) {
    //         return redirect()->to('/admin/projek/' . $projekId)->with('success', 'Projek berhasil di-' . ($action === 'approve' ? 'approve' : 'reject') . '.');
    //     } else {
    //         return redirect()->to('/admin/projek/' . $projekId)->with('error', 'Gagal memperbarui status projek.');
    //     }
    // }

}
