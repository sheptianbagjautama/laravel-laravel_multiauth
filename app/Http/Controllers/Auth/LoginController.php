<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    //ketika user barhasil login akan di arahkan ke /home
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //ketika user sudah login maka tidak bisa mengakses halaman login lagi
        //halaman login dapat diakses jika belum login
        //middleware guest ini tidak berlaku untuk logout karena method logout dibutuhkan ketika login
        $this->middleware('guest')->except(['logout','logoutUser']);
    }

    //Tambahan untuk projek multiauth
    //tidak menggunakan bawaan method dari laravel, tapi disini independen membuat method baru
    public function logoutUser()
    {
        Auth::guard('web')->logout();
//        $request->session()->invalidate(); //inilah yang menyebabkan semua role logout semua
        return redirect('/');
    }


}
