<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){
        $client = new Client();
        $response = $client->get(config('constants.providers.second_provider'));
        $response = json_decode($response->getBody(),true);
        foreach ($response as $item){
            dd($item);
        }
        return $response;
    }
}
