<?php

namespace Bukosan\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Kosan extends Model
{

    public $timestamps = false;

    protected $table = 'kosan';

    public static function fromLocation($latitude, $longitude)
    {
        $kosan = static::refind()
            ->where('k.latitude', '<=', $latitude + 5)
            ->where('k.latitude', '>=', $latitude - 5)
            ->where('k.longitude', '<=', $longitude + 5)
            ->where('k.longitude', '>=', $longitude - 5);
        return $kosan;
    }

    public static function refind()
    {
        $kosan = DB::table(DB::raw('
            "user" as u,(SELECT * FROM kosan LEFT JOIN (SELECT count(*) AS jumlah, idkosan FROM kamar_kosan WHERE ditangguhkan = false AND tersedia = true GROUP BY idkosan) AS kamar ON kamar.idkosan = kosan.id) AS k LEFT JOIN (SELECT max(harga) AS max,  min(harga) AS min, idkosan FROM kamar_kosan GROUP BY idkosan) AS harga ON harga.idkosan = k.id, (SELECT min(foto.nama) as nama,fk.idkosan FROM foto,foto_kosan as fk WHERE fk.idfoto = foto.id GROUP BY fk.idkosan) as foto, kelurahan as kl, kecamatan as kc, kotakab as kb, provinsi as pv
        '))
            ->whereRaw('u.id = k.idpemilik')
            ->whereRaw('u.ditangguhkan = false')
            ->whereRaw('foto.idkosan = k.id')
            ->whereRaw('kl.idkecamatan = kc.id')
            ->whereRaw('kc.idkotakab = kb.id')
            ->whereRaw('kb.idprovinsi = pv.id')
            ->whereRaw('kl.id = k.kelurahan');

        return $kosan;
    }

    public static function refind2()
    {
        $kosan = DB::table(DB::raw('"kosan" as "k", ( ' .
            DB::table('kamar_kosan')
                ->select(DB::raw('max(harga) as max,min(harga) as min, idkosan'))
                ->groupBy('idkosan')->toSql() . ') as harga , (' .
            DB::table(DB::raw('kosan, foto_kosan, foto'))
                ->whereRaw('foto.id = foto_kosan.idfoto')
                ->whereRaw('kosan.id = foto_kosan.idkosan')
                ->select(DB::raw('min(foto.nama) as nama, kosan.id as idkosan'))
                ->groupBy(DB::raw('kosan.id'))
                ->toSql()
            . ') as foto, (' .
            DB::table('kamar_kosan')
                ->select(DB::raw('count(*) as jumlah, idkosan'))
                ->groupBy('idkosan')
                ->toSql()
            . ') as kamar , kelurahan as kl, kecamatan as kc, kotakab as kt, provinsi as pv'
        ))
            ->whereRaw('k.id = foto.idkosan')
            ->whereRaw('harga.idkosan = k.id')
            ->whereRaw('kamar.idkosan = k.id')
            ->whereRaw('k.kelurahan = kl.id AND kl.idkecamatan = kc.id AND kc.idkotakab = kt.id AND kt.idprovinsi = pv.id');
        return $kosan;
    }

    public static function render($kosan)
    {
        return $kosan
            ->select(DB::raw('k.*, foto.nama as foto, k.jumlah as jumlahkamar, harga.min as hargamin, harga.max as hargamax'))
            ->distinct();
        //->groupBy(DB::raw('kamar.jumlah, k.id, harga.max, harga.min, foto.nama'));
    }

    public static function whereId($id)
    {
        $kosan = static::refind()
            ->where('id', '=', $id);
        return static::render($kosan)
            ->get();
    }

    public static function withAddress($id = null)
    {
        $where = 'ks.kelurahan = kl.id AND kl.idkecamatan = kc.id AND kc.idkotakab = k.id AND k.idprovinsi = p.id';
        $kosan = DB::table(DB::raw('kosan as ks, provinsi as p, kotakab as k, kecamatan as kc, kelurahan as kl'))
            ->select(DB::raw('ks.*, p.nama as provinsi, k.nama as kotakab, kc.nama as kecamatan, kl.nama as kelurahan'));
        if (!is_null($id)) {
            $where .= ' AND ks.id = ' . $id;
        }
        $kosan->whereRaw($where);
        return $kosan;
    }

    public static function getJumlahFavorit($id)
    {
        $fav = DB::table(DB::raw('kosan k, (' .
            DB::table(DB::raw('kamar_kosan as kk, favorit as f'))
                ->select(DB::raw('kk.idkosan, kk.id, count(f) as jumlah'))
                ->whereRaw('f.idkamarkosan = kk.id')
                ->groupBy(DB::raw('kk.id'))
                ->toSql()
            . ') as fav'))
            ->select(DB::raw(' k.id, sum(fav.jumlah) as jumlah'))
            ->whereRaw('fav.idkosan = ' . $id)
            ->groupBy(DB::raw('k.id'));
        if (count($fav->get()) > 0) {
            return $fav->first()->jumlah;
        } else {
            return 0;
        }
    }

    public static function getJumlahSewa($id)
    {
        return DB::table(DB::raw('kamar_kosan as kk LEFT JOIN (SELECT count(riwayat_sewa.kode) as jumlah, idkamar FROM riwayat_sewa GROUP BY riwayat_sewa.idkamar) as rs ON kk.id = rs.idkamar'))
            ->select(DB::raw('count(rs.jumlah) as jumlah'))
            ->groupBy('kk.idkosan')
            ->whereRaw('kk.idkosan = ' . $id)
            ->first();
    }

    public static function cari(Request $request)
    {
        $kosan = static::refind();
        if (!empty($request->get('latitude'))) {
            $kosan = Kosan::fromLocation(
                $request->get('latitude'),
                $request->get('longitude'));
        }
        $kosan->whereRaw('(lower(k.alamat) LIKE \'%' . strtolower($request->get('location')) . '%\' OR lower(kl.nama) LIKE \'%' . strtolower($request->location) . '%\' OR lower(kc.nama) LIKE \'%' . strtolower($request->location) . '%\' OR lower(kb.nama) LIKE \'%' . strtolower($request->location) . '%\' OR lower(pv.nama) LIKE \'%' . strtolower($request->location) . '%\')');
        $kosan->whereRaw('k.terverifikasi = true')
        ->whereRaw('k.ditangguhkan = false')
        ->whereRaw('k.jumlah > 0');
		if ($request->get('filter') == 1) {
            if (!empty($request->jeniskosan)) {
                switch ($request->jeniskosan) {
                    case 1:
                        $kosan = $kosan->where('k.keluarga', false)->where('k.kosanperempuan', false);
                        break;
                    case 2:
                        $kosan = $kosan->where('k.keluarga', false)->where('k.kosanperempuan', true);
                        break;
                    case 3:
                        $kosan = $kosan->where('k.keluarga', true);
                        break;
                }
            }
            if (!empty($request->get('hargamin')) && !is_null($request->get('hargamax'))) {
                $kosan = $kosan->where('harga.min', '>=', $request->get('hargamin'))
                    ->where('harga.max', '<=', $request->get('hargamax'));
            }
            foreach (['tempatparkir', 'dapur', 'jammalam', 'wifi', 'kmdalam', 'lemaries', 'televisi'] as $fasilitas) {
                if (!is_null($request->get($fasilitas)) && $request->get($fasilitas) != 2) {
                    $kosan = $kosan->whereRaw('k.' . $fasilitas . ' = ' . ($request->get($fasilitas) == 1 ? 'true' : 'false'));
                }
            }
        }

        // Mencari kosan
        return static::render($kosan)->paginate(12);
	}

    public static function destroyFromSpecifiedUser($id)
    {
        $daftarkosan = Kosan::where('idpemilik', $id)->pluck('id');
        // Menghapus kamar kosan terlebih dahulu
        foreach ($daftarkosan as $kosan) {
            static::destroy($kosan);
        }
    }

    public static function destroy($id)
    {
        // Menghapus kamar kosan
        KamarKosan::destroyFromSpecifiedKosan($id);
        // Menghapus foto
        FotoKosan::destroyFromSpecifiedKosan($id);
        // Menghapus riwayat kunjungan
        RiwayatKunjungan::destroyFromSpecifiedKosan($id);
        // Menghapus kosan
        static::find($id)->delete();
    }

    public static function deletable($id){
        $kamarkosan = KamarKosan::where('idkosan',$id)->get();
        foreach ($kamarkosan as $kamar){
            if(!KamarKosan::deletable($kamar->id))
                return false;
        }
        return true;
    }

}
