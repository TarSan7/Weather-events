<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherEvents extends Model
{
    use HasFactory;
    protected $fillable = [
      'type',
      'title',
      'date_time',
      'latitude',
      'longitude'
    ];
}
