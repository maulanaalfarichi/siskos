<?php

namespace Bukosan\Http\Controllers;

use Illuminate\Http\Request;
use Bukosan\Model\Kosan;
use Bukosan\Model\FotoKosan;
use Bukosan\Model\KamarKosan;
use Bukosan\Model\RiwayatSewa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Bukosan\Model\Lokasi\Kelurahan;

class KosanController extends Controller
{

    /**
     * Mendapatkan foto dari sebuah kosan
     *
     * @param $id
     * @return mixed
     */
    public static function GetFotoKosan($id)
    {
        return FotoKosan::get($id);
    }

    /**
     * Mendapatkan jumlah dari kamar kosan yang difavoritkan
     *
     * @param $id
     * @return mixed
     */
    public static function GetFavorit($id)
    {
        return Kosan::getJumlahFavorit($id);
    }

    public static function GetJumlahSewa($id)
    {

    }

    public static function cari(Request $request)
    {
        return Kosan::cari($request);
    }

    /**
    * Menyimpan kosan ke dalam database
    *
    * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
    */
    public function store(Request $request)
    {
        if(!$this->ValidasiKosan($request)->fails()){
            $this->manage($request, new Kosan());
            return redirect()->route('kosansaya');
        }
        else{
            return redirect()->back()->withErrors($this->ValidasiKosan($request))->withInput();
        }
    }

    private function ValidasiKosan(Request $request){
        if($request->jeniskosan == 'keluarga'){
            $validate = Validator::make($request->toArray(),[
                'nama' => 'required|min:5',
                'alamat' => 'required|min:10',
                'lantai' => 'required|numeric',
                'longitude' => 'required|numeric',
                'latitude' => 'required|numeric',
                'deskripsi' => 'required|min:50',
                'kelurahan' => 'required',
                'image' => 'required',
            ]);
        }
        else{
            $validate = Validator::make($request->toArray(),[
                'nama' => 'required|min:5',
                'alamat' => 'required|min:10',
                'lantai' => 'required|numeric',
                'longitude' => 'required|numeric',
                'latitude' => 'required|numeric',
                'deskripsi' => 'required|min:50',
                'jeniskelamin' => 'required',
                'kelurahan' => 'required',
                'image' => 'required',
            ]);
        }
        return $validate;
    }

    public function manage(Request $request, Kosan $kosan){
        if(is_null($kosan->id))
        $kosan->idpemilik = Auth::user()->id;
        $kosan->nama = $request->nama;
        $kosan->alamat = $request->alamat;
        $kosan->jumlahlantai = $request->lantai;
        $kosan->latitude = $request->latitude;
        $kosan->longitude = $request->longitude;
        $kosan->keterangan = $request->deskripsi;
        $kosan->kelurahan = Kelurahan::find($request->kelurahan)->id;
        $kosan->terverifikasi = false;

        # Fasilitas
        $kosan->wifi = $request->wifi;
        $kosan->dapur = $request->dapur;
        $kosan->jammalam = $request->jammalam;
        $kosan->kmdalam = $request->kmdalam;
        $kosan->tempatparkir = $request->tempatparkir;
        $kosan->lemaries = $request->lemaries;
        $kosan->televisi = $request->televisi;

        # Jenis kosan
        if($request->jeniskosan == 'keluarga')
            $kosan->keluarga = true;
        else {
            $kosan->keluarga = false;
            $kosan->kosanperempuan = ($request->jeniskelamin == 'L') ? false : true;
        }

        # simpan
        $kosan->save();

        # Menyimpan Gambar
        ImageController::SaveKosanImage($kosan->id,explode(',',$request->image));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if (!$this->ValidasiKosan($request)->fails()) {
            $kosan = Kosan::where('id', $id)->first();
            # Menghapus dulu gambar yang ada
            ImageController::HapusFotoKosan($id, false);
            $this->manage($request, $kosan);
            return redirect()->route('kosansaya');
        } else {
            return redirect()->back()->withErrors($this->ValidasiKosan($request))->withInput();
        }
    }

    /**
    * Menghapus kosan dari database
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        if(Kosan::deletable($id)) {
            Kosan::destroy($id);
            return json_encode(['status' => true]);
        }
        else{
            return json_encode(['status' => false]);
        }
    }

    /**
     * Melakukan penangguhan terhadap sebuah kosan
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function tangguhkan($id)
    {
        $kosan = Kosan::find($id);
        $kosan->ditangguhkan = !$kosan->ditangguhkan;
        $kosan->save();

        return redirect()->back();
    }

    public function verifikasi($id)
    {
        $kosan = Kosan::find($id);
        $kosan->terverifikasi = true;
        $kosan->save();

        return redirect()->back();
    }

}
