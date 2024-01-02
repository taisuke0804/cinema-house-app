<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Screen;
use App\Models\Movie;
use App\Models\Seat;
use App\Http\Requests\ScreenRequest;
use Carbon\Carbon;

class ScreenController extends Controller
{
  public function index()
  {
    return view('admin.screens.index');
  }

  public function create($movie_id)
  {
    $movie = Movie::findOrFail($movie_id);

    return view('admin.screens.create')->with([
      'movie' => $movie,
    ]);
  }

  public function store(ScreenRequest $request, $movie_id)
  {
    $movie = Movie::findOrFail($movie_id);

    
    $screen = Screen::create([
      'screening_date' => $request->screening_date,
      'start_time' => $request->start_time,
      'end_time' => $request->end_time,
      'movie_id' => $movie->id,
    ]);
    
    $year = Carbon::parse($request->screening_date)->year;
    $month = Carbon::parse($request->screening_date)->month;
    $screening_date = Carbon::parse($request->screening_date)->format('Y年m月d日');

    return redirect()->route('admin.screens.index', [
      'year' => $year,
      'month' => $month,
    ])->with([
      'screen_flash_message' => $screening_date . 'の上映スケジュールを登録しました。',
    ]);
  }

  public function show($screen_id)
  {
    $screen = Screen::findOrFail($screen_id);
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

    return view('admin.screens.show')->with([
      'screen' => $screen,
      'screening_date' => $screening_date,
      'seat_num' => $seat_num,
    ]);
  }
}
