<?php

Route::get('test',function(){
	return (new \Bukosan\Http\Controllers\LocationController())->DaftarKelurahan(3578200);
});

Route::get('/', 'HomePageController@HomePage')->name('homepage');

Route::get('cari', 'PublicPageController@CariKosan')->name('cari');

Route::get('kosan/{id}','PublicPageController@LihatKosan')->name('lihat.kosan');

Route::get('kamar/{id}','PublicPageController@LihatKamar')->name('lihat.kamar');

Route::post('sewa/tiket','PublicPageController@createTiket')->name('sewa.tiket');

Route::post('verifikasi','RiwayatSewaController@verifikasi')->name('verifikasi.tiket');

Route::post('favorit','FavoritController@index')->name('favorit');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Halaman User

Route::group(['prefix' => 'upload'],function () {
	
    Route::post('images','ImageController@uploads')->name('upload.images');
	
    Route::post('image','ImageController@upload')->name('upload.image');
	
});

Route::get('ditangguhkan','UserPageController@ditangguhkan')->name('ditangguhkan');

Route::group(['middleware' => ['auth' , 'ditangguhkan']], function () {

    Route::get('tiket/{kodetiket}','PublicPageController@lihatTiket')->name('lihat.tiket');
	
    Route::get('pengaturan','UserPageController@SettingsPage')->name('settings');
	
    Route::post('pengaturan','SettingsController@process')->name('settings.process');
	
    Route::get('favorit','UserPageController@FavoritPage')->name('daftar.favorit');

    Route::post('ubahpassword','SettingsController@changePassword')->name('ubah.password');
	
    Route::group(['middleware' => 'user'], function(){

        Route::post('sewa/kamar','PublicPageController@sewa')->name('sewa.kamar');
		
		Route::post('kirim/pesan','PesanController@kirim')->name('kirim.pesan');
		
		Route::post('percakapan','PesanController@getPercakapan')->name('percakapan');
		
		Route::get('pesan','UserPageController@halamanPesan')->name('pesan');
		
        Route::get('kosansaya', 'UserPageController@KosanSayaPage')->name('kosansaya');

        Route::get('riwayatsewa', 'UserPageController@RiwayatSewaPage')->name('riwayat.sewa');
		
		Route::get('riwayatkunjungan','UserPageController@RiwayatKunjunganPage')->name('riwayat.kunjungan');

        Route::group(['prefix' => 'tambah'], function () {
			
            Route::get('kosan','UserPageController@CreateKosanPage')->name('tambah.kosan');
			
            Route::post('kosan','KosanController@store')->name('tambah.kosan');
			
            Route::get('kamar/{idkosan}', 'UserPageController@TambahKamarKosan')->name('tambah.kamar');
			
            Route::post('kamar','KamarKosanController@store')->name('proses.tambah.kamar');
        
		});

        Route::group(['prefix' => 'edit'],function(){
        
		Route::get('kosan/{idkosan}','UserPageController@EditKosanPage')->name('edit.kosan');

		Route::post('kosan/{idkosan}','KosanController@update')->name('edit.kosan');

		Route::get('kamar/{idkamar}','UserPageController@EditKamar')->name('edit.kamar');

		Route::post('kamar/{idkamar}','KamarKosanController@update')->name('edit.kamar');

        });

        Route::group(['prefix' => 'hapus'],function(){

		Route::get('kosan/{idkosan}','KosanController@destroy')->name('hapus.kosan');

		Route::get('kamar/{idkamar}','KamarKosanController@destroy')->name('hapus.kamar');

		Route::post('foto','ImageController@HapusFoto')->name('hapus.foto');

        });

        Route::get('kosan/{idkosan}/kamar','UserPageController@DaftarKamarKosan')->name('daftar.kamar');
		
		Route::group(['middleware' => 'admin', 'prefix' => 'admin'],function(){
			
			Route::get('verifikasi/kosan/{id}','KosanController@verifikasi')->name('verifikasi.kosan');
			
			Route::group(['prefix' => 'kelola'],function(){
			
				Route::get('user','AdminPageController@kelolaUser')->name('kelola.user');
				
				Route::get('kosan','AdminPageController@kelolaKosan')->name('kelola.kosan');
				
				Route::get('kamar/{idkosan}','AdminPageController@kelolaKamar')->name('kelola.kamar');
			
			});
			
			Route::group(['prefix' => 'tangguhkan'],function(){
			
				Route::get('user/{id}','UserController@tangguhkan')->name('tangguhkan.user');
				
				Route::get('kosan/{id}','KosanController@tangguhkan')->name('tangguhkan.kosan');
				
				Route::get('kamar/{id}','KamarKosanController@tangguhkan')->name('tangguhkan.kamar');
			
			});
			
			Route::group(['prefix' => 'hapus'],function(){
			
				Route::get('user/{id}','UserController@destroy')->name('hapus.user');
			
			});
			
		});

	});

});

Route::group(['prefix' => 'daftar'],function(){
	
    Route::get('kotakab/{idprovinsi}','LocationController@DaftarKotaKab');
	
    Route::get('kecamatan/{idkotakab}','LocationController@DaftarKecamatan');
	
    Route::get('kelurahan/{idkecamatan}','LocationController@DaftarKelurahan');
	
});