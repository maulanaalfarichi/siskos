<?php

namespace Bukosan\Model;

use Illuminate\Database\Eloquent\Model;

class Favorit extends Model
{

    protected $table = 'favorit';

    public $primaryKey = 'iduser';

    public $timestamps = false;

    protected $fillable = [
        'iduser','idkamarkosan'
    ];
	
	public static function destroyFromSpecifiedUser($id){
		static::where('iduser',$id)->delete();
	}

}
