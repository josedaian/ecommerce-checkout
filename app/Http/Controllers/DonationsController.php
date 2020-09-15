<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonationRequest;
use App\Http\Services\DonationsService;

class DonationsController extends Controller {

    /**
     * @param StoreDonationRequest $request
     * @method post
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDonationRequest $request){
        $donation = new DonationsService;
        $donation = $donation->execute($request);
        return view('home.index', [
            'donation' => $donation
        ]);
    }
}