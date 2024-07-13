<?= $this->extend('pendaftar/layout/main'); ?>
<?= $this->Section('content'); ?>

<style>
    #container {
        max-width: 800px;
    }

    .progress {
        margin-bottom: 10px;
        width: 100%;
        /* Menggunakan 100% lebar untuk sesuai dengan container */
        margin-left: auto;
        margin-right: auto;
    }

    .step-container {
        position: relative;
        text-align: center;
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .step-item {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .step-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #fff;
        border: 2px solid #007bff;
        line-height: 30px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        cursor: pointer;
        /* Added cursor pointer */
    }

    .step-label {
        font-size: 14px;
        font-weight: bold;
    }

    #multi-step-form {
        overflow-x: hidden;
    }

    .text-step {
        font-size: 12px;
    }

    .step input,
    .step textarea,
    .step select {
        font-size: 12px;
        padding: 8px;
        margin-bottom: 10px;
    }

    ul {
        list-style-type: none;
    }

    .checked::before {
        content: "\2713\0020";
        /* Centang (✓) */
    }
</style>

<main id="main">

    <section id="features" class="features">
        <div class="container">
            <div id="container" class="container mt-5">
                <div class="progress px-1" style="height: 3px;">
                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="step-container d-flex justify-content-between">
                    <div class="step-item">
                        <div class="step-circle" onclick="displayStep(1)">1</div>
                        <div class="step-label">Biodata</div>
                    </div>
                    <div class="step-item">
                        <div class="step-circle" onclick="displayStep(2)">2</div>
                        <div class="step-label">Pembayaran</div>
                    </div>
                    <div class="step-item">
                        <div class="step-circle" onclick="displayStep(3)">3</div>
                        <div class="step-label">Detail</div>
                    </div>
                    <div class="step-item">
                        <div class="step-circle" onclick="displayStep(4)">4</div>
                        <div class="step-label">Peraturan dan Ketentuan</div>
                    </div>
                </div>

                <form id="multi-step-form" action="<?= base_url('/submit-pendaftaran') ?>" method="post" enctype="multipart/form-data">
                    <div class="step step-1">
                        <!-- Step 1 form fields here -->
                        <p class="card-text mb-2" style="font-size: 20;font-weight: bold;">Biodata</p>
                        <div class="mb-3">
                            <input type="text" class="form-control mb-2" id="nama" name="nama" placeholder="Nama">
                            <input type="text" class="form-control mb-2" id="alamat" name="alamat" placeholder="Alamat">
                            <input type="tel" class="form-control mb-2" id="telp" name="telp" placeholder="No Telp. (Nomer ini akan mendapatkan username dan password untuk login)">
                            <input type="email" class="form-control mb-2" id="email" name="email" placeholder="Email (Email ini akan mendapatkan username dan password untuk login)">
                        </div>
                        <button type="button" class="btn btn-primary next-step">Next</button>
                    </div>

                    <div class="step step-2" style="display: none;">
                        <!-- Step 2 form fields here -->
                        <p class="mb-2" style="font-size: 20;font-weight: bold;">Pembayaran</p>
                        <input type="hidden" name="id_paket" value="<?= $id_paket ?>">
                        <p class="text-step mb-2"><?= isset($nama_paket) ? $nama_paket : ''; ?></p>
                        <p class="text-step mb-2" style="font-weight: bold;"><?= isset($detail_paket) ? $detail_paket : ''; ?></p>
                        <div class="mb-3">
                            <input type="number" class="form-control mb-2" id="harga" name="harga" placeholder="Harga">
                            <p class="text-step mb-2" style="font-weight: bold;">*Untuk harga hubungi ke nomor kantor 081312212015, setelah itu isi harga di atas. Jangan dibiarkan 0 !</p>
                            <p class="text-step mb-2">BUKTI TRANSFER PEMBAYARAN</p>
                            <div class="mb-2">
                                <input class="form-control mb-2" type="file" id="uploadBukti" name="uploadBukti">
                            </div>
                            <input type="number" class="form-control mb-2" id="dp" name="dp" placeholder="Nominal pembayaran DP">
                        </div>
                        <button type="button" class="btn btn-primary prev-step">Previous</button>
                        <button type="button" class="btn btn-primary next-step">Next</button>
                    </div>

                    <div class="step step-3" style="display: none;">
                        <!-- Step 3 form fields here -->
                        <p class="mb-2" style="font-size: 20;font-weight: bold;">Detail</p>
                        <div class="mb-3">
                            <textarea type="text" class="form-control mb-2" id="judul" name="judul" placeholder="Judul"></textarea>
                            <p class="card-text mb-2">Upload Proposal yang telah disetujui (jika ada)</p>
                            <div class="mb-2">
                                <label for="formFile" class="form-label" style="font-size: 11px;">File type (docx, pdf, excel, atau rar jika lebih dari satu)</label>
                                <input class="form-control mb-2" type="file" id="uploadFile" name="uploadFile">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary prev-step">Previous</button>
                        <button type="button" class="btn btn-primary next-step">Next</button>
                    </div>

                    <div class="step step-4" style="display: none;">
                        <!-- Step 4 form fields here -->
                        <p class="mb-2" style="font-size: 20;font-weight: bold;">Peraturan dan Ketentuan</p>
                        <div class="mb-3">
                            <ul style="text-align: justify;">
                                <li class="checked mb-1" style="font-size: 14px;">Dengan klik SETUJU maka pendaftar telah menandatangani isi dalam peraturan ini dan tunduk terhadap peraturan yang berlaku di NAMA PERUSAHAAN. (Peraturan untuk Semua Jenis Pendaftaran)</li>
                                <li class="checked mb-1" style="font-size: 14px;">Membebaskan NAMA PERUSAHAAN segala tuntutan hukum terhadap penyalahgunaan layanan atau produk NAMA PERUSAHAAN yang dilakukan customer. (Peraturan untuk Semua Jenis Pendaftaran)</li>
                                <li class="checked mb-1" style="font-size: 14px;">Gratis Revisi 5x untuk LAPORAN, REVISI PROGRAM/SOFTWARE setelah Berita Acara Pengambilan (BAP) atau SAAT PROGRAM/ALAT DIKERJAKAN akan dikenakan BIAYA TAMBAHAN. (Peraturan untuk Semua Jenis Pendaftaran)</li>
                                <li class="checked mb-1" style="font-size: 14px;">Paket Pendaftaran atau uang yang masuk TIDAK DAPAT DICAIRKAN/DIKEMBALIKAN/DIMINTA dengan alasan apapun. (Peraturan untuk Semua Jenis Pendaftaran)</li>
                                <li class="checked mb-1" style="font-size: 14px;">Paket pendaftaran ini HANGUS apabila pendaftar tidak memberikan kabar progres penelitiannya ke NAMA PERUSAHAAN selama maksimal 1 bulan (Khusus Pendaftar Paket IT Research/Paket C/Paket A)</li>
                                <li class="checked mb-1" style="font-size: 14px;">Prosedur bimbingan pendaftar paket C yang diberikan adalah pendaftar mengerjakan sambil di bimbing oleh NAMA PERUSAHAAN dalam bentuk materi konsultasi berupa konsep, praktek dan contoh perbab laporan serta source code program dengan durasi konsultasi maksimal 2 jam/hari kerja kantor setiap hari Senin s/d Jum'at jam 08.00 - 16.00 dan Sabtu 08.00-13.00. Sedangkan paket A tanpa program, peraturan poin ini khusus untuk Paket IT Research. Jika pendaftar membatalkan pendaftaran atau tidak melanjutkan atau nomer telepon tidak dapat dihubungi/tidak membalas pesan/telepon sampai lebih dari 1 bulan dari NAMA PERUSAHAAN, maka pendaftaran dan uang masuk HANGUS. (Peraturan untuk Semua Jenis Pendaftaran)</li>
                                <li class="checked mb-1" style="font-size: 14px;">Apabila riset atau revisi yang diminta pendaftar mempunyai tingkat kesulitan tinggi, maka prosesnya akan memakan waktu yang lebih lama. Oleh karena itu NAMA PERUSAHAAN tidak bertanggung jawab atas kerugian yang dialami pendaftar karena batas masa studi habis atau batas berlakunya SK judul telah habis. (Peraturan untuk Paket IT Research)</li>
                                <li class="checked mb-1" style="font-size: 14px;">Paket pendaftaran tidak termasuk jurnal, abstrak, daftar isi, data penelitian dari tempat yang di teliti, alat, excel dan slide power point. (Peraturan untuk Paket IT Research)</li>
                                <li class="checked mb-1" style="font-size: 14px;">NAMA PERUSAHAAN TIDAK BERTANGGUNGJAWAB atas: 1. Kerugian dialami pendaftar dikarenakan masa studi habis; 2. Program/alat/laporan yang tidak diambil melebihi 2 minggu dari tanggal selesai sehingga terjadinya ERROR/Kendala/Ketidaksesuaian BUKAN TANGGUNGJAWAB KAMI; 3. Program/alat/laporan yang tidak diambil melebihi 1 Bulan dari tanggal selesai, kami anggap sudah selesai mengerjakan LAPORAN/PROGRAM tersebut dan KAMI TIDAK MENERIMA COMPLAIN APAPUN serta PENDAFTARAN kami nyatakan HANGUS. (Peraturan untuk Paket IT Research)</li>
                                <li class="checked mb-1" style="font-size: 14px;">Apabila terjadi protes atau gangguan di luar tugas NAMA PERUSAHAAN maka sepenuhnya di tanggung oleh pendaftar. (Peraturan untuk Semua Jenis Pendaftaran)</li>
                                <li class="checked mb-1" style="font-size: 14px;">Setiap pendaftar paket A dan C apabila mengajak temannya yang mau daftar akan diberikan potongan harga sebesar 100 rb per 1 orang pendaftar (potongan harga tidak berlaku jika yang mengajak sudah selesai). (Peraturan untuk Paket IT Research)</li>
                            </ul>

                        </div>
                        <button type="button" class="btn btn-primary prev-step">Previous</button>
                        <button type="submit" class="btn btn-success">Setuju</button>
                    </div>
                </form>
            </div>
        </div>
    </section><!-- End Features Section -->

</main><!-- End #main -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var currentStep = 1;
    var updateProgressBar;

    function displayStep(stepNumber) {
        if (stepNumber >= 1 && stepNumber <= 4) {
            $(".step-" + currentStep).hide();
            $(".step-" + stepNumber).show();
            currentStep = stepNumber;
            updateProgressBar();
        }
    }

    $(document).ready(function() {
        $('#multi-step-form').find('.step').slice(1).hide();

        $(".next-step").click(function() {
            if (currentStep < 4) {
                $(".step-" + currentStep).addClass("animate__animated animate__fadeOutLeft");
                currentStep++;
                setTimeout(function() {
                    $(".step").removeClass("animate__animated animate__fadeOutLeft").hide();
                    $(".step-" + currentStep).show().addClass("animate__animated animate__fadeInRight");
                    updateProgressBar();
                }, 500);
            }
        });

        $(".prev-step").click(function() {
            if (currentStep > 1) {
                $(".step-" + currentStep).addClass("animate__animated animate__fadeOutRight");
                currentStep--;
                setTimeout(function() {
                    $(".step").removeClass("animate__animated animate__fadeOutRight").hide();
                    $(".step-" + currentStep).show().addClass("animate__animated animate__fadeInLeft");
                    updateProgressBar();
                }, 500);
            }
        });

        updateProgressBar = function() {
            var progressPercentage = ((currentStep - 1) / 3) * 100;
            $(".progress-bar").css("width", progressPercentage + "%");
        }
    });
</script>

<?= $this->endSection('content') ?>;