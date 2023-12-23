<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DeploymentSeeder extends Seeder
{
  public function run(): void
  {
    Storage::deleteDirectory('public/posters'); // storage/app/public/posters/ 以下のファイルを全て削除

    DB::table('admins')->insert([
      'name' => 'master',
      'email' => 'admin@gmail.com',
      'password' => Hash::make('admin@1234'),
    ]);

    $movie_1 = \App\Models\Movie::factory()->create([
      'title' => 'ハリー・ポッターと賢者の石',
      'description' => 'ハリー・ポッターは、魔法使いの世界で有名な一家に生まれたが、両親を幼い頃に亡くし、叔父夫婦のもとで育てられていた。そんなある日、ハリーは自分が魔法使いであることを知らされ、ホグワーツ魔法魔術学校に入学することになる。そこでハリーは、同じくホグワーツに入学したロンとハーマイオニーという2人の友達と出会う。そして、ハリーは、ホグワーツの校長であるダンブルドア先生や、魔法使いの世界で有名な一家の悪名高い一人息子であるマルフォイという少年とも出会う。ハリーは、ホグワーツでの生活を楽しむ一方で、自分の両親の死の真相を知るために、ダンブルドア先生やハーマイオニーとともに、ある秘密を探ることになる。',
      'production_year' => 2001,
      'genre' => 1,
    ]);

    $movie_2 = \App\Models\Movie::factory()->create([
      'title' => 'ダイ・ハード',
      'description' => 'ニューヨーク市警察の刑事ジョン・マクレーンは、クリスマスのためロサンゼルスに住む妻ホリーと子供たちのいる会社のクリスマスパーティーに出席するため、ロサンゼルスにやって来た。ホリーは、マクレーンがニューヨークでの仕事に没頭していることに不満を持っていた。マクレーンは、ホリーとの関係を修復するために、クリスマスプレゼントとしてホリーの会社にやって来た。しかし、マクレーンがホリーの会社に到着した直後、会社はテロリストに占拠されてしまう。マクレーンは、テロリストたちに捕まってしまったホリーを救うために、テロリストたちと戦うことになる。',
      'production_year' => 1988,
      'genre' => 2,
    ]);

    $movie_3 = \App\Models\Movie::factory()->create([
      'title' => 'ターミネーター2',
      'description' => 'サラ・コナーは、サイバーダイン社の開発した人工知能システム「スカイネット」が、人類を滅亡させるために、未来から送り込んだターミネーターによって殺害された。しかし、サラの息子であるジョンは、未来から送り込まれたターミネーターによって、サラを殺害される前に救出された。ジョンは、サラを殺害しようとするターミネーターから逃れるために、未来から送り込まれたターミネーターとともに、サラを殺害しようとするターミネーターを追いかけることになる。',
      'production_year' => 1991,
      'genre' => 2,
    ]);

    \App\Models\Screen::factory()->create(['movie_id' => $movie_1->id,]);
    \App\Models\Screen::factory()->create(['movie_id' => $movie_2->id,]);
    \App\Models\Screen::factory()->create(['movie_id' => $movie_3->id,]);

    \App\Models\User::factory()->count(10)->create();

    // 予約済みの座席を作成。複合ユニークキーのため、同じ組み合わせの座席は作成できない
    for ($i = 0; $i < 10; $i++) {
      \App\Models\Seat::factory()->create();
    }

    $test_user = \App\Models\User::factory()->create([
      'name' => 'test',
      'email' => 'test@gmail.com',
      'password' => Hash::make('test@1234'),
      'phone' => '09012345678',
    ]);
  }
}
