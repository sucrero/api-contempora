<?php

namespace App\Http\Controllers\ResponseObject;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SoapClient;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;



class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function showUser(Request $request){
        
        $requestKeys = collect($request->all())->keys()->all();

        if( empty($requestKeys) ){
            $response = $this->showAllUser();
        }else{
            
        }

        return $response;

    }

    public function showAllUser(){

        $url = env('URL_API_USER').'/users';
        $data = Http::withToken(env('API_KEY'))->get($url);
        return response(json_decode($data,201));
    }

}


