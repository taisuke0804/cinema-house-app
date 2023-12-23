<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Movie;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Screen>
 */
class ScreenFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    // $screening_date = $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+1 years', $timezone = null);
    // $screening_date = $screening_date->format('Y-m-d'); // 日付だけを取り出す

    // 2023年9月1日から2023年10月30日までの間でランダムに時間を生成
    // $screening_date = $this->faker->dateTimeBetween($startDate = '2023-11-01', $endDate = '2023-12-31', $timezone = null);
    $screening_date = $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+3 month', $timezone = null);
    $screening_date = $screening_date->format('Y-m-d'); // 日付だけを取り出す

    $start_time = $this->faker->time($format = 'H:i:s', $max = '20:00:00');
    // $start_timeの時間から2時間後の時間を生成
    $end_time = date('H:i:s', strtotime($start_time . '+2 hour'));

    $movie_id = Movie::inRandomOrder()->first()->id; // moviesテーブルのidをランダムに取得

    return [
      'movie_id' => $movie_id,
      'screening_date' => $screening_date,
      'start_time' => $start_time,
      'end_time' => $end_time,
    ];
  }
}
