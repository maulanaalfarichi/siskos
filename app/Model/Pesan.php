<?php

namespace Bukosan\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Bukosan\User;

class Pesan extends Model
{
    
	protected $table = "pesan";
	
	public $timestamps = false;
	
	public $fillable = [
		'idfrom','idto','isi','toread','waktu'
	];
	
	public static function getDaftarPercakapan(){
		$pesan = DB::table(DB::raw('pesan as p, "user" as u'))
					->whereRaw('(p.idto = u.id OR p.idfrom = u.id)')
					->whereRaw('(p.idto = '.Auth::user()->id.' OR p.idfrom = '.Auth::user()->id.')')
					->select(DB::raw('u.*'))
					->distinct();
		return $pesan->get();
	}
	
	private static function readPercakapan($idfrom){
		foreach (Pesan::where('idfrom',$idfrom)->where('idto',Auth::user()->id)->cursor() as $pesan){
		    $pesan->toread = true;
		    $pesan->save();
        }
	}
	
	public static function getPercakapan($id){
		$pesan = DB::table(DB::raw('pesan as p,"user" as u'))
					->whereRaw('(p.idto = '.$id.' AND p.idfrom = '.Auth::user()->id.') OR (p.idto = '.Auth::user()->id.' AND p.idfrom = '.$id.') AND u.id = p.idfrom')
					->select(DB::raw('p.idfrom as idfrom, p.idto as idto, p.isi as isi, p.waktu as waktu'))
					->orderBy('waktu')
					->distinct()
					->get();
		static::readPercakapan($id);
		$response = '<ul>';
		foreach($pesan as $detail){
			if(Auth::user()->id == $detail->idfrom)
				$response .= '<li class="user">';
			else
				$response .= '<li>';
			$response .= '<img src="'.asset('storage/'.User::find($detail->idfrom)->avatar).'"/>';
			$response .= '<p>'. $detail->isi .'</p>';
			$response .= '</li>';
		}
		$response .= '</ul>';
		return $response;
	}
	
	public static function destroyFromSpecifiedUser($id){
		static::where('idfrom',$id)->delete();
		static::where('idto',$id)->delete();
	}
	
}
