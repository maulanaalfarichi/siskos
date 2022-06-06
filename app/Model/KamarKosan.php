<?php

namespace Bukosan\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KamarKosan extends Model
{

    protected $table = 'kamar_kosan';

    public $timestamps = false;

    public static function refind(){
        $kamar = DB::table(DB::raw('kamar_kosan as kk,('.
                                    DB::table(DB::raw('kamar_kosan, foto_kamar_kosan, foto'))
                                        ->whereRaw('foto.id = foto_kamar_kosan.idfoto')
                                        ->whereRaw('kamar_kosan.id = foto_kamar_kosan.idkamarkosan')
                                        ->select(DB::raw('min(foto.nama) as nama, kamar_kosan.id as id'))
                                        ->groupBy('kamar_kosan.id')
                                        ->toSql()
                                    .') as f'))
                    ->whereRaw('kk.id = f.id')
                    ->where('kk.tersedia',true)
                    ->distinct();
        return $kamar;
    }

    public static function whereId($id){
        $kamar = static::refind()
                ->where('kk.id','=',$id);

        return static::render($kamar)->first();
    }

    public static function fromKosanId($idkosan){
        $kamar = static::refind()
                    ->where('kk.idkosan','=',$idkosan);
        return static::render($kamar)->get();
    }

    public static function render($kamar){
        return $kamar->select(DB::raw('kk.*, f.nama as foto'));
    }
	
	public static function destroyFromSpecifiedUser($id){
		$daftarkosan = Kosan::where('idpemilik',$id)->pluck('id');
		$daftarkamar = static::whereIn('idkosan',$daftarkosan);
		// Menghapus daftar foto
		foreach($daftarkamar as $kamar){
			static::destroy($kamar->id);
		}
	}
	
	public static function destroyFromSpecifiedKosan($id){
		$daftarkamar = static::where('idkosan',$id)->pluck('id');
		// Menghapus daftar foto
		foreach($daftarkamar as $idkamar){
			static::destroy($idkamar);
		}
	}
	
	public static function destroy($id){
		FotoKamarKosan::destroyFromSpecifiedKamar($id);
		RiwayatSewa::where('idkamar',$id)->delete();
		Favorit::where('idkamarkosan',$id)->delete();
		static::find($id)->delete();
	}
	
	public static function deletable($id){
		if(RiwayatSewa::where('idkamar',$id)->where('status','!=','SL')->count() > 0)
			return false;
		return true;
	}

    public static function GetJumlahSewa($id)
    {
        return DB::table(DB::raw('kamar_kosan as kk LEFT JOIN (SELECT count(riwayat_sewa.kode) as jumlah, idkamar FROM riwayat_sewa GROUP BY riwayat_sewa.idkamar) as rs ON kk.id = rs.idkamar'))
            ->whereRaw('kk.id = ' . $id)
            ->select(DB::raw('rs.jumlah as jumlah'))
            ->first();
    }

}
