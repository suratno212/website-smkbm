<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

// Public Routes
$routes->get('pengumuman', 'Home::pengumuman');
$routes->get('jadwal-ujian', 'Home::jadwalUjian');
$routes->get('download-pengumuman/(:num)', 'Home::downloadPengumuman/$1');

// PPDB Routes (Public)
// $routes->post('ppdb/daftar', 'Ppdb::daftar');
$routes->get('ppdb/sukses', 'Ppdb::sukses');
$routes->get('ppdb/cek-status', 'Ppdb::cekStatus');
$routes->post('ppdb/cek-status', 'Ppdb::cekStatusPost');

// Auth Routes
$routes->get('auth', 'Auth::index');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');

// SPMB Routes (Public)
$routes->get('spmb', 'Spmb::index');
$routes->post('spmb/daftar', 'Spmb::daftar');
$routes->get('spmb/sukses', 'Spmb::sukses');
$routes->get('spmb/cek-status', 'Spmb::cekStatus');
$routes->post('spmb/cek-status', 'Spmb::cekStatusPost');

// Admin Routes
$routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->get('dashboard', 'Admin\Dashboard::index');
    $routes->get('dashboard/analytics', 'Admin\Dashboard::getAnalyticsDataAjax');
    
    // Export Routes
    $routes->get('export', 'Admin\Export::index');
    $routes->get('export/siswa/(:any)', 'Admin\Export::siswa/$1');
    $routes->get('export/guru/(:any)', 'Admin\Export::guru/$1');
    $routes->get('export/jadwal/(:any)', 'Admin\Export::jadwal/$1');
    $routes->get('export/absensi/(:any)', 'Admin\Export::absensi/$1');
    $routes->get('export/nilai/(:any)', 'Admin\Export::nilai/$1');
    $routes->get('export/all', 'Admin\Export::all');
    
    // Siswa Routes
    $routes->get('siswa', 'Admin\Siswa::index');
    $routes->get('siswa/create', 'Admin\Siswa::create');
    $routes->post('siswa/store', 'Admin\Siswa::store');
    $routes->get('siswa/edit/(:num)', 'Admin\Siswa::edit/$1');
    $routes->post('siswa/update/(:num)', 'Admin\Siswa::update/$1');
    $routes->post('siswa/delete/(:num)', 'Admin\Siswa::delete/$1');
    $routes->get('siswa/cetak', 'Admin\Siswa::cetak');
    
    // Guru Routes
    $routes->get('guru', 'Admin\Guru::index');
    $routes->get('guru/create', 'Admin\Guru::create');
    $routes->post('guru/store', 'Admin\Guru::store');
    $routes->get('guru/edit/(:num)', 'Admin\Guru::edit/$1');
    $routes->post('guru/update/(:num)', 'Admin\Guru::update/$1');
    $routes->post('guru/delete/(:num)', 'Admin\Guru::delete/$1');
    
    // Wali Kelas Routes
    $routes->get('wali_kelas', 'Admin\WaliKelas::index');
    $routes->get('wali_kelas/create', 'Admin\WaliKelas::create');
    $routes->post('wali_kelas/store', 'Admin\WaliKelas::store');
    $routes->get('wali_kelas/edit/(:num)', 'Admin\WaliKelas::edit/$1');
    $routes->post('wali_kelas/update/(:num)', 'Admin\WaliKelas::update/$1');
    $routes->post('wali_kelas/delete/(:num)', 'Admin\WaliKelas::delete/$1');
    
    // Jadwal Routes
    $routes->get('jadwal', 'Admin\Jadwal::index');
    $routes->get('jadwal/create', 'Admin\Jadwal::create');
    $routes->post('jadwal/store', 'Admin\Jadwal::store');
    $routes->get('jadwal/edit/(:num)', 'Admin\Jadwal::edit/$1');
    $routes->post('jadwal/update/(:num)', 'Admin\Jadwal::update/$1');
    $routes->post('jadwal/delete/(:num)', 'Admin\Jadwal::delete/$1');
    $routes->get('jadwal/cetak', 'Admin\Jadwal::cetak');
    $routes->post('admin/jadwal/generatePertemuanOtomatis', 'Admin\\Jadwal::generatePertemuanOtomatis');
    
    // Pengumuman Routes
    $routes->get('pengumuman', 'Admin\Pengumuman::index');
    $routes->get('pengumuman/create', 'Admin\Pengumuman::create');
    $routes->post('pengumuman/store', 'Admin\Pengumuman::store');
    $routes->get('pengumuman/edit/(:num)', 'Admin\Pengumuman::edit/$1');
    $routes->post('pengumuman/update/(:num)', 'Admin\Pengumuman::update/$1');
    $routes->post('pengumuman/delete/(:num)', 'Admin\Pengumuman::delete/$1');
    $routes->get('pengumuman/download/(:num)', 'Admin\Pengumuman::download/$1');
    
    // Master Data Routes
    $routes->get('master', 'Admin\Master::index');
    $routes->get('master/jurusan', 'Admin\Master::jurusan');
    $routes->get('master/kelas', 'Admin\Master::kelas');
    $routes->get('master/tahun_akademik', 'Admin\Master::tahunAkademik');
    $routes->get('master/mapel', 'Admin\Master::mapel');
    $routes->get('master/agama', 'Admin\Agama::index');
    $routes->get('master/agama/create', 'Admin\Agama::create');
    $routes->post('master/agama/store', 'Admin\Agama::store');
    $routes->get('master/agama/edit/(:num)', 'Admin\Agama::edit/$1');
    $routes->post('master/agama/update/(:num)', 'Admin\Agama::update/$1');
    $routes->post('master/agama/delete/(:num)', 'Admin\Agama::delete/$1');
    $routes->get('master/jurusan/create', 'Admin\Master::jurusanCreate');
    $routes->get('master/kelas/create', 'Admin\Master::kelasCreate');
    $routes->get('master/mapel/create', 'Admin\Master::mapelCreate');
    $routes->get('master/tahun_akademik/create', 'Admin\Master::tahunAkademikCreate');
    $routes->get('master/jurusan/edit/(:num)', 'Admin\Master::jurusanEdit/$1');
    $routes->post('master/jurusan/update/(:num)', 'Admin\Master::jurusanUpdate/$1');
    $routes->post('master/jurusan/delete/(:num)', 'Admin\Master::jurusanDelete/$1');
    $routes->get('master/kelas/edit/(:num)', 'Admin\Master::kelasEdit/$1');
    $routes->post('master/kelas/update/(:num)', 'Admin\Master::kelasUpdate/$1');
    $routes->post('master/kelas/delete/(:num)', 'Admin\Master::kelasDelete/$1');
    $routes->get('master/tahun_akademik/edit/(:num)', 'Admin\Master::tahunAkademikEdit/$1');
    $routes->post('master/tahun_akademik/update/(:num)', 'Admin\Master::tahunAkademikUpdate/$1');
    $routes->post('master/tahun_akademik/delete/(:num)', 'Admin\Master::tahunAkademikDelete/$1');
    $routes->get('master/mapel/edit/(:num)', 'Admin\Master::mapelEdit/$1');
    $routes->post('master/jurusan/store', 'Admin\Master::jurusanStore');
    $routes->post('master/kelas/store', 'Admin\Master::kelasStore');
    $routes->post('master/mapel/store', 'Admin\Master::mapelStore');
    $routes->post('master/tahun_akademik/store', 'Admin\Master::tahunAkademikStore');
    $routes->post('master/mapel/delete/(:num)', 'Admin\Master::mapelDelete/$1');
    $routes->post('master/mapel/update/(:num)', 'Admin\Master::mapelUpdate/$1');
    $routes->post('master/kelas/mass_delete', 'Admin\Master::mass_delete');
    $routes->post('master/mapel/mass_delete', 'Admin\Master::mapelMassDelete');
    $routes->get('master/ekstrakurikuler', 'Admin\Master::ekstrakurikuler');
    $routes->get('master/ekstrakurikuler/create', 'Admin\Master::ekstrakurikulerCreate');
    $routes->post('master/ekstrakurikuler/store', 'Admin\Master::ekstrakurikulerStore');
    $routes->get('master/ekstrakurikuler/edit/(:num)', 'Admin\Master::ekstrakurikulerEdit/$1');
    $routes->post('master/ekstrakurikuler/update/(:num)', 'Admin\Master::ekstrakurikulerUpdate/$1');
    $routes->get('master/ekstrakurikuler/delete/(:num)', 'Admin\Master::ekstrakurikulerDelete/$1');
    
    // PPDB Routes
    $routes->get('ppdb', 'Admin\PPDB::index');
    $routes->get('ppdb/create', 'Admin\PPDB::create');
    $routes->post('ppdb/store', 'Admin\PPDB::store');
    $routes->get('ppdb/edit/(:num)', 'Admin\PPDB::edit/$1');
    $routes->post('ppdb/update/(:num)', 'Admin\PPDB::update/$1');
    $routes->post('ppdb/delete/(:num)', 'Admin\PPDB::delete/$1');
    $routes->get('ppdb/(:num)', 'Admin\Ppdb::show/$1');
    $routes->get('ppdb/terima/(:num)', 'Admin\Ppdb::terima/$1');
    $routes->get('ppdb/tolak/(:num)', 'Admin\Ppdb::tolak/$1');
    $routes->get('ppdb/bersyarat/(:num)', 'Admin\Ppdb::bersyarat/$1');
    
    // Users Routes
    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/create', 'Admin\Users::create');
    $routes->post('users/store', 'Admin\Users::store');
    $routes->get('users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\Users::update/$1');
    $routes->post('users/delete/(:num)', 'Admin\Users::delete/$1');
    $routes->post('users/mass_delete', 'Admin\Users::mass_delete');
    
    // Profile Routes
    $routes->get('profile', 'Admin\Profile::index');
    $routes->post('profile/update', 'Admin\Profile::update');
    $routes->post('profile/change_password', 'Admin\Profile::changePassword');

    // SPMB Admin Routes
    $routes->get('spmb', 'Admin\Spmb::index');
    $routes->get('spmb/(:num)', 'Admin\Spmb::show/$1');
    $routes->get('spmb/terima/(:num)', 'Admin\Spmb::terima/$1');
    $routes->get('spmb/tolak/(:num)', 'Admin\Spmb::tolak/$1');
    $routes->get('spmb/bersyarat/(:num)', 'Admin\Spmb::bersyarat/$1');
    $routes->post('spmb/delete/(:num)', 'Admin\Spmb::delete/$1');
    $routes->get('spmb/print', 'Admin\Spmb::print');

    // Kelas Routes
    $routes->get('kelas', 'Admin\Kelas::index');
    $routes->get('kelas/create', 'Admin\Kelas::create');
    $routes->post('kelas/store', 'Admin\Kelas::store');
    $routes->get('kelas/edit/(:num)', 'Admin\Kelas::edit/$1');
    $routes->post('kelas/update/(:num)', 'Admin\Kelas::update/$1');
    $routes->post('kelas/delete/(:num)', 'Admin\Kelas::delete/$1');

    // Pengaturan Routes
    $routes->get('pengaturan', 'Admin\Pengaturan::index');
    $routes->get('pengaturan/profil', 'Admin\Pengaturan::profil');
    $routes->post('pengaturan/update-profil', 'Admin\Pengaturan::updateProfil');
    $routes->get('pengaturan/umum', 'Admin\Pengaturan::pengaturanUmum');
    $routes->post('pengaturan/update-umum', 'Admin\Pengaturan::updatePengaturanUmum');
    $routes->get('pengaturan/backup', 'Admin\Pengaturan::backup');
    $routes->post('pengaturan/create-backup', 'Admin\Pengaturan::createBackup');
    $routes->get('pengaturan/download/(:any)', 'Admin\Pengaturan::downloadBackup/$1');
    $routes->get('pengaturan/delete-backup/(:any)', 'Admin\Pengaturan::deleteBackup/$1');
    $routes->get('pengaturan/logs', 'Admin\Pengaturan::logs');
    $routes->get('pengaturan/view-log/(:any)', 'Admin\Pengaturan::viewLog/$1');
    $routes->get('pengaturan/clear-log/(:any)', 'Admin\Pengaturan::clearLog/$1');

    // Absensi Routes
    $routes->get('absensi', 'Admin\Absensi::index');
    $routes->get('absensi/input', 'Admin\Absensi::input');
    $routes->post('absensi/store', 'Admin\Absensi::store');
    $routes->get('absensi/rekap', 'Admin\Absensi::rekap');
    $routes->get('absensi/rekap-siswa', 'Admin\Absensi::rekapSiswa');
    $routes->get('absensi/cetak-rekap-siswa', 'Admin\Absensi::cetakRekapSiswa');
    $routes->get('absensi/rekap-guru', 'Admin\Absensi::rekapGuru');
    $routes->get('absensi/cetak-rekap-guru', 'Admin\Absensi::cetakRekapGuru');
});

// Guru Routes
$routes->group('guru', ['filter' => 'auth:guru'], function($routes) {
    $routes->get('/', 'Guru\Dashboard::index');
    $routes->get('dashboard', 'Guru\Dashboard::index');
    
    // Absensi Routes
    $routes->get('absensi', 'Guru\Absensi::index');
    $routes->get('absensi/input', 'Guru\Absensi::input');
    $routes->post('absensi/store', 'Guru\Absensi::store');
    $routes->get('absensi/rekap', 'Guru\Absensi::rekap');
    
    // Absensi Guru Routes
    $routes->get('absensi-guru', 'Guru\AbsensiGuru::index');
    $routes->get('absensi-guru/create', 'Guru\AbsensiGuru::create');
    $routes->post('absensi-guru/store', 'Guru\AbsensiGuru::store');
    
    // Nilai Routes
    $routes->get('nilai', 'Guru\Nilai::index');
    $routes->get('nilai/input', 'Guru\Nilai::input');
    $routes->post('nilai/store', 'Guru\Nilai::store');
    $routes->get('nilai/rekap', 'Guru\Nilai::rekap');
    $routes->get('nilai/cetak', 'Guru\Nilai::cetak');
    
    // Pengumuman Routes
    $routes->get('pengumuman', 'Guru\Pengumuman::index');
    $routes->get('pengumuman/jadwal-ujian', 'Guru\Pengumuman::jadwalUjian');
    $routes->get('pengumuman/download/(:num)', 'Guru\Pengumuman::download/$1');

    // E-Learning Guru
    $routes->get('materitugas', 'Guru\MateriTugas::index');
    $routes->get('materitugas/uploadMateri', 'Guru\MateriTugas::uploadMateri');
    $routes->post('materitugas/uploadMateri', 'Guru\MateriTugas::uploadMateri');
    $routes->get('materitugas/uploadTugas', 'Guru\MateriTugas::uploadTugas');
    $routes->post('materitugas/uploadTugas', 'Guru\MateriTugas::uploadTugas');
    $routes->get('materitugas/deleteMateri/(:num)', 'Guru\MateriTugas::deleteMateri/$1');
    $routes->get('materitugas/deleteTugas/(:num)', 'Guru\MateriTugas::deleteTugas/$1');
    
    // E-Learning Guru - Additional Routes
    $routes->get('materitugas/materi', 'Guru\MateriTugas::materi');
    $routes->get('materitugas/tugas', 'Guru\MateriTugas::tugas');
    $routes->get('materitugas/pengumpulan', 'Guru\MateriTugas::pengumpulan');
    $routes->get('materitugas/detailPengumpulan/(:num)', 'Guru\MateriTugas::detailPengumpulan/$1');
    $routes->get('materitugas/downloadAll/(:num)', 'Guru\MateriTugas::downloadAll/$1');
    $routes->post('materitugas/nilaiTugas', 'Guru\MateriTugas::nilaiTugas');
    $routes->get('materitugas/download/(:num)', 'Guru\MateriTugas::download/$1');
    $routes->get('materitugas/editMateri/(:num)', 'Guru\MateriTugas::editMateri/$1');
    $routes->post('materitugas/updateMateri/(:num)', 'Guru\MateriTugas::updateMateri/$1');
    $routes->get('materitugas/editTugas/(:num)', 'Guru\MateriTugas::editTugas/$1');
    $routes->post('materitugas/updateTugas/(:num)', 'Guru\MateriTugas::updateTugas/$1');
    $routes->get('materitugas/statistik', 'Guru\MateriTugas::statistik');

    // E-Learning Drilldown Guru
    $routes->get('materitugasdrilldown', 'Guru\MateriTugasDrilldown::mapel');
    $routes->get('materitugasdrilldown/kelas/(:num)', 'Guru\MateriTugasDrilldown::kelas/$1');
    $routes->get('materitugasdrilldown/pertemuan/(:num)/(:num)', 'Guru\MateriTugasDrilldown::pertemuan/$1/$2');
    $routes->get('materitugasdrilldown/detail/(:num)/(:num)/(:num)', 'Guru\MateriTugasDrilldown::detail/$1/$2/$3');
    $routes->post('materitugasdrilldown/updateTopik/(:num)', 'Guru\MateriTugasDrilldown::updateTopik/$1');
    $routes->post('materitugasdrilldown/updateVideo/(:num)', 'Guru\MateriTugasDrilldown::updateVideo/$1');
    $routes->post('materitugasdrilldown/tambahMateri/(:num)', 'Guru\MateriTugasDrilldown::tambahMateri/$1');
    $routes->post('materitugasdrilldown/tambahTugas/(:num)', 'Guru\MateriTugasDrilldown::tambahTugas/$1');
    $routes->post('guru/materitugasdrilldown/simpanPretest/(:num)', 'Guru\\MateriTugasDrilldown::simpanPretest/$1');
    $routes->post('guru/materitugasdrilldown/simpanAbsensi/(:num)', 'Guru\\MateriTugasDrilldown::simpanAbsensi/$1');

    // Pertemuan Routes
    $routes->get('pertemuan', 'Guru\Pertemuan::index');
    $routes->get('pertemuan/create', 'Guru\Pertemuan::create');
    $routes->post('pertemuan/store', 'Guru\Pertemuan::store');
    $routes->get('pertemuan/edit/(:num)', 'Guru\Pertemuan::edit/$1');
    $routes->post('pertemuan/update/(:num)', 'Guru\Pertemuan::update/$1');
    $routes->post('pertemuan/delete/(:num)', 'Guru\Pertemuan::delete/$1');
    $routes->post('guru/pertemuan/generate_otomatis', 'Guru\\Pertemuan::generate_otomatis');

    // Raport Routes
    $routes->get('raport', 'Guru\Raport::index');
    $routes->get('raport/siswa/(:num)', 'Guru\Raport::siswa/$1');
    $routes->get('raport/detail/(:num)', 'Guru\Raport::detail/$1');
    $routes->get('raport/preview/(:num)', 'Guru\Raport::preview/$1');
    $routes->get('raport/cetak/(:num)', 'Guru\Raport::cetak/$1');
});

// Siswa Routes
$routes->group('siswa', ['filter' => 'auth:siswa'], function($routes) {
    $routes->get('/', 'Siswa\Dashboard::index');
    $routes->get('dashboard', 'Siswa\Dashboard::index');
    $routes->get('absensi', 'Siswa\Absensi::index');
    $routes->get('absensi/form', 'Siswa\Absensi::form');
    $routes->post('absensi/simpan', 'Siswa\Absensi::simpan');
    $routes->get('absensi/riwayat', 'Siswa\Absensi::riwayat');
    $routes->get('pengumuman', 'Siswa\Pengumuman::index');
    
    // Pengumuman Routes
    $routes->get('pengumuman/jadwal-ujian', 'Siswa\Pengumuman::jadwalUjian');
    $routes->get('pengumuman/download/(:num)', 'Siswa\Pengumuman::download/$1');
    
    // E-Learning Siswa
    $routes->get('materi-tugas', 'Siswa\MateriTugas::index');
    $routes->get('materi-tugas/materi', 'Siswa\MateriTugas::materi');
    $routes->get('materi-tugas/tugas', 'Siswa\MateriTugas::tugas');
    $routes->get('materi-tugas/downloadMateri/(:num)', 'Siswa\MateriTugas::downloadMateri/$1');
    $routes->get('materi-tugas/uploadTugas/(:num)', 'Siswa\MateriTugas::uploadTugas/$1');
    $routes->post('materi-tugas/simpanTugas', 'Siswa\MateriTugas::simpanTugas');
    $routes->get('materi-tugas/downloadTugas/(:num)', 'Siswa\MateriTugas::downloadTugas/$1');
    
    // Nilai Routes
    $routes->get('nilai', 'Siswa\Nilai::index');
    $routes->get('nilai/detail/(:num)', 'Siswa\Nilai::detail/$1');
    $routes->get('nilai/raport', 'Siswa\Nilai::raport');
    $routes->get('nilai/cetak-raport', 'Siswa\Nilai::cetakRaport');
    $routes->get('nilai/generate-pdf', 'Siswa\Nilai::generatePDF');
    $routes->get('nilai/statistik', 'Siswa\Nilai::statistik');
    
    // e-Raport Routes
    $routes->get('raport', 'Siswa\Nilai::raport');
    
    // Test Route
    $routes->get('test', 'Siswa\Test::index');

    // E-Learning Siswa (alternatif underscore)
    $routes->get('materi_tugas', 'Siswa\MateriTugas::index');
    $routes->get('materi_tugas/materi', 'Siswa\MateriTugas::materi');
    $routes->get('materi_tugas/tugas', 'Siswa\MateriTugas::tugas');
    $routes->get('materi_tugas/downloadMateri/(:num)', 'Siswa\MateriTugas::downloadMateri/$1');
    $routes->get('materi_tugas/uploadTugas/(:num)', 'Siswa\MateriTugas::uploadTugas/$1');
    $routes->post('materi_tugas/simpanTugas', 'Siswa\MateriTugas::simpanTugas');
    $routes->get('materi_tugas/downloadTugas/(:num)', 'Siswa\MateriTugas::downloadTugas/$1');
    
    // E-Learning Siswa (alternatif tanpa dash)
    $routes->get('materitugas', 'Siswa\MateriTugas::index');
    $routes->get('materitugas/materi', 'Siswa\MateriTugas::materi');
    $routes->get('materitugas/tugas', 'Siswa\MateriTugas::tugas');
    $routes->get('materitugas/detailTugas/(:num)', 'Siswa\MateriTugas::detailTugas/$1');
    $routes->get('materitugas/uploadTugas/(:num)', 'Siswa\MateriTugas::uploadTugas/$1');
    $routes->post('materitugas/uploadTugas/(:num)', 'Siswa\MateriTugas::uploadTugas/$1');
    $routes->get('materitugas/downloadMateri/(:num)', 'Siswa\MateriTugas::downloadMateri/$1');
    $routes->get('materitugas/downloadTugas/(:num)', 'Siswa\MateriTugas::downloadTugas/$1');
});

// Test Route tanpa filter
$routes->get('test-no-filter', 'Siswa\Test::index');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
