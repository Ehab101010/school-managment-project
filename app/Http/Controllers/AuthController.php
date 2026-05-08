<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
     const MAX_ATTEMPTS   = 3;
     const LOCKOUT_SECONDS = 300;

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
         $lockedUntil = $request->session()->get('locked_until');

        if ($lockedUntil) {
            $remaining = $lockedUntil - now()->timestamp;

            if ($remaining > 0) {
                return back()
                    ->with('lockout', true)
                    ->with('lockout_remaining', $remaining);
            }

             $request->session()->forget(['locked_until', 'login_attempts', 'attempts']);
        }

         $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors(['username' => 'اسم المستخدم غير موجود']);
        }

         if (Hash::check($request->password, $user->password)) {

             $request->session()->forget(['login_attempts', 'attempts', 'locked_until']);

            Auth::login($user);
            $request->session()->regenerate();

            switch ($user->role) {
                case 'admin':           return redirect()->route('admin.dashboard');
                case 'student_affairs': return redirect()->route('sa.dashboard');
                case 'teacher':         return redirect()->route('teacher.dashboard');
                case 'student':         return redirect()->route('student.dashboard');
                case 'parent':          return redirect()->route('parent.dashboard');
                default:
                    Auth::logout();
                    return back()->withErrors(['role' => 'دور المستخدم غير معروف']);
            }
        }

         $attempts = $request->session()->get('login_attempts', 0) + 1;
        $request->session()->put('login_attempts', $attempts);
        $request->session()->put('attempts', $attempts);

         if ($attempts >= self::MAX_ATTEMPTS) {
            $unlockAt = now()->timestamp + self::LOCKOUT_SECONDS;
            $request->session()->put('locked_until', $unlockAt);
            $request->session()->forget('login_attempts');

            return back()
                ->with('lockout', true)
                ->with('lockout_remaining', self::LOCKOUT_SECONDS);
        }

        return back()
            ->withErrors(['password' => 'كلمة المرور غير صحيحة'])
            ->with('attempts', $attempts);
    }

     public function showChangePassword()
    {
        return view('auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'username'     => 'required|string',
            'old_password' => 'required|string',
            'new_password' => [
                'required',
                'confirmed',
                Password::min(8)          
                    ->letters()           
                    ->mixedCase()         
                    ->numbers()        
                    ->symbols(),           
            ],
        ], [
            'new_password.required'  => 'حقل كلمة المرور الجديدة مطلوب',
            'new_password.confirmed' => 'كلمتا المرور الجديدتان غير متطابقتين',
            'new_password.min'       => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل',
            'new_password.mixed_case'=> 'يجب أن تحتوي على حرف كبير وحرف صغير',
            'new_password.letters'   => 'يجب أن تحتوي على أحرف',
            'new_password.numbers'   => 'يجب أن تحتوي على أرقام',
            'new_password.symbols'   => 'يجب أن تحتوي على رمز خاص (!@#$%...)',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors(['username' => 'اسم المستخدم غير موجود']);
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'كلمة المرور القديمة غير صحيحة']);
        }

        $user->password = $request->new_password;
        $user->save();

        return redirect()->route('login')
            ->with('success', '✓ تم تغيير كلمة المرور بنجاح. سجّل دخولك الآن.');
    }

     public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}