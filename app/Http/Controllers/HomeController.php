<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Validator, Redirect, Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller {
    public function __construct(){
        
    }

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