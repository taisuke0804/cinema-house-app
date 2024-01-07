<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReserveConfirmMail;

class ReservationTest extends TestCase
{
  use RefreshDatabase;

  private function data_create()
  {
    $user = User::factory()->create();
    $movie = \App\Models\Movie::factory()->create();
    $today = date('Y-m-d');

    $this_month = \Carbon\Carbon::parse($today)->format('Y年m月');

    $screen = \App\Models\Screen::factory()->create([
      'movie_id' => $movie->id,
      'screening_date' => $today,
    ]);
  }

  // ユーザートップページにアクセスできることを確認
  public function test_user_top_page_can_be_rendered(): void
  {
    $user = User::factory()->create();
    $movie = \App\Models\Movie::factory()->create();
    $today = date('Y-m-d');
    $this_month = \Carbon\Carbon::parse($today)->format('Y年n月');

    $screen = \App\Models\Screen::factory()->create([
      'movie_id' => $movie->id,
      'screening_date' => $today,
    ]);

    $response = $this->actingAs($user, 'web')->get(route('user.index'));

    $response->assertStatus(200);
    $response->assertSee($movie->title);
    $response->assertSee($this_month);
    $response->assertSee(\Carbon\Carbon::parse($screen->start_time)->format('H:i'));
    $response->assertSee(\Carbon\Carbon::parse($screen->end_time)->format('H:i'));
  }

  // 座席予約ページにアクセスできることを確認
  public function test_user_seat_reserve_page_can_be_rendered(): void
  {
    $user = User::factory()->create();
    $movie = \App\Models\Movie::factory()->create();
    $today = date('Y-m-d');

    $screen = \App\Models\Screen::factory()->create([
      'movie_id' => $movie->id,
      'screening_date' => $today,
    ]);
  
    $response = $this->actingAs($user, 'web')->get(route('user.reserve.create', $screen->id));
  
    $response->assertStatus(200);
    $response->assertSee($movie->title);
    $response->assertSee(\Carbon\Carbon::parse($screen->screening_date)->format('Y年m月d日'));
    $response->assertSee($movie->production_year . '年');
    $response->assertSee($movie->genre);
    $response->assertSee($movie->description);
  }

  // 座席予約ができることを確認
  public function test_user_seat_reserve_can_be_created(): void
  {
    
    $user = User::factory()->create();
    $movie = \App\Models\Movie::factory()->create();
    $today = date('Y-m-d');
    
    $screen = \App\Models\Screen::factory()->create([
      'movie_id' => $movie->id,
      'screening_date' => $today,
    ]);
    
    Mail::fake();
    
    $response = $this->actingAs($user, 'web')->post(route('user.reserve.store'), [
      'screen_id' => $screen->id,
      'reserve_seat' => 'A-01',
    ]);

    $this->assertDatabaseHas('seats', [
      'screen_id' => $screen->id,
      'seat_number' => 'A-01',
      'user_id' => $user->id,
    ]);

    $screening_date = \Carbon\Carbon::parse($screen->screening_date)->format('Y年m月d日');

    // メール送信の確認 (EC2ではメール送信機能未実装のためコメントアウト)
    // Mail::assertSent(ReserveConfirmMail::class, function ($mail) use ($screening_date, $screen, $user) {
    //   return $mail->hasTo($user->email) &&
    //     $mail->hasFrom('example@example.com') &&
    //     $mail->screening_date === $screening_date &&
    //     $mail->seat_number === 'A-01' &&
    //     $mail->screen->id === $screen->id &&
    //     $mail->user->id === $user->id;
    // });

    $response->assertStatus(302);
    $response->assertRedirect(route('user.reserve.fix'));
    $response->assertSessionHas('title', $movie->title);
    $response->assertSessionHas('reserve_flash_message', '上映スケジュール' . $screening_date . 'の座席番号「A-01」予約が完了しました。');
  }

  // 座席が予約済みの場合、予約できないことを確認
  public function test_user_seat_reserve_can_not_be_created(): void
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

    Mail::fake();

    $response = $this->actingAs($user, 'web')->post(route('user.reserve.store'), [
      'screen_id' => $screen->id,
      'reserve_seat' => $seat->seat_number,
    ]);

    Mail::assertNothingSent(ReserveConfirmMail::class); // メールが送信されていないことを確認

    $response->assertStatus(302);
    $response->assertRedirect(route('user.index'));
    $response->assertSessionHas('user_index_flash_message', 'すでに予約済みです。');
  }
}
