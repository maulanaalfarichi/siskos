<?php

namespace Bukosan\Http\Controllers;

use Bukosan\Model\RiwayatKunjungan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RiwayatKunjunganController extends Controller
{

    /**
     * Menambah ke riwayat kunjungan
     *
     * @param $idkosan
     */
    public static function tambah($idkosan)
    {
        if (Auth::check()) {
            if (RiwayatKunjungan::where('iduser', Auth::user()->id)->where('idkosan', $idkosan)->count() == 0) {
                RiwayatKunjungan::create([
                    "iduser" => Auth::user()->id,
                    "idkosan" => $idkosan
                ]);
            }
        }
    }

    public static function daftarRiwayat()
    {
        $foto = DB::table(DB::raw('foto_kosan AS fk, kosan AS k, foto AS f'))
            ->select(DB::raw('max(f.nama) AS nama,k.id AS idkosan'))
            ->whereRaw('fk.idkosan = k.id AND f.id = fk.idfoto')
            ->groupBy(DB::raw('k.id'))->toSql();

        $harga = DB::table(DB::raw('kamar_kosan AS kk, kosan AS k'))
            ->select(DB::raw('min(kk.harga) AS min, max(kk.harga) AS max, k.id AS idkosan'))
            ->whereRaw('k.id = kk.idkosan')
            ->groupBy(DB::raw('k.id'))->toSql();

        $jumlahkamar = DB::table(DB::raw('kamar_kosan AS kk, kosan AS k'))
            ->select(DB::raw('count(kk.id) as jumlahkamar, k.id as idkosan'))
            ->whereRaw('kk.idkosan = k.id')
            ->groupBy('k.id')->toSql();

        $kosan = DB::table(DB::raw('riwayat_kunjungan AS rk, kosan AS k, (' . $foto . ') as foto, (' . $harga . ') as harga, (' . $jumlahkamar . ') as jumlahkamar'))
            ->select(DB::raw('k.id,k.alamat,k.nama,harga.min as hargamin,foto.nama AS  foto,harga.max as hargamax, jumlahkamar.jumlahkamar, k.keluarga as keluarga'))
            ->whereRaw('rk.iduser = ' . Auth::user()->id . ' AND rk.idkosan = k.id AND foto.idkosan = k.id AND harga.idkosan = k.id AND jumlahkamar.idkosan = k.id')
            ->distinct();

        return $kosan;
    }

}
