<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $title = $this->faker->realText($maxNbChars = 20, $indexSize = 2);
    $description = $this->faker->realText($maxNbChars = 200, $indexSize = 2);
    $year = $this->faker->numberBetween($min = 1900, $max = 2023);
    $genre = $this->faker->numberBetween($min = 1, $max = 5);

    // // ダミー画像の生成と保存。ファイル名はランダムな文字列。
    // $file_name = Str::random(20);
    // $image = UploadedFile::fake()->image($file_name . '.jpg', 600, 600);
    // $path = Storage::putFile('public/posters', $image); // ファイルを保存する
    // $path = basename($path); // ファイル名を取得する

    // sample.jpegをコピーして保存 -------------------
    $public_path = public_path('images/sample.jpeg');

    $file_name = Str::random(20);
    $extension = File::extension($public_path);
    $storage_path = storage_path('app/public/posters/' . $file_name . '.' . $extension);

    $directory = dirname($storage_path);
    if (!File::isDirectory($directory)) {
        File::makeDirectory($directory, 0755, true);
    }

    File::copy($public_path, $storage_path);
    $path = $file_name . '.' . $extension;
    // ---------------------------------------------

    return [
      'title' => $title, 
      'description' => $description, 
      'production_year' => $year, 
      'genre' => $genre, 
      'poster_image_path' => $path, 
    ];
  }
}
