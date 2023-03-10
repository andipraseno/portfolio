<?php

$router->get('/key', function () {
    return \Illuminate\Support\Str::random(32);
});

$router->group(['prefix' => '/'], function () use ($router) {
    $router->get('/', 'actasys\LoginController@index');
    $router->post('/login', 'actasys\LoginController@login');
    $router->get('/logon/{id}/{password}', 'actasys\LoginController@logon');
    $router->get('/logout', 'actasys\LoginController@logout');

    $router->get('/dashboard', 'actasys\DashboardController@index');
    $router->get('/dashboard_set_theme', 'actasys\DashboardController@set_theme');
    $router->get('/dashboard_set_sidebar', 'actasys\DashboardController@set_sidebar');

    $router->get('/userprofile', 'actasys\UserProfileController@index');
    $router->post('/userprofile_save', 'actasys\UserProfileController@save');

    $router->get('/changepassword', 'actasys\ChangePasswordController@index');
    $router->post('/changepassword_save', 'actasys\ChangePasswordController@save');

    $router->get('/lockscreen', 'actasys\LockscreenController@index');
    $router->post('/unlockscreen', 'actasys\LockscreenController@unlock');
});

$router->group(['prefix' => 'lampiran'], function () use ($router) {
    $router->get('/bank', 'lampiran\BankController@index');
    $router->post('/bank_list', 'lampiran\BankController@list');
    $router->post('/bank_attach', 'lampiran\BankController@attach');
    $router->get('/bank_add', 'lampiran\BankController@add');
    $router->post('/bank_add_save', 'lampiran\BankController@add_start');
    $router->get('/bank_edit/{id}', 'lampiran\BankController@edit');
    $router->post('/bank_edit_save', 'lampiran\BankController@edit_start');
    $router->get('/bank_terminate/{id}', 'lampiran\BankController@terminate');
    $router->post('/bank_terminate_save', 'lampiran\BankController@terminate_start');

    $router->get('/agama', 'lampiran\AgamaController@index');
    $router->post('/agama_list', 'lampiran\AgamaController@list');
    $router->get('/agama_add', 'lampiran\AgamaController@add');
    $router->post('/agama_add_save', 'lampiran\AgamaController@add_start');
    $router->get('/agama_edit/{id}', 'lampiran\AgamaController@edit');
    $router->post('/agama_edit_save', 'lampiran\AgamaController@edit_start');
    $router->get('/agama_terminate/{id}', 'lampiran\AgamaController@terminate');
    $router->post('/agama_terminate_save', 'lampiran\AgamaController@terminate_start');

    $router->get('/jeniskelamin', 'lampiran\JenisKelaminController@index');
    $router->post('/jeniskelamin_list', 'lampiran\JenisKelaminController@list');
    $router->get('/jeniskelamin_add', 'lampiran\JenisKelaminController@add');
    $router->post('/jeniskelamin_add_save', 'lampiran\JenisKelaminController@add_start');
    $router->get('/jeniskelamin_edit/{id}', 'lampiran\JenisKelaminController@edit');
    $router->post('/jeniskelamin_edit_save', 'lampiran\JenisKelaminController@edit_start');
    $router->get('/jeniskelamin_terminate/{id}', 'lampiran\JenisKelaminController@terminate');
    $router->post('/jeniskelamin_terminate_save', 'lampiran\JenisKelaminController@terminate_start');

    $router->get('/tingkatpendidikan', 'lampiran\TingkatPendidikanController@index');
    $router->post('/tingkatpendidikan_list', 'lampiran\TingkatPendidikanController@list');
    $router->get('/tingkatpendidikan_add', 'lampiran\TingkatPendidikanController@add');
    $router->post('/tingkatpendidikan_add_save', 'lampiran\TingkatPendidikanController@add_start');
    $router->get('/tingkatpendidikan_edit/{id}', 'lampiran\TingkatPendidikanController@edit');
    $router->post('/tingkatpendidikan_edit_save', 'lampiran\TingkatPendidikanController@edit_start');
    $router->get('/tingkatpendidikan_terminate/{id}', 'lampiran\TingkatPendidikanController@terminate');
    $router->post('/tingkatpendidikan_terminate_save', 'lampiran\TingkatPendidikanController@terminate_start');

    $router->get('/statusperkawinan', 'lampiran\StatusPerkawinanController@index');
    $router->post('/statusperkawinan_list', 'lampiran\StatusPerkawinanController@list');
    $router->get('/statusperkawinan_add', 'lampiran\StatusPerkawinanController@add');
    $router->post('/statusperkawinan_add_save', 'lampiran\StatusPerkawinanController@add_start');
    $router->get('/statusperkawinan_edit/{id}', 'lampiran\StatusPerkawinanController@edit');
    $router->post('/statusperkawinan_edit_save', 'lampiran\StatusPerkawinanController@edit_start');
    $router->get('/statusperkawinan_terminate/{id}', 'lampiran\StatusPerkawinanController@terminate');
    $router->post('/statusperkawinan_terminate_save', 'lampiran\StatusPerkawinanController@terminate_start');

    $router->get('/statusperpajakan', 'lampiran\StatusPerpajakanController@index');
    $router->post('/statusperpajakan_list', 'lampiran\StatusPerpajakanController@list');
    $router->get('/statusperpajakan_add', 'lampiran\StatusPerpajakanController@add');
    $router->post('/statusperpajakan_add_save', 'lampiran\StatusPerpajakanController@add_start');
    $router->get('/statusperpajakan_edit/{id}', 'lampiran\StatusPerpajakanController@edit');
    $router->post('/statusperpajakan_edit_save', 'lampiran\StatusPerpajakanController@edit_start');
    $router->get('/statusperpajakan_terminate/{id}', 'lampiran\StatusPerpajakanController@terminate');
    $router->post('/statusperpajakan_terminate_save', 'lampiran\StatusPerpajakanController@terminate_start');

    $router->get('/jabatan', 'lampiran\JabatanController@index');
    $router->post('/jabatan_list', 'lampiran\JabatanController@list');
    $router->get('/jabatan_add', 'lampiran\JabatanController@add');
    $router->post('/jabatan_add_save', 'lampiran\JabatanController@add_start');
    $router->get('/jabatan_edit/{id}', 'lampiran\JabatanController@edit');
    $router->post('/jabatan_edit_save', 'lampiran\JabatanController@edit_start');
    $router->get('/jabatan_terminate/{id}', 'lampiran\JabatanController@terminate');
    $router->post('/jabatan_terminate_save', 'lampiran\JabatanController@terminate_start');

    $router->get('/tipeabsen', 'lampiran\TipeAbsenController@index');
    $router->post('/tipeabsen_list', 'lampiran\TipeAbsenController@list');
    $router->get('/tipeabsen_add', 'lampiran\TipeAbsenController@add');
    $router->post('/tipeabsen_add_save', 'lampiran\TipeAbsenController@add_start');
    $router->get('/tipeabsen_edit/{id}', 'lampiran\TipeAbsenController@edit');
    $router->post('/tipeabsen_edit_save', 'lampiran\TipeAbsenController@edit_start');
    $router->get('/tipeabsen_terminate/{id}', 'lampiran\TipeAbsenController@terminate');
    $router->post('/tipeabsen_terminate_save', 'lampiran\TipeAbsenController@terminate_start');
});

$router->group(['prefix' => 'master'], function () use ($router) {
    $router->get('/department', 'master\DepartmentController@index');
    $router->post('/department_list', 'master\DepartmentController@list');
    $router->get('/department_add', 'master\DepartmentController@add');
    $router->post('/department_add_save', 'master\DepartmentController@add_start');
    $router->get('/department_edit/{id}', 'master\DepartmentController@edit');
    $router->post('/department_edit_save', 'master\DepartmentController@edit_start');
    $router->get('/department_terminate/{id}', 'master\DepartmentController@terminate');
    $router->post('/department_terminate_save', 'master\DepartmentController@terminate_start');

    $router->get('/karyawan', 'master\KaryawanController@index');
    $router->post('/karyawan_list', 'master\KaryawanController@list');
    $router->get('/karyawan_add', 'master\KaryawanController@add');
    $router->post('/karyawan_add_save', 'master\KaryawanController@add_start');
    $router->get('/karyawan_edit/{id}', 'master\KaryawanController@edit');
    $router->post('/karyawan_edit_save', 'master\KaryawanController@edit_start');
    $router->get('/karyawan_terminate/{id}', 'master\KaryawanController@terminate');
    $router->post('/karyawan_terminate_save', 'master\KaryawanController@terminate_start');
});

$router->group(['prefix' => 'absensi'], function () use ($router) {
    $router->get('/penjadwalan', 'absensi\PenjadwalanController@index');
    $router->post('/penjadwalan_list', 'absensi\PenjadwalanController@list');
    $router->get('/penjadwalan_add', 'absensi\PenjadwalanController@add');
    $router->post('/penjadwalan_add_save', 'absensi\PenjadwalanController@add_start');
    $router->post('/penjadwalan_agenda_save', 'absensi\PenjadwalanController@agenda_save');
    $router->post('/penjadwalan_dailyagenda_save', 'absensi\PenjadwalanController@dailyagenda_save');

    $router->get('/kehadiran', 'absensi\KehadiranController@index');
    $router->post('/kehadiran_list', 'absensi\KehadiranController@list');
    $router->get('/kehadiran_edit/{id}/{jadwal_id}', 'absensi\KehadiranController@edit');
    $router->post('/kehadiran_edit_save', 'absensi\KehadiranController@edit_start');
});
