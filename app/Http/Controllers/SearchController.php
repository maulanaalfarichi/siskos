<?php

namespace Bukosan\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{

    /**
     * Menampilkan halaman pencarian berdasarkan lokasi dan kriteria
     *
     * @param $location
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function SearchPage($location, Request $request = null)
    {
        $hasil = $this->SearchResult($location, $request);
        return view('public.search')->with('hasil',$hasil);
    }

    public function SearchResult($location, Request $request = null,$json = false)
    {
        return Kosan::Search($location,$request->all());
    }

}
