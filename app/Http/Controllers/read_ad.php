<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Vuser;
use App\Ad;
use App\Findprop;
use App\Http\Controllers\Keyboards;

class read_ad extends Controller
{    
    public function set_prop_ad($vuser,$f,$content){
         //$a=$vuser->get_edit_ad();
        //$id=$content['message']['id'];
        //$id="NAI5XANdAmJLb0oeJ7gIaA==";
        $k=new Keyboards();

        $td=$content['message']['tracking_data'];
        if ($td=='read_type_ad'){
            $f->type=$content['message']['text'];
            $kb=$this->form_keyboard_type_ad($f->type);
            $kb['tracking_data']='read_type_prop';
        }elseif($td=='read_type_prop'){
            $f->prop_type=$content['message']['text'];
            //$kb=$k->description_keyboard;
            $kb=$this->keyboard_ad($vuser);
            $kb['tracking_data']='set_prop';
        }elseif($td=='set_prop'){
            if ($content['message']['text']=='1'){
                //$f->status=1;
                //$f->save();
                $kb=$this->keyboard_ad($vuser);
                //$kb=$k->description_keyboard;                
                //$kb=$k->show_ad($content['sender']['id'],$ad);
            }
    }                        
        $f->save();        
        return $kb;
    }

    public function form_keyboard_type_ad($type){
        $k=new Keyboards();
        $kb=$k->type_prop_keyboard;
        $label=[
            ['c'=>0,'t'=>'Квартира'],
            ['c'=>0,'t'=>'Гараж'],
            ['c'=>0,'t'=>'Частный дом'],
            ['c'=>0,'t'=>'Участок'],
            ['c'=>0,'t'=>'Коммерческое'],
        ];
        $i=0;        
        foreach ($label as $l) {
            $l['c']=Ad::where('status',1)->where('type',$type)->where('prop_type',$i+1)->count();            
            $textcolor='#000000';
            if ($l['c']==0){
                 $kb["keyboard"]["Buttons"][$i]["ActionType"]="none"; 
                 $textcolor='#777777';
            }
            $kb["keyboard"]["Buttons"][$i]["Text"]="<font color=".$textcolor.">".$l['t']."(".$l['c'].")</font>";
            $i=$i+1;
        }        

        return $kb;
    }

    public function keyboard_ad($vuser){
        $ads=$this->get_ad($vuser);
        return $this->form_keyboard_ad($ads);
    }

    public function get_ad($vuser,$page=1){
        $f=$vuser->get_findprop();

        $ads=Ad::where('status',1)
                ->where('type',$f->type)
                ->where('prop_type',$f->prop_type)
                ->paginate(5,['*'],'page',$page);
        return $ads;
    }

    public function form_keyboard_ad($ads){
        $buttons=[];
        foreach ($ads as $ad){
            $buttons=array_merge($buttons,$this->get_only_ad($ad));
        }

        return [
            "min_api_version"=>7,        
                "Type"=>"keyboard",
                "DefaultHeight"=>true,
                "BgColor"=>"#FFFFFF",
                "keyboard"=>[
                "Buttons"=>$buttons
            ]];

    }

    public function get_only_ad($ad){
        $buttons=
        [
                    [
                        "Columns"=>2,
                        "Rows"=>2,
                        "ActionType"=>"none",
                        "ActionBody"=>"1",
                        "Text"=>"<font color=#000000>фото</font>",
                        "TextSize"=>"large",
                        "TextVAlign"=>"middle",
                        "TextHAlign"=>"middle",
                    ],
                    [
                        "Columns"=>4,
                        "Rows"=>2,
                        "ActionType"=>"reply",
                        "ActionBody"=>$ad->id,
                        "Text"=>"<font color=#000000>".$ad->id."</font>",
                        "TextSize"=>"large",
                        "TextVAlign"=>"middle",
                        "TextHAlign"=>"middle",
                    ]
            ];
        return $buttons;
        }
}