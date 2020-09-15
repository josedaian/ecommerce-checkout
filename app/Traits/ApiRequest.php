<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait ApiRequest
{
    /**
     * @param string $endpoint
     * @param array $headers
     * @param array $data
     * 
     * @return stdClass
     */
    public function postRequest(string $endpoint, array $headers = [], array $data = []){
        $response = Http::withHeaders($headers)->post($endpoint, $data);
        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $endpoint
     * @param array $headers
     * @param array $data
     * 
     * @return stdClass
     */
    public function getRequest(string $endpoint, array $headers = [], array $data = []){
        $response = Http::withHeaders($headers)->get($endpoint, $data);
        return json_decode($response->getBody()->getContents());
    }
}
