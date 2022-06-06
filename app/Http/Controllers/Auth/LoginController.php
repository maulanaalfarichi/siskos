<?php

namespace Bukosan\Http\Controllers\Auth;

use Bukosan\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest',['except' => ['logout']]);
    }

    public function username()
    {
        return 'username';
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Melakukan proses validasi
     *
     * @param array $data
     * @return mixed
     */
    private function Validator(array $data)
    {
        return Validator::make($data,[
            'username' => 'required|max:10|min:5',
            'password' => 'required'
        ]);
    }

    /**
     * Proses login user
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function Process(Request $request)
    {
        if($this->Validator($request->toArray())) {
            // Login menggunakan username dan password
            if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                return redirect(route('homepage'));
            }
        }
        return back()->withInput()->withErrors($this->Validator($request->toArray()));
    }

}
