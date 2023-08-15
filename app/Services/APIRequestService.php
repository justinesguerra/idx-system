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

    public function fetchListingsWithCurl($ApiUrl)
    {
        $url = AppConfigTrait::get($ApiUrl, false);
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic YWRtaW5fdXc1cmtpMW86NUtrb0lPfnVUSSUxQ29jNA==',
                'Cookie: PHPSESSID=b1u7sd3hspf0ujga7eu5l7f290; WPL_CRM_ACTIVITY=1691741917'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }

}
