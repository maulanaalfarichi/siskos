<?php

namespace Bukosan\Http\Controllers;

use Bukosan\User;

class UserController extends Controller
{

    public function tangguhkan($id)
    {
        $user = User::find($id);
        $user->ditangguhkan = !$user->ditangguhkan;
        $user->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
		return User::destroy($id);	
    }

}
