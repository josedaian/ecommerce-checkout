<?php

namespace App\Http\Services;

use Exception;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use App\Transaction;

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

            if($adamspay->validateHeaderNotification($postData, $header)){
                if(Transaction::referenceExists($postData['debt']['docId'])){
                    $transaction = Transaction::where('reference', $postData['debt']['docId'])->first();
                    $transaction->status = $postData['debt']['payStatus']['status'];
                    $transaction->save();
                }else{
                    return $this->errorResponse('La transacción no existe', Response::HTTP_NOT_FOUND);
                }
            }else{
                return $this->errorResponse('El hash recibido es inválido', Response::HTTP_BAD_GATEWAY);
            }
            
            return $this->successResponse([], Response::HTTP_OK);

        } catch(Exception $exception) {
            \Log::error('[getNotification]', ['error' => $exception]);
            $this->errorResponse('Ha ocurrido un error interno', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}