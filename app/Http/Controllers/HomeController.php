<?php

namespace App\Http\Controllers;

class HomeController extends Controller {

    /**
     * Index
     *
     * @method get
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('home.index');
    }
}