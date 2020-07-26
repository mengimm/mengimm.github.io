<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp;
use Response;
use App\Vuser;
use App\Ad;

class viber extends Controller
{
    //public $token='492f977a90e7d70a-18d9b191728f6f18-7f85f97681896b9';

    public $token='48380f53e9e7d686-355fd1effe2d68ee-c92301ccbfd6a9df';
    public $url='https://chatapi.viber.com/pa/set_webhook';
    public $url_send='https://chatapi.viber.com/pa/send_message';
    public $host='https://9b3e5b74cd91.ngrok.io/api/bot';

    public $choise_ad_keyboard=
    [
        "min_api_version"=>7,
        "type"=>"rich_media",
        "tracking_data"=>"choise_ad",
        "rich_media"=>[
            "Type"=>"rich_media",
            "ButtonsGroupColumns"=>6,
            "ButtonsGroupRows"=>7,
            "BgColor"=>"#FFFFFF",
            "Buttons"=>[    
    [
        "Columns"=>6,
        "Rows"=>6,
        "ActionType"=>"open-url",
        "ActionBody"=>"https://www.google.com",
        "Image"=>"https://mengimm.github.io/img/type.png"
     ],     
     [
        "Columns"=>3,
        "Rows"=>1,
        "ActionType"=>"reply",
        "ActionBody"=>"1",
        "Text"=>"<font color=#ffffff>Аренда</font>",
        "TextSize"=>"large",
        "TextVAlign"=>"middle",
        "TextHAlign"=>"middle",
        "Image"=>"https://mengimm.github.io/img/button.png"
     ],
     [
        "Columns"=>3,
        "Rows"=>1,
        "ActionType"=>"reply",
        "ActionBody"=>"2",
        "Text"=>"<font color=#ffffff>Продажа</font>",
        "TextSize"=>"large",
        "TextVAlign"=>"middle",
        "TextHAlign"=>"middle",
        "Image"=>"https://mengimm.github.io/img/button.png"
     ]]]];

     public $choise_type_keyboard=[
            "min_api_version"=>7,
            "type"=>"rich_media",
            "tracking_data"=>"choise_type",
            "rich_media"=>[
                "Type"=>"rich_media",
                "ButtonsGroupColumns"=>5,
                "ButtonsGroupRows"=>5,
                "BgColor"=>"#FFFFFF",
                "Buttons"=>[         
                    [//квартира
                        "Columns"=>5,
                        "Rows"=>4,
                        "ActionType"=>"none",
                        "ActionBody"=>"1",
                        "Image"=>"https://mengimm.github.io/img/apartment.png"
                    ],     
                    [
                        "Columns"=>5,
                        "Rows"=>1,
                        "ActionType"=>"reply",
                        "ActionBody"=>"1",
                        "Silent"=>true,
                        "Text"=>"<font color=#ffffff>Квартира</font>",
                        "TextSize"=>"large",
                        "TextVAlign"=>"middle",
                        "TextHAlign"=>"middle",
                        "Image"=>"https://mengimm.github.io/img/button.png"
                    ],
                    [//гараж
                        "Columns"=>5,
                        "Rows"=>4,
                        "ActionType"=>"none",
                        "ActionBody"=>"2",
                        "Image"=>"https://mengimm.github.io/img/garage.png"
                    ],     
                    [
                        "Columns"=>5,
                        "Rows"=>1,
                        "ActionType"=>"reply",
                        "ActionBody"=>"2",
                        "Silent"=>true,
                        "Text"=>"<font color=#ffffff>Гараж</font>",
                        "TextSize"=>"large",
                        "TextVAlign"=>"middle",
                        "TextHAlign"=>"middle",
                        "Image"=>"https://mengimm.github.io/img/button.png"
                    ],
                    [//частный дом
                        "Columns"=>5,
                        "Rows"=>4,
                        "ActionType"=>"none",
                        "ActionBody"=>"3",
                        "Image"=>"https://mengimm.github.io/img/house.png"
                    ],     
                    [
                        "Columns"=>5,
                        "Rows"=>1,
                        "ActionType"=>"reply",
                        "ActionBody"=>"3",
                        "Silent"=>true,
                        "Text"=>"<font color=#ffffff>Частный дом</font>",
                        "TextSize"=>"large",
                        "TextVAlign"=>"middle",
                        "TextHAlign"=>"middle",
                        "Image"=>"https://mengimm.github.io/img/button.png"
                    ],
                    [//участок
                        "Columns"=>5,
                        "Rows"=>4,
                        "ActionType"=>"none",
                        "ActionBody"=>"4",
                        "Image"=>"https://mengimm.github.io/img/map.png"
                    ],     
                    [
                        "Columns"=>5,
                        "Rows"=>1,
                        "ActionType"=>"reply",
                        "ActionBody"=>"4",
                        "Silent"=>true,
                        "Text"=>"<font color=#ffffff>Участок</font>",
                        "TextSize"=>"large",
                        "TextVAlign"=>"middle",
                        "TextHAlign"=>"middle",
                        "Image"=>"https://mengimm.github.io/img/button.png"
                    ],
                    [//коммерческая
                        "Columns"=>5,
                        "Rows"=>4,
                        "ActionType"=>"none",
                        "ActionBody"=>"5",
                        "Image"=>"https://mengimm.github.io/img/moll.png"
                    ],     
                    [
                        "Columns"=>5,
                        "Rows"=>1,
                        "ActionType"=>"reply",
                        "ActionBody"=>"5",
                        "Silent"=>true,
                        "Text"=>"<font color=#ffffff>Коммерческая</font>",
                        "TextSize"=>"large",
                        "TextVAlign"=>"middle",
                        "TextHAlign"=>"middle",
                        "Image"=>"https://mengimm.github.io/img/button.png"
                    ]
                ]]
    ];
/*
    [
        "receiver":"01234567890A=",
        "type"=>"text",
        "text"=>"Hello world",
        "keyboard"=>[
           "Type"=>"keyboard",
           "DefaultHeight"=>true,
           "Buttons"=>[
              [
                 "ActionType"=>"location-picker",
                 "ActionBody"=>"loc",
                 "Text"=>"Key text",
                 "TextSize"=>"regular"
              ]
           ]
        ]
     ]
*/
    public $send_location=[        
        "type"=>"text",
        "min_api_version"=>7,
        "text"=>"Hello world",
        "keyboard"=>[
           "Type"=>"keyboard",
           "DefaultHeight"=>true,
           "Buttons"=>[
              [
                 "ActionType"=>"location-picker",
                 "ActionBody"=>"loc",
                 "Text"=>"Key text",
                 "TextSize"=>"regular"
              ]
           ]
        ]
     ];

    public function get_vheaders(){
        return ['X-Viber-Auth-Token' => $this->token, 'Content-Type' => 'multipart/form-data' ];
    }    

    public function sethook(Request $request){                    
        $b = $this->setwhook();

        return response()->json(["success"], 200);
    }

    public function setwhook(){        

        $client= new GuzzleHttp\Client();
        
        $body = ['url'=>$this->host,
        'event_types' => ['unsubscribed', 'conversation_started', 'message', 'seen', 'delivered']];
        $res=$client->request('POST',$this->url,['headers' => $this->get_vheaders(), GuzzleHttp\RequestOptions::JSON => $body]);
        $b = $res->getBody();
        return $b;
    }

    public function unsetwhook(){
        $client= new GuzzleHttp\Client();        
        $body = ['url'=>''];
        $res=$client->request('POST',$this->url,['headers' => $this->get_vheaders(), GuzzleHttp\RequestOptions::JSON => $body]);
        $b = $res->getBody();
        return $b;
    }

    public function unsethook(Request $request){
        $b = $this->unsetwhook();
        return response()->json(["success"], 200);        
    }

    public function bot(Request $request){
        $content=$request->all();
        //обрабатываем тип "сообщение"
        if ($content["event"]=="message"){            
            $sender=$content["sender"]["id"];
            $vuser=$this->get_vuser($content);
            $td=$content['tracking_data'];
            //if ($td=='')
            $array=['ins_ad','read_ad','ins_rent','ins_sale','read_rent','read_sale'];
            //если трекинг дата подача объявлений
            if (in_array($td,['ins_ad','choise_ad','choise_type','price','foto','description','publish'])){
                $ad=$vuser->get_edit_ad();
                $kb=$this->edit_ad($ad,$content);                
                $this->send_keyboard($sender,$kb);
            //если трекинг дата получение объявлений
            }elseif(in_array($td,['get_ad','find_choise_ad','find_choise_type'])){
                $f=$vuser->get_findprop();
                $kb=$this->set_read_prop($f,$content);
                $this->send_keyboard($sender,$kb);
            }elseif($td=='page_'){
                $this->get_ad($vuser,$td);
            }
            //$text=$content["message"]["text"];                        
        }
        return response()->json(['Success','viber bot'], 200);
    }

    public function edit_ad($ad,$content){
        //$a=$vuser->get_edit_ad();
        $id=$content['message']['id'];
        $id="NAI5XANdAmJLb0oeJ7gIaA==";

        $td=$content['tracking_data'];
        if ($td=='choise_ad'){
            $ad->type=$td=$content['message']['text'];
            $kb=$this->send_location;
        }elseif($td=='choise_type'){
            $ad->prop_type=$td=$content['message']['text'];
            $kb=$this->send_location;
        }elseif($td=='price'){
            $ad->price=$td=$content['message']['text'];
            $kb=$this->send_location;
        }elseif($td=='foto'){
            $ad->photos=$td=$content['message']['text'];
            $kb=$this->send_location;
        }elseif($td=='description'){
            $ad->description=$td=$content['message']['text'];
            $kb=$this->send_location;
        }elseif($td=='publish'){
            if ($content['message']['text']=='1'){
                $ad->status=1;
                $kb=$this->send_location;
            }
    }                        
        $ad->save();        
        return $kb;
    }

    public function set_read_prop($f,$content){
        //$a=$vuser->get_edit_ad();
        $id=$content['message']['id'];
        $id="NAI5XANdAmJLb0oeJ7gIaA==";

        $td=$content['tracking_data'];
        if ($td=='find_choise_ad'){
            $f->type=$td=$content['message']['text'];
            $kb=$this->send_location;
        }elseif($td=='find_choise_type'){
            $f->prop_type=$td=$content['message']['text'];
            $kb=$this->send_location;
        }                            
        $f->save();
        return $kb;
    }

    public function get_vuser($content){
        
        $id=$content['sender']['id'];
        $u=Vuser::where('vid',$id)->first();
        if ($u==null){
            $u=new Vuser();
            $u->vid=$id;
            $u->name=$content['sender']['name'];
            $u->photo=$content['sender']['avatar'] ?? null;
            $u->save();
        }
        return $u;
    }

    public function get_ad($vuser,$page){
        $f=$vuser->get_findprop();

        $ads=Ad::where('status',1)
                ->where('type',$f->type)
                ->where('prop_type',$f->prop_type)
                ->paginate(5,['*'],'page',$page);                
        return $ads;
    }

    public function send_msg($id,$text){
        $client= new GuzzleHttp\Client();

        //$headers = ['X-Viber-Auth-Token' => $token, 'Content-Type' => 'multipart/form-data' ];
        //$id="NAI5XANdAmJLb0oeJ7gIaA==";
        $body=[
            "receiver"=>$id,
            "min_api_version"=>1,
            "sender"=>[
                "name"=>"John McClane"
            ],
               
               //"avatar":"http://avatar.example.com"
            //},
            //"tracking_data"=>"tracking data",
            "type"=>"text",
            "text"=>$text
];
  //      $body = ['url'=>'https://654f171ba524.ngrok.io/api/bot',
    //    'event_types' => ['unsubscribed', 'conversation_started', 'message', 'seen', 'delivered']];
        $res=$client->request('POST',$this->url_send,['headers' => $this->get_vheaders(), GuzzleHttp\RequestOptions::JSON => $body]);
        $b=$res->getBody();
        return $b;
        
    }

    public function send_keyboard($id,$kb){
        //$id="NAI5XANdAmJLb0oeJ7gIaA==";
        //$text="type";
        $client= new GuzzleHttp\Client();

        //$body=$this->send_location;
        $body=$kb;
        $body["receiver"]=$id;
        $res=$client->request('POST',$this->url_send,['headers' => $this->get_vheaders(), GuzzleHttp\RequestOptions::JSON => $body]);
        $b=$res->getBody();
        return $b;

    }

    public function bot_get(Request $request){
        return response()->json(['Success','viber bot'], 200);
    }

}
