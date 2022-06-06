<?php

namespace Bukosan\Http\Controllers;

use Bukosan\Model\Favorit;
use Bukosan\Model\Pesan;
use Bukosan\Model\RiwayatKunjungan;
use Illuminate\Http\Request;
use Bukosan\User;
use Bukosan\Model\Kosan;
use Illuminate\Support\Facades\Auth;

class HomePageController extends Controller
{

    /**
     * Untuk mengarahkan user ke halaman awal
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function HomePage()
    {
        return Auth::check() ? $this->UserHomePage() : view('public.home');
    }

    /**
     * Menampilkan halaman awal untuk user yang sudah login
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function UserHomePage()
    {
        $view = view('user.home');
        if (Auth::user()->admin) {
            $view->with('totaluser', User::all()->count());
            $view->with('totalkosan', Kosan::all()->count());
        }
        $view->with('jumlahkosan', Kosan::where('idpemilik', Auth::user()->id)->count())
            ->with('jumlahfavorit', Favorit::where('iduser', Auth::user()->id)->count())
            ->with('pesanbaru', Pesan::where('idto', Auth::user()->id)->where('toread', false)->count())
            ->with('kunjungan',RiwayatKunjunganController::daftarRiwayat()->limit(3)->get());
        return $view;
    }

}
