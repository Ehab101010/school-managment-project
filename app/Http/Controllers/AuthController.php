<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors(['username' => 'اسم المستخدم غير موجود']);
        }
         
        if (Hash::check($request->password, $user->password)) {
            Auth::login($user);

            $request->session()->regenerate(); 

            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'teacher':
                    return redirect()->route('teacher.dashboard');
                case 'student':
                    return redirect()->route('student.dashboard');
                default:
                    Auth::logout();
                    return back()->withErrors(['role' => 'دور المستخدم غير معروف']);
            }
        } else {
            return back()->withErrors(['password' => 'كلمة المرور غير صحيحة']);
        }
    }
    public function showChangePassword()
    {
        return view('auth.change-password');
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ], [
            'new_password.confirmed' => 'كلمتا المرور الجديدتان غير متطابقتين',
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
            ->with('success', 'تم تغيير كلمة المرور بنجاح، قم بتسجيل الدخول الآن.');
    }
    
    
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
