<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Vuser;
use App\Ad;
use App\Http\Controllers\Keyboards;

class ins_ad extends Controller
{    
    //public $keyboards=new Keyboards();

    public function edit_ad($ad,$content){
        //$a=$vuser->get_edit_ad();
        //$id=$content['message']['id'];
        //$id="NAI5XANdAmJLb0oeJ7gIaA==";
        $k=new Keyboards();

        $td=$content['message']['tracking_data'];
        if ($td=='type_ad'){
            $ad->type=$content['message']['text'];
            $kb=$k->type_prop_keyboard;
            $kb['tracking_data']='type_prop';
        }elseif($td=='type_prop'){
            $ad->prop_type=$content['message']['text'];
            $kb=$k->location_keyboard;
            $kb['tracking_data']='location';
        }elseif($td=='location'){
            $ad->lat=$content['message']['location']['lat'];
            $ad->lon=$content['message']['location']['lon'];
            $kb=$k->price_keyboard;
            $kb['tracking_data']='price';
        }elseif($td=='price'){
            $ad->price=$content['message']['text'];
            $kb=$k->publish_keyboard;
            $kb['tracking_data']='publish';
        }elseif(in_array($td,['photo1','photo2','photo3','photo4','photo5'])){
            if ($content['message']['type']=='picture'){
                $kb=$k->photo_keyboard;
                if ($td=='photo1'){
                    $ad->photo1=$content['message']['media'];
                    $kb['tracking_data']='photo2';
                    $kb['text']="отправьте еще фото объекта или нажмите завершить";
                }elseif($td=='photo2'){
                    $ad->photo2=$content['message']['media'];
                    $kb['tracking_data']='photo3';
                    $kb['text']="отправьте еще фото объекта или нажмите завершить";
                }elseif($td=='photo3'){
                    $ad->photo3=$content['message']['media'];
                    $kb['tracking_data']='photo4';
                    $kb['text']="отправьте еще фото объекта или нажмите завершить";
                }elseif($td=='photo4'){
                    $ad->photo4=$content['message']['media'];
                    $kb['tracking_data']='photo5';
                    $kb['text']="отправьте еще фото объекта или нажмите завершить";
                }elseif($td=='photo5'){
                    $ad->photo5=$content['message']['media'];
                    $kb=$k->description_keyboard;
                    $kb['tracking_data']='description';
                }                                
            }else{
                $kb=$k->description_keyboard;
                $kb['tracking_data']='description';
            }                                  
        }elseif($td=='description'){
            $ad->description=$content['message']['text'];
            $kb=$k->publish_keyboard;
            $kb['tracking_data']='publish';
        }elseif($td=='publish'){
            if ($content['message']['text']=='1'){
                $ad->status=1;
                $ad->save();
                $kb=$k->final_text;
                //$kb['tracking_data']='description';
                //$kb=$k->show_ad($content['sender']['id'],$ad);
            }
    }                        
        $ad->save();        
        return $kb;
    }

}