<?php

namespace Bukosan\Http\Controllers;

use Bukosan\Model\KamarKosan;
use Illuminate\Http\Request;
use Bukosan\Model\RiwayatSewa;

class RiwayatSewaController extends Controller
{

    /**
     * Melakukan verifikasi tiket
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifikasi(Request $request)
    {
        $riwayat = RiwayatSewa::where('kode',$request->kode)->first();
        $riwayat->status = 'SL';
        $riwayat->save();

        $kamar = KamarKosan::find($riwayat->idkamar);
        $kamar->tersedia = true;
        $kamar->save();

        return redirect()->back();
    }

}
