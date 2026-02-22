<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;


class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate(
        [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'accepted',
        ],
        [
            'terms.accepted' => 'You must agree to the Terms & Conditions.',
        ]
        );

        $user = User::create([
            'name' => $request->name,
            'username' => User::generateUsername($request->name),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('profile', $user);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

   public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 🔐 Buat key unik (email + IP)
        $throttleKey = Str::lower($request->email).'|'.$request->ip();

        // ⛔ Cek apakah sudah terlalu banyak percobaan
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {

            $seconds = RateLimiter::availableIn($throttleKey);

            return back()->withErrors([
                'email' => 'Too many login attempts. Please try again in '.ceil($seconds/60).' minutes.'
                
            ])->withInput();
        }

        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            RateLimiter::hit($throttleKey, 900); // 900 detik = 15 menit
            return back()->withErrors([
                'email' => 'No account found with this email address.',
            ])->withInput();
        }

        if ($user->isBanned()) {
            return redirect()
                ->route('login')
                ->with('error', 'Your account has been deactivated. Please contact support for more information.');
        }

        if (Auth::attempt($credentials, $request->filled('remember'))) {

            // Reset percobaan jika berhasil login
            RateLimiter::clear($throttleKey);

            $request->session()->regenerate();

            return Auth::user()->is_admin
                ? redirect()->route('admin.home')
                : redirect()->route('home');
        }

        // Tambah hit jika password salah
        RateLimiter::hit($throttleKey, 900);

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput();
    }
    

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

    public function redirectToGoogle()
        {
            return Socialite::driver('google')->redirect();
        }

    public function handleGoogleCallback()
{
    try {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // 1. WAJIB: Gunakan withTrashed() karena model Anda pakai SoftDeletes
        $user = User::withTrashed()->where('email', $googleUser->getEmail())->first();

        if ($user) {
            // 2. Jika user ketemu tapi sedang di-soft delete (banned/hapus), restore akunnya
            if ($user->trashed()) {
                $user->restore();
            }

            // 3. Update data provider jika belum terhubung
            $user->update([
                'provider'    => 'google',
                'provider_id' => $googleUser->getId(),
            ]);
        } else {
            // 4. Jika benar-benar user baru, buat akun
            $user = User::create([
                'name'        => $googleUser->getName(),
                'email'       => $googleUser->getEmail(),
                'username'    => User::generateUsername($googleUser->getName()),
                'password'    => Hash::make(Str::random(32)),
                'provider'    => 'google',
                'provider_id' => $googleUser->getId(),
                'email_verified_at' => now(),
            ]);
        }

        Auth::login($user, true);
        return redirect()->route('home');

    } catch (\Exception $e) {
        // DEBUG: Jika masih gagal, aktifkan baris di bawah untuk melihat pesan error aslinya
        // return dd($e->getMessage()); 
        
        return redirect('/login')->with('error', 'Gagal login: ' . $e->getMessage());
    }
}

}
