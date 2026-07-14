<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::process');
$routes->get('logout', 'Auth::logout');

// Halaman Publik per Posyandu
$routes->get('posyandu-(:num)',          'Home::posyanduDetail/$1');
$routes->get('posyandu-(:num)/balita',   'Home::posyanduBalita/$1');
$routes->get('posyandu-(:num)/ibu-hamil','Home::posyanduIbuHamil/$1');

// Halaman Publik Konten
$routes->get('berita',             'Home::berita');
$routes->get('berita/(:segment)',   'Home::beritaDetail/$1');
$routes->get('galeri',             'Home::galeri');
$routes->get('infografis',         'Home::infografis');
$routes->get('download',           'Home::download');
$routes->get('profil',             'Home::profil');
$routes->get('kontak',             'Home::kontak');
$routes->post('kontak',            'Home::kontakStore');
$routes->get('halaman/(:segment)', 'Home::halaman/$1');

$routes->group('api/admin', static function ($routes) {
    $routes->get('dashboard', 'Api\DashboardController::index');
    
    // Manajemen Posyandu
    $routes->get('posyandu', 'Api\PosyanduController::index');
    $routes->post('posyandu', 'Api\PosyanduController::store');
    $routes->get('posyandu/(:num)', 'Api\PosyanduController::show/$1');
    $routes->put('posyandu/(:num)', 'Api\PosyanduController::update/$1');
    $routes->post('posyandu/(:num)', 'Api\PosyanduController::update/$1'); // Use POST for forms with files
    $routes->delete('posyandu/(:num)', 'Api\PosyanduController::delete/$1');

    // Data Balita
    $routes->get('balita', 'Api\BalitaController::index');
    $routes->post('balita', 'Api\BalitaController::store');
    $routes->get('balita/(:num)', 'Api\BalitaController::show/$1');
    $routes->put('balita/(:num)', 'Api\BalitaController::update/$1');
    $routes->delete('balita/(:num)', 'Api\BalitaController::delete/$1');

    // Data Pengukuran
    $routes->get('pengukuran', 'Api\PengukuranController::index');
    $routes->post('pengukuran', 'Api\PengukuranController::store');
    $routes->get('pengukuran/(:num)', 'Api\PengukuranController::show/$1');
    $routes->put('pengukuran/(:num)', 'Api\PengukuranController::update/$1');
    $routes->delete('pengukuran/(:num)', 'Api\PengukuranController::delete/$1');

    // Data Ibu Hamil
    $routes->get('ibu_hamil', 'Api\IbuHamilController::index');
    $routes->post('ibu_hamil', 'Api\IbuHamilController::store');
    $routes->get('ibu_hamil/(:num)', 'Api\IbuHamilController::show/$1');
    $routes->put('ibu_hamil/(:num)', 'Api\IbuHamilController::update/$1');
    $routes->delete('ibu_hamil/(:num)', 'Api\IbuHamilController::delete/$1');

    // Data Remaja
    $routes->get('remaja', 'Api\RemajaController::index');
    $routes->post('remaja', 'Api\RemajaController::store');
    $routes->get('remaja/(:num)', 'Api\RemajaController::show/$1');
    $routes->put('remaja/(:num)', 'Api\RemajaController::update/$1');
    $routes->delete('remaja/(:num)', 'Api\RemajaController::delete/$1');

    // Data Usia Produktif
    $routes->get('usia_produktif', 'Api\UsiaProduktifController::index');
    $routes->post('usia_produktif', 'Api\UsiaProduktifController::store');
    $routes->get('usia_produktif/(:num)', 'Api\UsiaProduktifController::show/$1');
    $routes->put('usia_produktif/(:num)', 'Api\UsiaProduktifController::update/$1');
    $routes->delete('usia_produktif/(:num)', 'Api\UsiaProduktifController::delete/$1');

    // Data Lansia
    $routes->get('lansia', 'Api\LansiaController::index');
    $routes->post('lansia', 'Api\LansiaController::store');
    $routes->post('lansia/hitung_zscore', 'Api\LansiaController::hitung_zscore');
    $routes->get('lansia/(:num)', 'Api\LansiaController::show/$1');
    $routes->put('lansia/(:num)', 'Api\LansiaController::update/$1');
    $routes->delete('lansia/(:num)', 'Api\LansiaController::delete/$1');

    // Berita
    $routes->get('berita', 'Api\BeritaController::index');
    $routes->post('berita', 'Api\BeritaController::store');
    $routes->get('berita/(:num)', 'Api\BeritaController::show/$1');
    $routes->post('berita/(:num)', 'Api\BeritaController::update/$1'); // POST for multipart/form-data
    $routes->delete('berita/(:num)', 'Api\BeritaController::delete/$1');

    // Galeri
    $routes->get('galeri', 'Api\GaleriController::index');
    $routes->post('galeri', 'Api\GaleriController::store');
    $routes->get('galeri/(:num)', 'Api\GaleriController::show/$1');
    $routes->post('galeri/(:num)', 'Api\GaleriController::update/$1');
    $routes->delete('galeri/(:num)', 'Api\GaleriController::delete/$1');

    // Infografis
    $routes->get('infografis', 'Api\InfografisController::index');
    $routes->post('infografis', 'Api\InfografisController::store');
    $routes->get('infografis/(:num)', 'Api\InfografisController::show/$1');
    $routes->post('infografis/(:num)', 'Api\InfografisController::update/$1');
    $routes->delete('infografis/(:num)', 'Api\InfografisController::delete/$1');

    // Dokumen Unduhan
    $routes->get('dokumen', 'Api\DownloadController::index');
    $routes->post('dokumen', 'Api\DownloadController::store');
    $routes->get('dokumen/(:num)', 'Api\DownloadController::show/$1');
    $routes->post('dokumen/(:num)', 'Api\DownloadController::update/$1');
    $routes->delete('dokumen/(:num)', 'Api\DownloadController::delete/$1');

    // Halaman Statis
    $routes->get('halaman_statis', 'Api\HalamanStatisController::index');
    $routes->post('halaman_statis', 'Api\HalamanStatisController::store');
    $routes->get('halaman_statis/(:num)', 'Api\HalamanStatisController::show/$1');
    $routes->put('halaman_statis/(:num)', 'Api\HalamanStatisController::update/$1');
    $routes->delete('halaman_statis/(:num)', 'Api\HalamanStatisController::delete/$1');

    // Laporan
    $routes->get('laporan/cetak_balita', 'Api\LaporanController::cetak_balita');
    $routes->get('laporan/cetak_pengukuran', 'Api\LaporanController::cetak_pengukuran');
    $routes->get('laporan/cetak_ibu_hamil', 'Api\LaporanController::cetak_ibu_hamil');
    $routes->get('laporan/cetak_remaja', 'Api\LaporanController::cetak_remaja');
    $routes->get('laporan/cetak_usia_produktif', 'Api\LaporanController::cetak_usia_produktif');
    $routes->get('laporan/cetak_lansia', 'Api\LaporanController::cetak_lansia');
    // Pesan Masuk
    $routes->get('pesan', 'Api\KontakPesanController::index');
    $routes->get('pesan/(:num)', 'Api\KontakPesanController::show/$1');
    $routes->put('pesan/tanda_baca/(:num)', 'Api\KontakPesanController::tandaiBaca/$1');
    $routes->delete('pesan/(:num)', 'Api\KontakPesanController::delete/$1');

    // Manajemen User
    $routes->get('user', 'Api\UserController::index');
    $routes->post('user', 'Api\UserController::store');
    $routes->get('user/(:num)', 'Api\UserController::show/$1');
    $routes->put('user/(:num)', 'Api\UserController::update/$1');
    $routes->delete('user/(:num)', 'Api\UserController::delete/$1');
    $routes->put('user/reset_password/(:num)', 'Api\UserController::resetPassword/$1');

    // Dokumen
    $routes->get('dokumen', 'Api\DownloadController::index');
    $routes->post('dokumen', 'Api\DownloadController::store');
    $routes->delete('dokumen/(:num)', 'Api\DownloadController::delete/$1');

        // Laporan
    $routes->get('laporan/cetak_balita', 'Api\LaporanController::cetak_balita');
    $routes->get('laporan/cetak_lansia', 'Api\LaporanController::cetak_lansia');
    $routes->get('laporan/cetak_pengukuran', 'Api\LaporanController::cetak_pengukuran');
    // Pesan
    $routes->get('pesan', 'Api\KontakPesanController::index');
    $routes->get('pesan/(:num)', 'Api\KontakPesanController::show/$1');
    $routes->put('pesan/(:num)', 'Api\KontakPesanController::update/$1');
    $routes->delete('pesan/(:num)', 'Api\KontakPesanController::delete/$1');

    // Cetak Laporan
    $routes->get('laporan', 'Api\LaporanController::index');
    $routes->get('laporan/cetak_balita', 'Api\LaporanController::cetak_balita');
    $routes->get('laporan/cetak_pengukuran', 'Api\LaporanController::cetak_pengukuran');
    $routes->get('laporan/cetak_lansia', 'Api\LaporanController::cetak_lansia');
});

$routes->setAutoRoute(true);





