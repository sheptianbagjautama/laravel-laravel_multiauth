<?php

namespace App\Http\Controllers\AuthAdmin;

use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;


//tambahan untuk projek multiauth
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function __construct()
    {
        //ketika user sudah login maka tidak bisa mengakses halaman login lagi
        //halaman login dapat diakses jika belum login
        //middleware guest ini tidak berlaku untuk logout karena method logout dibutuhkan ketika login
        $this->middleware('guest:admin')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    //Tambahan untuk projek multiauth
    public function showLoginForm()
    {
        return view('authAdmin.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */

    //Tambahan untuk projek multiauth
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        $credential = [
            'email' => $request->email,
            'password' => $request->password
        ];
        // Attempt to log the user in
        if (Auth::guard('admin')->attempt($credential, $request->member)){
            // If login succesful, then redirect to their intended location
            return redirect()->intended(route('admin.home'));
        }
        // If Unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    //Tambahan untuk projek multiauth
    //tidak menggunakan bawaan method dari laravel, tapi disini independen membuat method baru
    public function logout()
    {
        Auth::guard('admin')->logout();
//        $request->session()->invalidate(); //inilah yang menyebabkan semua role logout semua
        return redirect('/');
    }




}
