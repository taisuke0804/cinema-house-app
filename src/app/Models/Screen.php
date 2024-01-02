<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
  use HasFactory;

  protected $fillable = [
    'movie_id',
    'screening_date',
    'start_time',
    'end_time',
  ];

  public function movie()
  {
    return $this->belongsTo(Movie::class);
  }

  public function seats()
  {
    return $this->hasMany(Seat::class);
  }
}
