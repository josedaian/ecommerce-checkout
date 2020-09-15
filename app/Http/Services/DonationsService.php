<?php

namespace App\Http\Services;

use App\Provider;
use Exception;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use App\Transaction;

class DonationsService{
    use ApiResponser;

    /**
     * @param mixed $request
     * 
     * @return App\Traits\ApiResponser
     */
    public function execute($request){
        return $this->registerDonation($request);
    }

    /**
     * @param mixed $request
     * 
     * @return App\Traits\ApiResponser
     */
    public function registerDonation($request){
        try {
            \DB::beginTransaction();

            $adamspay = new AdamsPayService;
            $data = [];
            $data['amount'] = [
                'value' => $request->amount
            ];
            $data['label'] = $request->concept;
            $data['docId'] = $request->document;

            $response = $adamspay->createDebt($data)->getData();
            if(isset($response->data)){
                if(!Transaction::referenceExists($request->document)){
                    $transaction = new Transaction;
                    $transaction->reference = $request->document;
                    $transaction->concept = $request->concept;
                    $transaction->amount = $request->amount;
                    $transaction->provider_id = Provider::ADAMSPAY;
                    $transaction->status = $response->data->debt->payStatus->status;
                    $transaction->debt_provider_id = $response->data->debt->docId;
                    $transaction->save();
                    \DB::commit();

                    //Add local transaction data in response
                    $response->local = (object) ['transaction' => $transaction];
                }
            }

            return $response;

        } catch(Exception $exception) {
            \DB::rollback();
            \Log::error('[registerDonation]', ['error' => $exception]);
            $this->errorResponse('Ha ocurrido un error interno', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}