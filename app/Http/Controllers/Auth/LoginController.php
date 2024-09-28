<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        // Override Login menggunakan NIK
        $request->validate([
            'nik' => 'required|string',
            'password' => 'required|string'
        ]);

        $credentials = $request->only('nik', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Set Session untuk Gelombang yang dipilih
            session(['gelombang_id' => $request->gelombang]);

            return redirect()->intended('dashboard');
        }

        return back()->with([
            'loginError' => 'nik atau Password salah',
        ]);
    }
}
