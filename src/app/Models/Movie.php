<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'description',
    'production_year',
    'genre',
    'poster_image_path',
  ];

  public static function movieSearch($request)
  {
    $query = Movie::query();

    $query->select('id', 'title', 'production_year', 'genre');
    $appends = [];

    if(isset($request->title)){
      $query->where('title', 'LIKE', '%' . $request->title . '%');
      $appends = array_merge($appends, ['title' => $request->title]);
    }

    if(isset($request->production_year)){
      $query->where('production_year', $request->production_year);
      $appends = array_merge($appends, ['production_year' => $request->production_year]);
    }

    if(isset($request->genre)){
      $query->where('genre', $request->genre);
      $appends = array_merge($appends, ['genre' => $request->genre]);
    }

    $movies = $query->paginate(10)->appends($appends); 

    return $movies;
  }

  public function screens()
  {
    return $this->hasMany(Screen::class);
  }

}
