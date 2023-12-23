<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Http\Requests\MovieRequest;

class MovieController extends Controller
{
  public function index(Request $request)
  {
    $request->validate([
      'title' => ['string', 'max:255', 'nullable'],
      'production_year' => ['integer', 'digits:4', 'nullable'],
      'genre' => ['integer', 'nullable'],
    ]);

    $movies = Movie::movieSearch($request);

    return view('admin.movies.index')->with([
      'movies' => $movies,
      'title' => $request->title,
      'production_year' => $request->production_year,
      'genre' => $request->genre,
    ]);
  }

  public function show(Movie $movie)
  {
    return view('admin.movies.show')->with([
      'movie' => $movie,
    ]);
  }

  public function create()
  {
    return view('admin.movies.create');
  }

  public function store(MovieRequest $request)
  {
    $dir = 'posters'; // ディレクトリ名を指定する

    // アップロードされたファイルを指定したディレクトリに保存する
    if ($request->poster_image) {
      $path = $request->poster_image->store('public/' . $dir);
      $path = basename($path); // ファイル名を取得する
    } else {
      $path = null;
    }
    
    $movie = Movie::create([
      'title' => $request->title,
      'production_year' => $request->production_year,
      'genre' => $request->genre,
      'description' => $request->description,
      'poster_image_path' => $path, 
    ]);

    return redirect()->route('admin.movies.index')->with([
      'movie_flash_message' => '映画の登録が完了しました。',
    ]);
  }

  public function edit(Movie $movie)
  {
    $poster_image_path = isset($movie->poster_image_path) ? asset('storage/posters/' . $movie->poster_image_path) : asset('images/poster_noimage.jpg');

    return view('admin.movies.edit')->with([
      'movie' => $movie,
      'poster_image_path' => $poster_image_path,
    ]);
  }

  public function update(MovieRequest $request, Movie $movie)
  {
    $dir = 'posters'; // ディレクトリ名を指定する

    $update_items = [
      'title' => $request->title,
      'production_year' => $request->production_year,
      'genre' => $request->genre,
      'description' => $request->description,
    ];

    if ($request->poster_image) {
      if(isset($movie->poster_image_path)) {
        // 画像が登録されている場合は、ファイルを削除する
        \Storage::delete('public/' . $dir . '/' . $movie->poster_image_path);
      }
      $path = $request->poster_image->store('public/' . $dir);
      $path = basename($path); // ファイル名を取得する
      $update_items['poster_image_path'] = $path; 
    } elseif( $request->image_removed == 1 ) {
      if(isset($movie->poster_image_path)) {
        // 画像が登録されている場合は、ファイルを削除する
        \Storage::delete('public/' . $dir . '/' . $movie->poster_image_path);
      }
      $path = null;
      $update_items['poster_image_path'] = $path;
    }

    $movie->update($update_items);

    return redirect()->route('admin.movies.edit', $movie->id)->with([
      'movie_update_message' => '映画情報の更新が完了しました。',
    ]);
  }

  public function destroy(Movie $movie)
  {
    // dd($movie->poster_image_path);
    if(isset($movie->poster_image_path)) {
      // 画像が登録されている場合は、ファイルを削除する
      \Storage::delete('public/posters/' . $movie->poster_image_path);
    }

    $movie->delete();

    return redirect()->route('admin.movies.index')->with([
      'movie_flash_message' => '映画の削除が1件完了しました。',
    ]);
  }
}
