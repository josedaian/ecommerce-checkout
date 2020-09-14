<?php

namespace App\Http\Services;

use Exception;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;

class DonationsService{
    use ApiResponser;

    function __construct()
    {
    }

    public function execute($request){
        return $this->registerDonation($request)->getData();
    }

    public function registerDonation($request){
        try {
            $adamspay = new AdamsPayService;
            
            $data = [];
            $data['amount'] = [
                'value' => $request->amount
            ];
            $data['label'] = $request->concept;
            $data['docId'] = $request->document;

            return $adamspay->createDebt($data);

        } catch(Exception $exception) {
            \Log::error('[registerDonation]', ['error' => $exception]);
            $this->errorResponse('Ha ocurrido un error interno', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}