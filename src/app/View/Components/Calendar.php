<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Carbon\Carbon;
use App\Models\Screen;

class Calendar extends Component
{
  private $today;
  private $firstDay;
  private $lastDay;
  private $screens;

  public $auth;

  /**
   * Create a new component instance.
   */
  public function __construct($auth = null)
  {
    $this->auth = $auth;
    
    $query = request()->query();

    
    if(empty($query)){
      $this->today = Carbon::today(); // 当日の日付を取得
    }else{
      if(!isset($query['year']) || !isset($query['month'])){
        return \App::abort(404);
      }
      $this->today = Carbon::create($query['year'], $query['month'], 1); // クエリパラメーターの年月を取得
    }

    $this->firstDay = $this->today->copy()->firstOfMonth(); // 月初の日付を取得
    $this->lastDay = $this->today->copy()->lastOfMonth(); // 月末の日付を取得

    // 月初の日付から月末の日付までのScreenを取得(リレーション先も取得)
    $this->screens = Screen::whereBetween('screening_date', [$this->firstDay, $this->lastDay])->with('movie')->get();
  }

  //１週間分のそれぞれの日にちのデータを$daysに格納しreturn
  public function weekInfoGet($date)
  {
    $days = [];

    $startDay = $date->copy()->startOfWeek(); // 週初の日付を取得
    $endDay = $date->copy()->endOfWeek(); // 週末の日付を取得

    $tmpDay = $startDay->copy(); // 週初の日付をコピー

    for($i = 0; $i < 7; $i++) {
      $days[$i]['day'] = $tmpDay->copy(); // 週初の日付から週末の日付までを$daysに格納
      // 該当日付のScreenを取得
      $tmpDayScreens = $this->screens->where('screening_date', $tmpDay->format('Y-m-d'))->toArray();
      $tmpDayScreens = array_values($tmpDayScreens); // 連想配列のキーを振り直す(0から始まる
      
      $days[$i]['screen'] = $tmpDayScreens;

      $days[$i]['current_month'] = $tmpDay->isSameMonth($this->today) ? true : false; // 当月の日付かどうか
      
      $tmpDay->addDay(); // 1日進める
    }

    return $days;
  }

  /**
   * Get the view / contents that represent the component.
   */
  public function render(): View|Closure|string
  {
    // 月のデータを取得
    $weeks = [];
    $weeks[] = $this->weekInfoGet($this->firstDay);

    $tmpDay = $this->firstDay->copy()->addDay(7); // 1週間進める

    // 月の週数分繰り返す
    while($tmpDay->startOfWeek() < $this->lastDay) {
      $weeks[] = $this->weekInfoGet($tmpDay);
      $tmpDay->addDay(7); // 1週間進める
    }

    return view('calendar')->with([
      'weeks' => $weeks,
      'today' => $this->today,
      'firstDay' => $this->firstDay,
      'lastDay' => $this->lastDay,
      'auth' => $this->auth,
    ]);
  }
}
