<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth:admin')->except('showLoginForm', 'login'); // ログインしていない状態でログイン画面にアクセスできるようにする

    $this->middleware('guest:admin')->only('showLoginForm', 'login'); // ログインしている状態でログイン画面にアクセスできないようにする
  }

  public function showLoginForm()
  {
    return view('admin.login');
  }

  public function login(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required|min:8',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::guard('admin')->attempt($credentials)) {
      $request->session()->regenerate(); // セッションIDを再生成する

      return redirect()->intended('/admin/dashboard'); // intended()は、直前にアクセスしようとしていたURLへリダイレクトする
    }

    return back()->withErrors([
      'email' => 'メールアドレスかパスワードが間違っています。',
    ]);
  }

  public function logout(Request $request)
  {
    Auth::guard('admin')->logout(); // ログアウトする

    $request->session()->invalidate(); // セッションを無効化する

    $request->session()->regenerateToken(); // CSRFトークンを再生成する

    return redirect('/admin/login');
  }

  public function dashboard()
  {
    $movies_count = \App\Models\Movie::count();
    $screens_count = \App\Models\Screen::count();
    $seats_count = \App\Models\Seat::count();

    return view('admin.dashboard')->with([
      'movies_count' => $movies_count,
      'screens_count' => $screens_count,
      'seats_count' => $seats_count,
    ]);
  }
}
