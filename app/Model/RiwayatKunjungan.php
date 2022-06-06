<?php

namespace Bukosan\Model;

use Illuminate\Database\Eloquent\Model;

class RiwayatKunjungan extends Model
{

    public $timestamps = false;
	
    protected $table = 'riwayat_kunjungan';
	
    protected $primaryKey = 'iduser';

    protected $fillable = [
        'iduser','idkosan'
    ];
	
	public static function destroyFromSpecifiedUser($id){
		static::where('iduser',$id)->delete();
	}

	public static function destroyFromSpecifiedKosan($id){
	    static::where('idkosan',$id)->delete();
    }

}
