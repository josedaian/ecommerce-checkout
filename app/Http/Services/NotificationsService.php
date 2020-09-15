<?php

namespace App\Http\Services;

use Exception;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;

class NotificationsService{
    use ApiResponser;

    /**
     * @param mixed $request
     * 
     * @return App\Traits\ApiResponser
     */
    public function execute($request){
        return $this->getNotification($request);
    }

    /**
     * @param mixed $request
     * 
     * @return App\Traits\ApiResponser
     */
    public function getNotification($request){
        try {
            $header = $request->header();
            $postData = $request->all(); 
            $adamspay = new AdamsPayService;
            $adamspay->validateHeaderNotification($postData, $header);
            return 200;
            
            $data = [];
            $data['amount'] = [
                'value' => $request->amount
            ];
            $data['label'] = $request->concept;
            $data['docId'] = $request->document;

            $response = $adamspay->createDebt($data)->getDate();
            return $response;

        } catch(Exception $exception) {
            \Log::error('[getNotification]', ['error' => $exception]);
            $this->errorResponse('Ha ocurrido un error interno', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}