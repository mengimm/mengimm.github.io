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
    public function set_prop_ad($host,$vuser,$f,$content){
         //$a=$vuser->get_edit_ad();
        //$id=$content['message']['id'];
        //$id="NAI5XANdAmJLb0oeJ7gIaA==";
        $k=new Keyboards();

        $td=$content['message']['tracking_data'];
        if ($td=='read_type_ad'){
            if ($content['message']['text']=='prev'){                
                //$sender=$vuser->vid;
                $kb=$k->action_keyboard;
                $kb['tracking_data']='action';
            }else{
                $f->type=$content['message']['text'];
                $kb=$this->form_keyboard_type_ad($f->type);
                $kb['keyboard']['Buttons']=array_merge($k->top_buttons,$kb['keyboard']['Buttons']);
                $kb['tracking_data']='read_type_prop';
            }            
        }elseif($td=='read_type_prop'){
            if ($content['message']['text']=='prev'){
                $kb=$k->type_ad_keyboard;
                $kb['keyboard']['Buttons']=array_merge($k->top_buttons,$kb['keyboard']['Buttons']);
                $kb['tracking_data']='read_type_ad';
            }else{
                $f->prop_type=$content['message']['text'];
                $kb=$this->keyboard_ad($host,$vuser);
                $kb['keyboard']['Buttons']=array_merge($k->top_buttons,$kb['keyboard']['Buttons']);
                $kb['tracking_data']='set_prop';
            }            
            
        }elseif($td=='set_prop'){
            if ($content['message']['text']=='1'){
                //$f->status=1;
                //$f->save();
                $kb=$this->keyboard_ad($vuser);
                //$kb=$k->description_keyboard;                
                //$kb=$k->show_ad($content['sender']['id'],$ad);
            }elseif ($content['message']['text']=='prev'){
                $kb=$this->form_keyboard_type_ad($f->type);
                $kb['keyboard']['Buttons']=array_merge($k->top_buttons,$kb['keyboard']['Buttons']);
                $kb['tracking_data']='read_type_prop';
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

    public function keyboard_ad($host,$vuser){
        $ads=$this->get_ad($vuser);
        return $this->form_keyboard_ad($host,$ads);
    }

    public function get_ad($vuser,$page=1){
        $f=$vuser->get_findprop();

        $ads=Ad::where('status',1)
                ->where('type',$f->type)
                ->where('prop_type',$f->prop_type)
                ->paginate(10,['*'],'page',$page);
        return $ads;
    }

    public function form_keyboard_ad($host,$ads){
        $k=new Keyboards;
        $buttons=[];
        foreach ($ads as $ad){
            $buttons=array_merge($buttons,$this->get_only_ad($host,$ad));
        }
        //$top=$k->top_buttons;
        /*$top=[
            [
            "Columns"=>1,
            "Rows"=>1,
            "ActionType"=>"none",
            "ActionBody"=>"1",
            "Text"=>"<font color=#000000>фото</font>",
            "TextSize"=>"large",
            "TextVAlign"=>"middle",
            "TextHAlign"=>"middle",
            ],
            [],
            [],
            []
            */        
        return [
            "min_api_version"=>7,        
                "Type"=>"keyboard",
                "DefaultHeight"=>true,
                "BgColor"=>"#FFFFFF",
                "keyboard"=>[
                "InputFieldState"=>"hidden",
                "Buttons"=>$buttons
            ]];

    }

    public function get_only_ad($host,$ad){
        $buttons=[];
        if ($ad->photo1==null){
            $buttons[0]=[
                "Columns"=>2,
                "Rows"=>2,
                "ActionType"=>"none",
                "ActionBody"=>"1",
                "Text"=>"<font color=#000000>фото</font>",
                "TextSize"=>"large",
                "TextVAlign"=>"middle",
                "TextHAlign"=>"middle",
            ];
        }else{
            $buttons[0]=
            [
                "Columns"=>2,
                "Rows"=>2,
                "ActionType"=>"none",
                "ActionBody"=>"1",
                "Image"=>$host.$ad->photo1,
            ];
        };

        $buttons[1]=
                    [
                        "Columns"=>4,
                        "Rows"=>2,
                        "ActionType"=>"reply",
                        "ActionBody"=>$ad->id,
                        "Text"=>"<font color=#000000>".$ad->id."</font>",
                        "TextSize"=>"large",
                        "TextVAlign"=>"middle",
                        "TextHAlign"=>"middle",
                    ];
        
        return $buttons;
        }
}