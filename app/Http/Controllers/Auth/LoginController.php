<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\SAPServices;
use App\Models\User;

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

    /**
     * Get the login username to be used by the controller.
     * 
     * @return string
     */
    protected function redirectTo()
    {
        session()->flash('success', 'You are logged in!');
        return $this->redirectTo;
    }

    /**
     * Send the response after the user was authenticated.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $loginField = $this->username();
        $userExists = User::where($loginField, $request->username)->exists();

        if (!$userExists) {
            throw ValidationException::withMessages([
                'username' => ['Akun dengan username atau email ini tidak ditemukan.'],
            ]);
        }

        throw ValidationException::withMessages([
            'password' => ['Password yang dimasukkan salah.'],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     * 
     * @return string
     */
    public function username()
    {
        $login = request()->input('username');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$field => $login]);
        return $field;
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (Auth::attempt($request->only($this->username(), 'password'), $request->filled('remember'))) {
            $database = $request->input('database'); // Ambil database dari request

            // Hapus session lama jika user berpindah database
            $oldCompanyDB = session('sap_company_db');
            if ($oldCompanyDB && $oldCompanyDB !== $database) {
                app(SAPServices::class)->logout(); // Logout session lama
                Cache::forget('sap_session_' . Auth::id() . '_' . $oldCompanyDB);
            }

            // Simpan database baru ke session
            session(['sap_company_db' => $database]);

            // Login ke SAP dengan database baru
            $sapService = app(SAPServices::class);
            $loginResult = $sapService->login($database);

            if ($loginResult === true) {
                return redirect()->intended($this->redirectPath());
            }

            // Jika login SAP gagal, logout dari Laravel
            Auth::logout();
            session()->forget('sap_company_db');

            return back()->withErrors(['sap' => 'Login ke SAP gagal, silakan coba lagi.']);
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $companyDB = session('sap_company_db'); // Ambil database aktif dari session
        $cacheKey = 'sap_session_' . auth()->id() . '_' . $companyDB;
        try {
            if ($companyDB && Cache::has($cacheKey)) {
                app(SAPServices::class)->logout(); // Logout dari SAP
                Cache::forget($cacheKey); // Hapus session SAP di cache
            }
            Cache::flush();
        } catch (\Exception $e) {
            Log::error('SAP logout error: ' . $e->getMessage());
        }

        // Hapus semua session Laravel
        session()->flush(); // Hapus semua data di session
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('status', 'You have been logged out.');
    }
}
