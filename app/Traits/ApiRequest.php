<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait ApiRequest
{
    public function postRequest(string $endpoint, array $headers = [], array $data = []){
        $response = Http::withHeaders($headers)->post($endpoint, $data);
        return json_decode($response->getBody()->getContents());
    }

    public function getRequest(string $endpoint, array $headers = [], array $data = []){
        $response = Http::withHeaders($headers)->get($endpoint, $data);
        return json_decode($response->getBody()->getContents());
    }
}
