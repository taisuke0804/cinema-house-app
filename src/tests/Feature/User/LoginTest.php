<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
  use RefreshDatabase;

  public function test_login_screen_can_be_rendered(): void
  {
    $response = $this->get('/login');

    $response->assertStatus(200);
  }

  public function test_users_can_authenticate_using_the_login_screen(): void
  {
    $user = User::factory()->create();

    $response = $this->post('/login', [
      'email' => $user->email,
      'password' => 'password',
    ]);

    $this->assertAuthenticated($guard = 'web'); // ログインしているかどうか
    $response->assertRedirectToRoute('user.index');
  }

  // 必須項目が空の場合
  public function test_login_required_input_empty(): void
  {
    $response = $this->post('/login', [
      'email' => '',
      'password' => '',
    ]);

    $response->assertSessionHasErrors([
      'email' => 'メールアドレスは必須です。',
      'password' => 'パスワードは必須です。',
    ]);
  }

  // メールアドレスが一致しない場合
  public function test_login_email_not_match(): void
  {
    $user = User::factory()->create([
      'email' => 'test@gmail.com'
    ]);

    $response = $this->post('/login', [
      'email' => 'wrong_address@gmail.com',
      'password' => 'password',
    ]);

    $response->assertSessionHasErrors([
      'email' => 'メールアドレスまたはパスワードが一致しません。',
    ]);

    $this->assertGuest($guard = 'web'); // ユーザーが認証されていないことを確認
    $response->assertStatus(302);
  }

  // パスワードが一致しない場合
  public function test_login_password_not_match(): void
  {
    $user = User::factory()->create([
      'password' => bcrypt('password')
    ]);

    $response = $this->post('/login', [
      'email' => $user->email,
      'password' => 'wrong_password',
    ]);

    $response->assertSessionHasErrors([
      'email' => 'メールアドレスまたはパスワードが一致しません。',
    ]);

    $this->assertGuest($guard = 'web'); // ユーザーが認証されていないことを確認
    $response->assertStatus(302);
  }
}
