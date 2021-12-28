<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EventTypes;

class TypesController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $first[] = 'All';
        foreach (EventTypes::pluck('type') as $item) {
            $first[] = $item;
        }
        return $first;
    }
}
