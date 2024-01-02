<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Screen;
use App\Models\User;
use App\Models\Seat;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seat>
 */
class SeatFactory extends Factory
{
  private function generate_seat_number(): string
  {
    // A-01 ~ B-10の文字列を生成
    $alphabet = chr(rand(65, 66)); // AかBをランダムに生成
    $number = str_pad(rand(1, 10), 2, '0', STR_PAD_LEFT); // 01 ~ 10の数字をランダムに生成

    $seat_number = $alphabet . '-' . $number;

    return $seat_number;
  }

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $screen_id = Screen::inRandomOrder()->first()->id; 
    $user_id = User::inRandomOrder()->first()->id; 

    $seat_number = $this->generate_seat_number();

    // $screen_idと$seat_numberの組み合わせが一意になるようにする
    while (true) {
      $seat = Seat::where('screen_id', $screen_id)->where('seat_number', $seat_number)->first(); // 一致するレコードがあるか検索
      if (empty($seat)) {
        break;
      }
      
      $seat_number = $this->generate_seat_number();
    }

    // $screen_idと$user_idの組み合わせが一意になるようにする
    while (true) {
      $seat = Seat::where('screen_id', $screen_id)->where('user_id', $user_id)->first(); // 一致するレコードがあるか検索
      if (empty($seat)) {
        break;
      }
      
      $user_id = User::inRandomOrder()->first()->id; 
    }

    return [
      'screen_id' => $screen_id,
      'seat_number' => $seat_number,
      'user_id' => $user_id,
    ];
  }
}
