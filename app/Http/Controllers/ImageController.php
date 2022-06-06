<?php

namespace Bukosan\Http\Controllers;

use Illuminate\Http\Request;
use Bukosan\Model\FotoKosan;
use Bukosan\Model\FotoKamarKosan;
use Bukosan\Model\Foto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{

    /**
     * Melakukan upload image dan mengirim daftar nama image dalam
     * bentuk JSON
     *
     * @param Request $request
     * @return string
     */
    public function uploads(Request $request)
    {
        $images = [
            'fullurl' => [],
            'name' => []
        ];
        foreach ($request->images as $image){
            $imageName = time().''.$image->getClientOriginalName();
            # Menyimpan ke database
            $foto = new Foto();
            $foto->nama = $imageName;
            $foto->save();
            # Menyimpan gambar secara public
            $image->storePubliclyAs('public',$imageName);
            # Menyimpan url gambar secara penuh
            array_push($images['fullurl'],asset('storage/'.$imageName));
            # Menyimpan nama gambar
            array_push($images['name'],$imageName);
        }
        return json_encode($images);
    }

    public function upload(Request $request){
        $image = $request->image;
        $imageName = time().''.$image->getClientOriginalName();
        # Menyimpan ke database
        $foto = new Foto();
        $foto->nama = $imageName;
        $foto->save();
        # Menyimpan gambar secara public
        $image->storePubliclyAs('public',$imageName);
        return json_encode([
            'fullUrl' => asset('storage/'.$imageName),
            'name' => $imageName
        ]);
    }

    public static function SaveKosanImage($idKosan, array $ImageList){
        foreach ($ImageList as $value) {
            $idfoto = Foto::where('nama',$value)->first()->id;
            $fotokosan =  new FotoKosan();
            $fotokosan->setKeyName('idfoto');
            $fotokosan->idfoto = $idfoto;
            $fotokosan->idkosan = $idKosan;
            $fotokosan->save();
        }
    }

    public static function SaveKamarKosanImage($idKamarKosan, array $ImageList){
        foreach ($ImageList as $value) {
            $idfoto = Foto::all()->where('nama',$value)->first()->id;
            $fotokamarkosan =  new FotoKamarKosan();
            $fotokamarkosan->setKeyName('idfoto');
            $fotokamarkosan->idfoto = $idfoto;
            $fotokamarkosan->idkamarkosan = $idKamarKosan;
            $fotokamarkosan->save();
        }
    }

    public static function HapusFotoKosan($idkosan,$deletefile = true){
        # Mendapatkan foto kosan
        $fotokosan = DB::table('foto_kosan')
                        ->join('foto','foto.id','=','foto_kosan.idfoto')
                        ->join('kosan','kosan.id','=','foto_kosan.idkosan')
                        ->select('foto.nama');
        foreach($fotokosan->get() as $foto){
            # Menghapus dari storage
            if($deletefile){
                Storage::delete('public/'.$foto->nama);
                # Menghapus foto dari database
                Foto::where('nama',$foto->nama)->delete();
            }
        }
        # Menghapus dari tabel foto_kosan
        FotoKosan::where('idkosan',$idkosan)->delete();
    }

    public static function HapusFotoKamarKosan($idkamar,$deletefile = true){
        # Mendapatkan foto kamar kosan
        $fotokamar = DB::select('SELECT foto.nama FROM foto, foto_kamar_kosan WHERE foto.id = foto_kamar_kosan.idfoto AND foto_kamar_kosan.idkamarkosan = ' . $idkamar);
        # Menghapus foto dari tabel foto_kamar_kosan
        FotoKamarKosan::where('idkamarkosan',$idkamar)->delete();
        foreach($fotokamar as $foto){
            # Menghapus dari storage
            if($deletefile){
                Storage::delete('public/'.$foto->nama);
                # Menghapus foto dari database
                Foto::where('nama',$foto->nama)->delete();
            }
        }
    }

    public function HapusFoto(Request $request){
        # Mendapatkan instance FotoKosan
        $foto = Foto::where('nama',$request->foto)->first();
        # Mengecek foto pada tabel
        if(FotoKosan::where('idfoto',$foto->id)->count() == 1){
            FotoKosan::where('idfoto',$foto->id)->delete();
            Storage::delete('public/' . $foto->nama);
            $foto->delete();
            return json_encode(['status' => 1]);
        }
        else if(FotoKamarKosan::where('idfoto',$foto->id)->count() == 1){
            FotoKamarKosan::where('idfoto',$foto->id)->delete();
            Storage::delete('public/' . $foto->nama);
            $foto->delete();
            return json_encode(['status' => 1]);
        }
        else{
            $foto->delete();
            return json_encode(['status' => 1]);
        }
        return json_encode(['status' => 0]);
    }

}
