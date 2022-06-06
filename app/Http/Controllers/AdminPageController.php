<?php

namespace Bukosan\Http\Controllers;

use Bukosan\Model\KamarKosan;
use Bukosan\Model\Kosan;
use Bukosan\User;
use Illuminate\Http\Request;
use Bukosan\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminPageController extends Controller
{

    public function kelolaKosan(Request $request)
    {
		$view = view('admin.kelolakosan');
		$kosan = Kosan::paginate(10);
		if(!is_null($request->get('nama'))){
			$kosan = DB::table('kosan')
						->whereRaw('lower(nama) LIKE \'%'.strtolower($request->get('nama')).'%\'')
						->paginate(10);
			$view->with('cari',$request->get('nama'));
		}
        return $view->with('kosan',$kosan);
    }

    /**
     * Mengelola kamar dai kosan tertentu
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function kelolaKamar($id,Request $request)
    {
		$view = view('admin.kelolakamar');
		$kosan = Kosan::find($id);
		$kamar = KamarKosan::where('idkosan', $id)->paginate(10);
		if(!is_null($request->get('nama'))){
			$kamar = DB::table('kamar_kosan')
						->whereRaw('lower(nama) LIKE \'%'.strtolower($request->get('nama')).'%\'')
						->paginate(10);
			$view->with('cari',$request->get('nama'));
		}
        return $view->with('kosan',$kosan)
					->with('kamar',$kamar);
    }

    public function kelolaUser(Request $request)
{
    $view = view('admin.kelolauser');
    $users = User::where('admin',false)->paginate(10);
    if(!is_null($request->get('nama'))){
        $users = DB::table('user')
            ->whereRaw('lower(displayname) LIKE \'%'.strtolower($request->get('nama')).'%\'')
            ->paginate(10);
        $view->with('cari',$request->get('nama'));
    }
    return $view->with('users',$users);
}

}
