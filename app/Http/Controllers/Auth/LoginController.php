<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\SAPServices;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Log;

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
            $database = $request->input('database');

            // Login ke SAP
            $sapService = app(SAPServices::class);
            $loginResult = $sapService->login($database);

            if ($loginResult === true) {
                return redirect()->intended($this->redirectPath());
            }

            // Jika login SAP gagal, logout dari Laravel
            Auth::logout();

            // Pastikan $loginResult adalah string
            $errorMessage = is_string($loginResult) ? $loginResult : 'Login ke SAP gagal, silakan coba lagi.';

            return back()->withErrors(['sap' => $errorMessage]);
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
        if (session()->has('sap_session_id')) {
            try {
                app(SAPServices::class)->logout();
            } catch (\Exception $e) {
                // Log the error but continue with logout
                Log::error('SAP logout error: ' . $e->getMessage());
            }
        }

        // Hapus session SAP & database
        session()->forget(['sap_session_id']);

        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
