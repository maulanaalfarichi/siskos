<?php

namespace Bukosan\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Bukosan\Model\Foto;
use Illuminate\Support\Facades\Storage;

class FotoKosan extends Model
{

    public $timestamps = false;
    protected $table = 'foto_kosan';

    /**
     * Mendapatkan foto kosan
     *
     * @param $id
     * @return mixed
     */
    public static function get($id)
    {
        $foto = DB::table(DB::raw('foto as f, foto_kosan as fk, kosan as k'))
            ->whereRaw('fk.idfoto = f.id')
            ->whereRaw('k.id = fk.idkosan')
            ->whereRaw('k.id = ' . $id)
            ->select(DB::raw('f.nama as nama'));
        return $foto->get();
    }
	
	public static function destroyFromSpecifiedKosan($id){
		$daftarfotokosan = static::where('idkosan',$id)->pluck('idfoto');
		foreach($daftarfotokosan as $fotokosan){
			// Mendapatkan foto dari tabel Foto
			$foto = Foto::find($fotokosan);
			// Menghapus dari tabel foto_kamar_kosan
			static::where('idfoto',$fotokosan)->delete();
			// Menghapus file foto
			Storage::delete('public/' . $foto->nama);
			// Menghapus dari tabel Foto
			$foto->delete();
		}
	}

}
