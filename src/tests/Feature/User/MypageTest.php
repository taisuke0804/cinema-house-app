<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class MypageTest extends TestCase
{
  use RefreshDatabase;

  // マイページにアクセスできることを確認
  public function test_mypage_screen_can_be_rendered(): void
  {
    $user = User::factory()->create();
    $movie = \App\Models\Movie::factory()->create();
    $today = date('Y-m-d');

    $screen = \App\Models\Screen::factory()->create([
      'movie_id' => $movie->id,
      'screening_date' => $today,
    ]);

    $seat = \App\Models\Seat::factory()->create([
      'screen_id' => $screen->id,
      'user_id' => $user->id,
    ]);

    $screening_date = \Carbon\Carbon::parse($screen->screening_date)->format('Y年m月d日');
    $start_time = \Carbon\Carbon::parse($screen->start_time)->format('H時i分');
    $end_time = \Carbon\Carbon::parse($screen->end_time)->format('H時i分');
    $start_end_time = $start_time . ' ~ ' . $end_time;

    $response = $this->actingAs($user, 'web')->get(route('user.mypage.index'));
    $response->assertStatus(200);
    $response->assertSee($movie->title);
    $response->assertSee($screening_date);
    $response->assertSee($start_end_time);
    $response->assertSee($seat->seat_number);
    $response->assertSee('当日こちらの画面をご提示ください。');
  }

  // ログインしていない場合、マイページにアクセスできないことを確認
  public function test_mypage_screen_cannot_be_rendered(): void
  {
    $response = $this->get(route('user.mypage.index'));
    $response->assertStatus(302);
    $response->assertRedirectToRoute('login');
  }

  // マイページで予約した映画のキャンセルができることを確認
  public function test_mypage_seat_can_be_cancel(): void
  {
    $user = User::factory()->create();
    $movie = \App\Models\Movie::factory()->create();
    $today = date('Y-m-d');

    $screen = \App\Models\Screen::factory()->create([
      'movie_id' => $movie->id,
      'screening_date' => $today,
    ]);

    $seat = \App\Models\Seat::factory()->create([
      'screen_id' => $screen->id,
      'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user, 'web')->post(route('user.mypage.reserve_cancel', [
      'seat_id' => $seat->id,
    ]));

    $this->assertDatabaseMissing('seats', [
      'id' => $seat->id,
    ]);

    $response->assertStatus(302);
    $response->assertRedirectToRoute('user.mypage.index');
    $response->assertSessionHas('mypage_flash_message', '予約をキャンセルしました。');
  }
}
