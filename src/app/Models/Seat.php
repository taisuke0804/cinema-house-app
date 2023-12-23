<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
  use HasFactory;

  protected $fillable = [
    'screen_id',
    'seat_number',
    'user_id',
    'guest_name',
    'guest_is',
  ];

  public function screen()
  {
    return $this->belongsTo('App\Models\Screen');
  }

  public function user()
  {
    return $this->belongsTo('App\Models\User');
  }
}
