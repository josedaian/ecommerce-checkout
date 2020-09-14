<?php

namespace App\Http\Services;

use App\Provider;
use App\Traits\ApiRequest;
use App\Traits\ApiResponser;
use App\Webservice;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Response;

class AdamsPayService{
    use ApiResponser;
    use ApiRequest;

    protected $url;
    protected $apiKey;

    public const DEFAULT_DURATION = 2; //days
    public const DEFAULT_CURRENCY = 'PYG';

    function __construct()
    {
        $webservice = Webservice::whereProviderId(Provider::ADAMSPAY)->first();
        $webservice->load(['webserviceCredential']);

        $this->url = $webservice->url;
        $this->apiKey = $webservice->webserviceCredential->api_key;
    }

    public function createDebt(array $data){
        try {
            $requestParams = $this->getEndpointWithHeader('debts');

            $data['amount']['currency'] = isset($data['amount']['currency']) ? $data['amount']['currency'] : $this::DEFAULT_CURRENCY;
            $data['validPeriod'] = $this->calculateDatePeriod();

            $data = [
                'debt' => $data
            ];

            $response = $this->postRequest($requestParams['endpoint'], $requestParams['headers'], $data);

            if($response->meta->status == 'error'){
                if($response->meta->code == 'duplicate.debt'){
                    $debt = $this->getDebt($data['debt']['docId']);
                    return $this->errorResponseWithMessage($debt, $response->meta->description, Response::HTTP_OK);
                }else{
                    return $this->errorResponse($response->meta->description, Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }

            return $this->successResponse($response);

        } catch (Exception $exception) {
            \Log::error('[registerDonation]', ['error' => $exception]);
            $this->errorResponse('Ha ocurrido un error interno', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getDebt(String $docId){
        $requestParams = $this->getEndpointWithHeader('debts/'.$docId);

        $response = $this->getRequest($requestParams['endpoint'], $requestParams['headers']);
        return $response;
    }

    public function calculateDatePeriod($start = null, $duration = null){
        $duration = empty($duration) ? $this::DEFAULT_DURATION : $duration;
        $start = empty($start) ? Carbon::now() : $start;
        $start = Carbon::parse($start)->format(DateTime::ISO8601);
        $end = Carbon::parse($start)->add($duration, 'day')->format(DateTime::ISO8601);

        return [
            'start' => $start,
            'end' => $end,
        ];
    }

    public function getEndpointWithHeader(string $endpoint){
        return [
            'endpoint' => $this->url.$endpoint,
            'headers' => [
                'apikey' => $this->apiKey
            ]
        ];
    }
}