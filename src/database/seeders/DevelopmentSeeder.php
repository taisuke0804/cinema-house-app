<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Movie;
use App\Models\Screen;
use App\Models\User;
use App\Models\Seat;
use Illuminate\Support\Facades\Storage;

class DevelopmentSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Storage::deleteDirectory('public/posters'); // storage/app/public/posters/ 以下のファイルを全て削除

    DB::table('admins')->insert([
      'name' => 'master',
      'email' => 'admin@gmail.com',
      'password' => Hash::make('1111aaaa'),
    ]);

    Movie::factory()->count(30)->create();
    Screen::factory()->count(10)->create();
    
    $test_user = User::factory()->create([
      'name' => 'test',
      'email' => 'test@gmail.com',
      'password' => Hash::make('1111aaaa'),
      'phone' => '09012345678',
    ]);
    
    User::factory()->count(20)->create();

    // 予約済みの座席を作成。複合ユニークキーのため、同じ組み合わせの座席は作成できない
    for ($i = 0; $i < 100; $i++) {
      Seat::factory()->create();
    }
  }
}
