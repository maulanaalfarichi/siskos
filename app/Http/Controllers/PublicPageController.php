<?php

namespace Bukosan\Http\Controllers;

use Illuminate\Http\Request;
use Bukosan\Model\Kosan;
use Bukosan\Model\KamarKosan;
use Bukosan\Model\Favorit;
use Bukosan\Http\Controllers\KosanController;
use Bukosan\Http\Controllers\KamarKosanController;
use Bukosan\User;
use Bukosan\Model\Foto;
use Bukosan\Model\FotoKamarKosan;
use Illuminate\Support\Facades\Auth;
use Bukosan\Model\RiwayatSewa;
use Bukosan\Http\Controllers\RiwayatKunjunganController;

class PublicPageController extends Controller
{

    public function CariKosan(Request $request)
    {
        $kosan = Kosan::cari($request);
        return view('public.cari',[
            'kosan' => $kosan,
            'request' => $request
        ]);
    }

    public function LihatKosan($idkosan){
        // Menambah ke daftar riwayat kunjungan jika user sedang login
        RiwayatKunjunganController::tambah($idkosan);

        $kosan = Kosan::find($idkosan);
        $kamar = KamarKosan::fromKosanId($idkosan);
        return view('public.kosan',[
            'kosan' => $kosan,
            'hargamax' => $kamar->max('harga'),
            'hargamin' => $kamar->min('harga'),
            'ac' => $kamar->count('ac'),
            'kipasangin' => $kamar->count('kipasangin'),
            'foto' => KosanController::GetFotoKosan($idkosan),
            'kamar' => $kamar,
            'pemilik' => User::find($kosan->idpemilik),
            'favorit' => KosanController::GetFavorit($idkosan),
            'sewa' => Kosan::getJumlahSewa($idkosan)->jumlah
        ]);
    }

    public function LihatKamar($idkamar){
        $kamar = KamarKosan::find($idkamar);
        $kosan = Kosan::find($kamar->idkosan);

        // Menambah ke daftar riwayat kunjungan jika user sedang login
        RiwayatKunjunganController::tambah($kosan->id);
        if(Auth::check()){
        $tersedia = (($kamar->keluarga && !Auth::user()->keluarga) ||
                     ($kosan->kosanperempuan && Auth::user()->jenis_kelamin != 'P') ||
                     !$kamar->tersedia) ? false : true;
        }
        else {
            $tersedia = true;
        }
        return view('public.kamar',[
            'kamar' => $kamar,
            'kosan' => $kosan,
            'jumlahsewa' => KamarKosan::GetJumlahSewa($idkamar)->jumlah,
            'foto' => KamarKosanController::GetFotoKamarKosan($idkamar)->get(),
            'pemilik' => User::find($kosan->idpemilik),
            'favorit' => Favorit::where('idkamarkosan',$idkamar)->count(),
            'tersedia' => $tersedia,
            'favorited' => Auth::check() ? Favorit::where('iduser',Auth::user()->id)->where('idkamarkosan',$idkamar)->count() : false
        ]);
    }

    public function sewa(Request $request){
        $kamar = KamarKosan::find($request->id);
        $kosan = Kosan::withAddress($kamar->idkosan)->first();
        if(($kamar->keluarga && !Auth::user()->keluarga) ||
            ($kosan->kosanperempuan && Auth::user()->jenis_kelamin != 'P')){
            return view('public.message',[
                'title' => 'Anda tidak bisa memesan kamar kosan ini !',
                'message' => 'Jenis kosan yang akan anda pesan tidak sesuai dengan jenis kelamin atau jenis akun anda. Pastikan anda memilih kamar kosan yang sejenis dengan jenis akun anda !',
                'back' => route('lihat.kamar',[ 'id' => $kamar->id])
            ]);
        }
        else if(!$kamar->tersedia){
            return view('public.message',[
                'title' => 'Kosan tidak tersedia !',
                'message' => 'Untuk saat ini kosan yang akan anda pesan sedang tidak tersedia. Hal ini mungkin karena kamar kosan sedang ditempati oleh orang lain.',
                'back' => route('lihat.kamar',[ 'id' => $kamar->id])
            ]);
        }
        return view('public.sewa',[
            'kamar' => $kamar,
            'kosan' => $kosan,
            'foto' => Foto::where('id',FotoKamarKosan::where('idkamarkosan',$kamar->id)->first()->idfoto)->first(),
            'user' => Auth::user(),
            'pemilik' => User::where('id',$kosan->idpemilik)->first()
        ]);
    }

    public function lihatTiket($kodetiket){
        $tiket = RiwayatSewa::where('kode',$kodetiket)->first();
        $kamar = KamarKosan::where('id',$tiket->idkamar)->first();
        $kosan = Kosan::where('id',$kamar->idkosan)->first();
        if(Auth::user()->id != $tiket->idpenyewa && Auth::user()->id != $kosan->idpemilik){
            return view('error',[
                'message' => 'Tiket ini tidak bisa anda lihat !',
                'info' => 'Pastikan tiket yang akan anda lihat adalah tiket milik anda atau tiket milik calon penyewa kosan anda !'
            ]);
        }
        $tanggal = explode('-',$tiket->tanggal);
        switch($tanggal[1]){
            case '01': $tanggal[1] = 'Januari';break;
            case '02': $tanggal[1] = 'Februari';break;
            case '03': $tanggal[1] = 'Maret';break;
            case '04': $tanggal[1] = 'April';break;
            case '05': $tanggal[1] = 'Mei';break;
            case '06': $tanggal[1] = 'Juni';break;
            case '07': $tanggal[1] = 'Juli';break;
            case '08': $tanggal[1] = 'Agustus';break;
            case '09': $tanggal[1] = 'September';break;
            case '10': $tanggal[1] = 'Oktober';break;
            case '11': $tanggal[1] = 'November';break;
            case '12': $tanggal[1] = 'Desember';break;
        }
        return view('public.tiket',[
            'kamar' => $kamar,
            'kosan' => Kosan::withAddress($kamar->idkosan)->first(),
            'foto' => Foto::where('id',FotoKamarKosan::where('idkamarkosan',$kamar->id)->first()->idfoto)->first(),
            'penyewa' => User::where('id',$tiket->idpenyewa)->first(),
            'user' => Auth::user(),
            'pemilik' => User::where('id',$kosan->idpemilik)->first(),
            'kode' => $tiket->kode,
            'status' => $tiket->status,
            'tanggal' => [
                'tanggal' => $tanggal[2],
                'bulan' => $tanggal[1],
                'tahun' => $tanggal[0]
            ]
        ]);
    }

    public function createTiket(Request $request){
        $tiket = KamarKosanController::sewa($request);
		
        return redirect()->route('lihat.tiket',['kodetiket' => $tiket->kode]);
    }

}
