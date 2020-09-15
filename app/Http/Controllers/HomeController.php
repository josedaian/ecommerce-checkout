<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller {

    /**
     * Index
     *
     * @method get
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $request = $request->all();
        if(isset($request['intent'])){
            $transaction = Transaction::where('reference', $request['doc_id'])->first();
        }

        return view('home.index', [
            'request' => $request,
            'transaction' => isset($transaction) ? $transaction : null
        ]);
    }
}