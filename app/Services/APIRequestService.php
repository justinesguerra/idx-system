<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Traits\AppConfigTrait;

class APIRequestService
{
    public function api($url)
    {
        $username = AppConfigTrait::get("API_USERNAME", false);
        $password = AppConfigTrait::get("API_PASSWORD", false);
        $credentials = $username . ':' . $password;
        $authHeader = 'Basic ' . base64_encode($credentials);

        $api_response = Http::withHeaders([
            'Authorization' => $authHeader,
        ])->get($url);

        return $api_response;
    }
}
