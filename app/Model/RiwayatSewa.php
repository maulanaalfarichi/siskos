<?php

namespace Bukosan\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RiwayatSewa extends Model
{

    public $timestamps = false;
    protected $table = 'riwayat_sewa';
    protected $fillable = [
        'idkamar','harga','tanggal','idpenyewa','kode','status'
    ];

    public static function whereIDPemilik($id){
        return static::refind()
                        ->whereRaw('pemilik.id = ' . $id);
    }

    public static function refind()
    {
        return DB::table(DB::raw('"user" as penyewa, "user" as pemilik, riwayat_sewa as rs, kamar_kosan as km, kosan as ks'))
            ->select(DB::raw('rs.kode as kode, ks.nama as namakosan, km.nama as namakamar, rs.tanggal as tanggal, rs.status as status'))
            ->whereRaw('penyewa.id = rs.idpenyewa AND km.idkosan = ks.id AND ks.idpemilik = pemilik.id AND rs.idkamar = km.id');
    }

    public static function whereIDPenyewa($id){
        return static::refind()
                        ->whereRaw('penyewa.id = ' . $id);
    }
	
	public static function destroyFromSpecifiedUser($id){
		$daftar = DB::table(DB::raw('riwayat_sewa'))
					->whereRaw('idpenyewa = '.$id.' OR idkamar in (SELECT kk.id FROM "user" as u, kamar_kosan as kk, kosan as k WHERE u.id = '.$id.' AND k.idpemilik = u.id AND kk.idkosan = k.id)')
					->delete();
	}
	
	public static function deletableFromUser($id){
		$daftar = DB::table(DB::raw('"user" as u, kosan as k, kamar_kosan as kk, riwayat_sewa as rs'))
					->whereRaw('(rs.idpenyewa = '.$id.' OR (rs.idkamar = kk.id AND kk.idkosan = k.id AND k.idpemilik = '.$id.')) AND rs.status != \'SL\'')
					->select('rs.*')
					->get();
		if(count($daftar) > 0)
			return false;
		return true;
	}

}
