<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
  use RefreshDatabase;

  public function test_registration_screen_can_be_rendered(): void
  {
    $response = $this->get('/register');

    $response->assertStatus(200);
  }

  public function test_new_users_can_register(): void
  {
    $response = $this->post('/register', [
      'name' => 'Test User',
      'email' => 'test@example.com',
      'password' => 'password',
      'password_confirmation' => 'password',
      'phone' => '090-1234-5678',
    ]);

    $this->assertAuthenticated($guard = 'web');
    $response->assertRedirectToRoute('user.index'); // ユーザートップページにリダイレクトされることを確認
    $response->assertStatus(302);
  }

  // 必須項目が空の場合
  public function test_registration_required_input_empty(): void
  {
    $response = $this->post('/register', [
      'name' => '',
      'email' => '',
      'password' => '',
      'password_confirmation' => '',
      'phone' => '090-1234-5678',
    ]);

    $response->assertSessionHasErrors([
      'name' => '名前は必須です。',
      'email' => 'メールアドレスは必須です。',
      'password' => 'パスワードは必須です。',
    ]);

    $this->assertGuest($guard = null); // ユーザーが認証されていないことを確認
  }

  // メールアドレスが不正な場合
  public function test_registration_email_invalid(): void
  {
    $response = $this->post('/register', [
      'name' => 'Test User',
      'email' => 'test',
      'password' => 'password',
      'password_confirmation' => 'password',
      'phone' => '090-1234-5678',
    ]);

    $response->assertSessionHasErrors([
      'email' => 'メールアドレスには、有効なメールアドレスを指定してください。',
    ]);

    $this->assertGuest($guard = null); // ユーザーが認証されていないことを確認
  }

  // メールアドレスが重複している場合
  public function test_registration_email_duplicate(): void
  {
    User::factory()->create([
      'email' => 'test@example.com'
    ]);

    $response = $this->post('/register', [
      'name' => 'Test User',
      'email' => 'test@example.com',
      'password' => 'password',
      'password_confirmation' => 'password',
      'phone' => '090-1234-5678',
    ]);

    $response->assertSessionHasErrors([
      'email' => 'メールアドレスは既に使用されています。',
    ]);

    $this->assertGuest($guard = null); // ユーザーが認証されていないことを確認
  }

  // パスワードが確認用と一致しない場合
  public function test_registration_password_confirmation_invalid(): void
  {
    $response = $this->post('/register', [
      'name' => 'Test User',
      'email' => 'test@example.com',
      'password' => 'password',
      'password_confirmation' => 'wrong_password',
      'phone' => '090-1234-5678',
    ]);

    $response->assertSessionHasErrors([
      'password' => 'パスワードが確認用項目と一致していません。',
    ]);

    $this->assertGuest($guard = null); // ユーザーが認証されていないことを確認
  }

  // パスワードが8文字未満の場合
  public function test_registration_password_min(): void
  {
    $response = $this->post('/register', [
      'name' => 'Test User',
      'email' => 'test@example.com',
      'password' => 'pass',
      'password_confirmation' => 'pass',
      'phone' => '090-1234-5678',
    ]);

    $response->assertSessionHasErrors([
      'password' => 'パスワードは8文字以上で入力してください。',
    ]);

    $this->assertGuest($guard = null); // ユーザーが認証されていないことを確認
  }

  // 電話番号がハイフンなしの場合
  public function test_registration_phone_invalid(): void
  {
    $response = $this->post('/register', [
      'name' => 'Test User',
      'email' => 'test@example.com',
      'password' => 'pass',
      'password_confirmation' => 'pass',
      'phone' => '09012345678',
    ]);

    $response->assertSessionHasErrors([
      'phone' => '電話番号は正しい形式で入力してください。',
    ]);
    $this->assertGuest($guard = null); // ユーザーが認証されていないことを確認
  }
}
