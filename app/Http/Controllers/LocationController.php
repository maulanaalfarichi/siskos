<?php

namespace Bukosan\Http\Controllers;

use Illuminate\Http\Request;
use Bukosan\Model\Lokasi\Provinsi;
use Bukosan\Model\Lokasi\KotaKab;
use Bukosan\Model\Lokasi\Kecamatan;
use Bukosan\Model\Lokasi\Kelurahan;

class LocationController extends Controller
{

    public function DaftarKotaKab($idprovinsi){
        $provinsi = Provinsi::find($idprovinsi);
        return KotaKab::where('idprovinsi',$provinsi->id)->get()->toJson();
    }

    public function DaftarKecamatan($idkotakab){
        $kotakab = KotaKab::find($idkotakab);
        return Kecamatan::where('idkotakab',$kotakab->id)->get()->toJson();
    }

    public function DaftarKelurahan($idkecamatan){
        $kecamatan = Kecamatan::find($idkecamatan);
        return Kelurahan::where('idkecamatan',$kecamatan->id)->get()->toJson();
    }

}
