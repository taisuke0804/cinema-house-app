<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Seat;

class MypageController extends Controller
{
  public function index()
  {
    $user = \Auth::guard('web')->user();
    $reserves = $user->seats()->with(['screen.movie'])->get()->toArray();

    return view('user.mypage.index')->with([
      'reserves' => $reserves,
    ]);
  }

  public function reserve_cancel(Request $request)
  {
    $seat_id = $request->seat_id;
    $seat = Seat::findOrFail($seat_id);

    $seat->delete(); // 予約をキャンセルする

    return redirect()->route('user.mypage.index')->with([
      'mypage_flash_message' => '予約をキャンセルしました。',
    ]);
  }
}
