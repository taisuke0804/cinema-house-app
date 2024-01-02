<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
  public function index()
  {
    $auth = '';
    if(Auth::guard('web')->check()) {
      $auth = 'user';
    }elseif(Auth::guard('admin')->check()) {
      $auth = 'admin';
      return redirect()->route('admin.dashboard');
    }else {
      return redirect('/');
    }

    return view('user.index')->with(['auth' => $auth,]);
  }
}
