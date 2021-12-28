<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

use function config;

class TypesParsingService
{
    public function callApi()
    {
        $headers = [
            'user-agent' => config('services.nasa.agent'),
            'accept' => config('services.nasa.accept')
        ];
        $result = Http::withHeaders($headers)->get('https://eonet.gsfc.nasa.gov/api/v2.1/categories?'. config('services.nasa.key'));
        return $result->json();
    }
}
