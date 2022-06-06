<?php

namespace Bukosan\Http\Controllers;

use Bukosan\Model\KamarKosan;
use Illuminate\Http\Request;
use Bukosan\Model\RiwayatSewa;

class TiketController extends Controller
{

    public function verifikasi(Request $request)
    {
        $kodetiket = $request->kode;
        $tiket = RiwayatSewa::where('kode',$kodetiket)->first();

        $kamarkosan = KamarKosan::find($tiket->idkamar);
        $kamarkosan->tersedia = true;

        $tiket->status = 'SL';
        $tiket->save();
        return redirect()->back();
    }

}
