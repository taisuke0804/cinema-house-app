<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Screen;
use App\Models\Seat;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Mail\ReserveConfirmMail;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
  public function reserve_create($screen_id)
  {
    $screen = Screen::findOrFail($screen_id);

    $user = \Auth::guard('web')->user();
    // $userで該当のscreen_idを持っているか確認
    $user_seat = $user->seats()->where('screen_id', $screen_id)->first();

    $screening_date = Carbon::parse($screen->screening_date)->format('Y年m月d日');

    $seat_num = \App\Consts\SeatNum::SEAT_NUM;

    $seats_info = Seat::with(['user'])->where('screen_id', $screen_id)->get()->toArray(); 
    $reserved_seats = array_column($seats_info, 'seat_number'); // 予約済みの座席番号を取得

    // 予約済みの座席番号を$seat_numに反映
    foreach ($seat_num as $num => $value) {
      if (in_array($num, $reserved_seats)) {
        $seat_num[$num]['reserved'] = true;
        $seats_info_key = array_search($num, array_column($seats_info, 'seat_number')); 
        $user_info_array = $seats_info[$seats_info_key];
        $seat_num[$num]['user'] = $user_info_array;
      }
    }

    $not_reserved_seats = array();
    // 予約されてない座席番号を配列で取得
    foreach ($seat_num as $num => $value) {
      if($value['reserved'] == false) {
        $not_reserved_seats[] = $num;
      }
    }

    return view('user.reserve.create')->with([
      'screen' => $screen,
      'screening_date' => $screening_date,
      'seat_num' => $seat_num,
      'not_reserved_seats' => $not_reserved_seats,
      'user_seat' => $user_seat,
    ]);
  }

  public function reserve_store(Request $request)
  {
    $seatNum = array_keys(\App\Consts\SeatNum::SEAT_NUM);
    $request->validate([
      'reserve_seat' => ['required', Rule::in($seatNum)],
      'screen_id' => ['required', 'exists:screens,id'],
    ]);

    $user = \Auth::guard('web')->user();
    $screen_id = request('screen_id');
    $screen = Screen::findOrFail($screen_id);
    $seat_number = request('reserve_seat');

    $user_seat = $user->seats()->where('screen_id', $screen_id)->first();
    if ($user_seat) {
      return redirect()->route('user.index')->with([
        'user_index_flash_message' => 'すでに予約済みです。',
      ]);
    }
    
    $seat = Seat::create([
      'screen_id' => $screen_id,
      'user_id' => $user->id,
      'seat_number' => $seat_number,
    ]);

    $screening_date = Carbon::parse($screen->screening_date)->format('Y年m月d日');

    // Mail::to($user->email)
    //   ->send(new ReserveConfirmMail($screening_date, $seat_number, $screen, $user));

    return redirect()->route('user.reserve.fix')->with([
      'reserve_flash_message' => '上映スケジュール' . $screening_date . 'の座席番号「' . $seat_number . '」予約が完了しました。',
      'title' => $screen->movie->title,
    ]);
  }

  public function reserve_fix()
  {
    $title = session('title');
    $reserve_flash_message = session('reserve_flash_message');

    return view('user.reserve.fix')->with([
      'title' => $title,
      'reserve_flash_message' => $reserve_flash_message,
    ]);
  }
    
}
