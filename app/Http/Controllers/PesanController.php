<?php

namespace Bukosan\Http\Controllers;

use Illuminate\Http\Request;
use Bukosan\Model\Pesan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PesanController extends Controller
{
    
	public function kirim(Request $request){
		Pesan::create([
			'idfrom' => Auth::user()->id,
			'idto' => $request->to,
			'isi' => $request->message,
			'waktu' => Carbon::now(),
		]);
		
		return json_encode([
			'status' => 1
		]);
	}
	
	public function getPercakapan(Request $request){
		return Pesan::getPercakapan($request->id);
	}
	
}
