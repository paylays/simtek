<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
  
class AuthController extends Controller
{
    public function register()
    {
        return view('auth/register');
    }
  
    public function registerSave(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password|min:6',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi harus memiliki minimal 6 karakter.',
            'password_confirmation.required' => 'Konfirmasi kata sandi wajib diisi.',
            'password_confirmation.same' => 'Konfirmasi kata sandi tidak cocok.',
            'password_confirmation.min' => 'Konfirmasi kata sandi harus memiliki minimal 6 karakter.',
        ]);
  
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('register')->with('success', 'Registrasi berhasil');
    }
  
    public function login()
    {
        return view('auth/login');
    }
  
    public function loginAction(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus memiliki minimal 6 karakter.',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('login')->with('success', 'Login berhasil');
        }
    
        \Log::info('Gagal login', $credentials);
        return back()->withInput()->with('error', 'Email atau password salah. Mohon cek kembali');
    }
    
  
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
  
        $request->session()->invalidate();
  
        return redirect('login');
    }
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
        ]);

        try {
            // Mengambil data pengguna yang sedang login
            $user = Auth::user();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
    
            return redirect()->to(url()->previous())->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()
                ->to(url()->previous())
                ->withErrors(['error' => 'Terjadi kesalahan saat memperbarui profil. Silakan coba lagi.']);
        }
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:6|',
            'new_password_confirmation' => 'required|same:new_password|min:6',

        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'current_password.current_password' => 'Kata sandi saat ini salah.',
            'new_password.required' => 'Kata sandi baru wajib diisi.',
            'new_password.min' => 'Kata sandi baru harus minimal 6 karakter.',
            'new_password_confirmation.required' => 'Konfirmasi kata sandi wajib diisi.',
            'new_password_confirmation.same' => 'Konfirmasi kata sandi tidak cocok.',
            'new_password_confirmation.min' => 'Konfirmasi kata sandi harus memiliki minimal 6 karakter.',
        ]);

        try {
            // Update password
            $user = Auth::user();
            $user->password = bcrypt($request->new_password);
            $user->save();
    
            // Redirect back with success status
            return redirect()->back()->with([
                'success' => 'Password berhasil diubah.',
                'showEditProfile' => true, // Flag to reopen the Edit Profile modal
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan. Silakan coba lagi.']);
        }
    }
}