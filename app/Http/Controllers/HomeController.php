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
        return view('home.index', [
            'request' => $request
        ]);
    }
}