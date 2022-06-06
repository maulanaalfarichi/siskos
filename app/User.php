<?php

namespace Bukosan;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Bukosan\Model\RiwayatSewa;
use Bukosan\Model\RiwayatKunjungan;
use Bukosan\Model\Pesan;
use Bukosan\Model\Favorit;
use Bukosan\Model\Kosan;
use Bukosan\Model\KamarKosan;
use Illuminate\Http\Request;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username','displayname','password','remember_token','email'
    ];

    public $timestamps = false;

    protected $table = 'user';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];
	
	public static function destroy($id){
		// memastikan user bisa dihapus
		if(static::deletable($id)){
			// Menghapus riwayat sewa
			RiwayatSewa::destroyFromSpecifiedUser($id);
			// Menghapus riwayat kunjungan dari user
			RiwayatKunjungan::destroyFromSpecifiedUser($id);
			// Menghapus favorit user
			Favorit::destroyFromSpecifiedUser($id);
			// Menghapus kosan user
            Kosan::destroyFromSpecifiedUser($id);
			// Menghapus pesan user
			Pesan::destroyFromSpecifiedUser($id);
			// Menghapus user
			static::find($id)->delete();
			$response = [
				'status' => true
			];
		}
		else{
			$response = [
				'status' => false
			];
		}
		return json_encode($response);
	}
	
	public static function deletable($id){
		// Memastikan user tidak memiliki riwayat sewa yang belum selesai
		if(RiwayatSewa::deletableFromUser($id))
			return true;
		return false;
	}

}
