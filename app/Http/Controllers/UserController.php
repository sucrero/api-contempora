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
            switch ($requestKeys[0]) {
                case 'nombre':
                    
                    $validator = Validator::make($request->all(), [
                        'nombre' => 'required',
                    ]);


                    if($validator->fails()){
                        $errors = $validator->errors();
                        return response($errors->first('nombre'), 404);
                    }
                    $nombre = $request->input('nombre');
                    $response = $this->showUserByName($nombre);

                    break;
                case 'email':
                    
                    $validator = Validator::make($request->all(), [
                        'email' => 'required|email',
                    ]);

                    if( $validator->fails() ){
                        $errors = $validator->errors();
                        return response($errors->first('email'), 404);
                    }
                    $email = $request->input('email');
                    $response = $this->showUserByEmail($email);

                    break;
                case 'activos':
                    
                    $validator = Validator::make($request->all(), [
                        'activos' => [
                            'required',
                            Rule::in(['true', 'false']),
                        ],
                    ]);

                    if( $validator->fails() ){
                        $errors = $validator->errors();
                        return response($errors->first('activos'), 404);
                    }
                    $activos = $request->input('activos');
                    $response = $this->showUserByStatus($activos);

                    break;
                
                default:
                    return response("Error: Parámetro no válido", 404);
                    break;
            }
        }

        return $response;

    }

    public function showAllUser(){

        $url = env('URL_API_USER').'/users';
        $data = Http::withToken(env('API_KEY'))->get($url);
        return response(json_decode($data,201));
    }

    public function showUserByName($name){

        $url = env('URL_API_USER').'/users?name='.$name;
        $data = Http::withToken(env('API_KEY'))->get($url);
        return response(json_decode($data, true), 201);
    }

    public function showUserByEmail($email){
        $url = env('URL_API_USER').'/users?email='.$email;
        $data = Http::withToken(env('API_KEY'))->get($url);
        return response(json_decode($data), 201);
    }

    public function showUserByStatus($activos){

        switch ($activos) {
            case 'true':
                $status = 'active';
                break;
            case 'false':
                $status = 'inactive';
                break;
            default:
                $status = '';
                break;
        }

        if( empty($status) ){
            return response("Error", 504);
        }

        $url = env('URL_API_USER').'/users?status='.$status;
        $data = Http::withToken(env('API_KEY'))->get($url);
        return response(json_decode($data), 201);
    }

    public function createUser(Request $request){

        $validator = Validator::make($request->all(), [
            'nombre'    => 'required',
            'email'     => 'required|email' ,
            'genero'    => [
                'required',
                Rule::in(['female', 'male'])
            ],
            'activo' => [
                'required',
                Rule::in(['true', 'false']),
            ],
        ]);


        $msj = array();
        if( $validator->fails() ){
            foreach ($validator->errors()->getMessages() as $item) {
                array_push($msj, $item);
            }
            return response(json_encode($msj), 404);
        }

        $url = env('URL_API_USER').'/users';
        $name = $request->input('nombre');
        $email = $request->input('email');
        $gender = $request->input('genero');
        $status = ($request->input('activo') == 'true') ? 'active' : 'inactive';

        $response = Http::withToken(env('API_KEY'))->post($url,[
            'name'      => $name,
            'email'     => $email,
            'gender'    => $gender,
            'status'    => $status
        ]);

        if( $response->failed() ){
            return response(json_decode($response,true),$response->status());
        }

        return response(json_decode($response,true),201);
    }

}


