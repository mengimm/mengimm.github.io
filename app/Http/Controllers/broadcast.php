<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Vuser;
use App\Ad;
use App\Listener;
use App\Http\Controllers\Keyboards;
use Storage;

class Broadcast extends Controller
{    
    public function get_listeners($type,$type_prop){
        $vusers=[];
        $listeners=Listener::where('type',$type)->where('type_prop',$type_prop)->get();
        foreach($listeners as $l){
            array_push($vusers,$l->vuser());
        }
        return $vusers;
    }

    public function test(){
        echo 'test';
    }



}