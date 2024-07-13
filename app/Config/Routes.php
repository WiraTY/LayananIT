<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/layanan', 'Home::index');
$routes->get('/layanan/paket/(:num)', 'Home::paket/$1');
$routes->get('/pendaftaran/(:num)', 'Home::pendaftaran/$1');
$routes->get('/profil-perusahaan', 'Home::profilPerusahaan');
$routes->get('/struktur-perusahaan', 'Home::strukturPerusahaan');
$routes->get('/tata-kelola-perusahaan', 'Home::tataKelolaPerusahaan');
$routes->get('/visi-misi', 'Home::visiMisi');
$routes->get('/link-zoom', 'Home::linkZoom');


$routes->post('/submit-pendaftaran', 'Home::submitPendaftaran');

$routes->get('/pendaftar/login', 'Home::login');
$routes->post('processLogin', 'Home::processLogin');
$routes->group('pendaftar', ['filter' => 'auth'], function ($routes) {
    $routes->get('progress', 'Home::progress');
    $routes->get('progress-detail/(:num)', 'Home::progressDetail/$1');
    $routes->get('detail-pembayaran/(:num)', 'Home::detailPembayaran/$1');
    $routes->get('tambah-pembayaran/(:num)', 'Home::tambahRiwayatPembayaranForm/$1');
    $routes->post('tambah-riwayat-pembayaran/(:num)', 'Home::tambahRiwayatPembayaran/$1');
    $routes->get('logout', 'Home::logout');
    $routes->get('profile', 'Home::profile');
    $routes->post('updateProfile', 'Home::updateProfile');
});


$routes->group('programmer', ['filter' => 'role:programmer'], function ($routes) {
    $routes->get('index', 'ProgrammerController::index');
    $routes->get('progress/(:num)', 'ProgrammerController::progress/$1');
    $routes->post('simpanProgress/(:num)', 'ProgrammerController::simpanProgress/$1');
    $routes->post('uploadProgressFile/(:num)', 'ProgrammerController::uploadProgressFile/$1');
    $routes->post('updateDokumentasi/(:num)', 'ProgrammerController::updateDokumentasi/$1');
    $routes->post('deleteDokumentasi/(:num)', 'ProgrammerController::deleteDokumentasi/$1');
});



$routes->group('admin', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('index', 'AdminController::index');
    $routes->get('pendaftar', 'AdminController::index');
    $routes->get('pendaftar/tambah', 'AdminController::tambah_pendaftar');
    $routes->post('pendaftar/simpan', 'AdminController::simpan');
    $routes->get('pendaftar/edit/(:segment)', 'AdminController::edit/$1');
    $routes->post('pendaftar/update/(:segment)', 'AdminController::update/$1');
    $routes->get('pendaftar/delete/(:segment)', 'AdminController::delete/$1');
    $routes->get('projek/(:segment)', 'AdminController::detail_projek/$1');
    $routes->post('editHargaDP/(:num)', 'AdminController::editHargaDP/$1');
    $routes->post('assignProgrammer', 'AdminController::assignProgrammer');
    $routes->post('uploadBuktiPembayaran', 'AdminController::uploadBuktiPembayaran');
    $routes->post('deleteBuktiPembayaran/(:num)', 'AdminController::deleteBuktiPembayaran/$1');
    $routes->post('uploadFileProjek', 'AdminController::uploadFileProjek');
    $routes->post('deleteFileProjek/(:num)', 'AdminController::deleteFileProjek/$1');
    $routes->post('pendaftar/simpan-dan-approve/(:num)/(:num)', 'AdminController::simpanDanApprove/$1/$2');
    $routes->get('list-programmer', 'AdminController::listProgrammers');
    $routes->get('lihat-jobdesk/(:num)', 'AdminController::lihatJobdesk/$1');
    $routes->get('create-programmer', 'AdminController::createProgrammer');
    $routes->post('store-programmer', 'AdminController::storeProgrammer');
    $routes->get('edit-programmer/(:num)', 'AdminController::editProgrammer/$1');
    $routes->post('update-programmer/(:num)', 'AdminController::updateProgrammer/$1');
    $routes->get('delete-programmer/(:num)', 'AdminController::deleteProgrammer/$1');
    $routes->get('detail-pembayaran/(:num)', 'AdminController::detailPembayaran/$1');
    $routes->get('setujui-pembayaran/(:num)', 'AdminController::setujuiPembayaran/$1');
    $routes->get('batalkan-pembayaran/(:num)', 'AdminController::batalkanPembayaran/$1');

    $routes->post('editDetailHargaDP/(:num)', 'AdminController::editDetailHargaDP/$1');
});

$routes->post('kirimEmail/(:num)', 'AdminController::kirimEmail/$1');
$routes->post('sendWhatsAppMessage/(:num)', 'AdminController::sendWhatsAppMessage/$1');
$routes->post('approveProjek/(:num)', 'AdminController::approveProjek/$1');
$routes->post('simpanUsernamePassword/(:num)', 'AdminController::simpanUsernamePassword/$1');
