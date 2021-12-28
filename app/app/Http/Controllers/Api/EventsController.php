<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WeatherEvents;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return WeatherEvents[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return WeatherEvents::all();
    }
}
