<?php

namespace Bukosan\Model;

use Illuminate\Database\Eloquent\Model;
use Bukosan\Model\Foto;
use Illuminate\Support\Facades\Storage;

class FotoKamarKosan extends Model
{

    protected $table = 'foto_kamar_kosan';

    public $timestamps = false;
	
	public static function destroyFromSpecifiedKamar($id){
		$daftarfotokamar = static::where('idkamarkosan',$id)->pluck('idfoto');
		foreach($daftarfotokamar as $fotokamar){
			// Mendapatkan foto dari tabel Foto
			$foto = Foto::find($fotokamar);
			// Menghapus dari tabel foto_kamar_kosan
			static::where('idfoto',$fotokamar)->delete();
			// Menghapus file foto
			Storage::delete('public/' . $foto->nama);
			// Menghapus dari tabel Foto
			$foto->delete();
		}
	}

}
