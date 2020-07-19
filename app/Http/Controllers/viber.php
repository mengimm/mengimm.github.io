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
    public $host='https://01dc15e71e29.ngrok.io/api/bot';

    public $choise_ad_buttons=[[
        "Columns"=>6,
        "Rows"=>6,
        "ActionType"=>"open-url",
        "ActionBody"=>"https://www.google.com",
        "Image"=>"https://mengimm.github.io/type.png"
     ],     
     [
        "Columns"=>3,
        "Rows"=>1,
        "ActionType"=>"reply",
        "ActionBody"=>"https://www.google.com",
        "Text"=>"<font color=#ffffff>Аренда</font>",
        "TextSize"=>"large",
        "TextVAlign"=>"middle",
        "TextHAlign"=>"middle",
        "Image"=>"https://mengimm.github.io/button.png"
     ],
     [
        "Columns"=>3,
        "Rows"=>1,
        "ActionType"=>"reply",
        "ActionBody"=>"https://www.google.com",
        "Text"=>"<font color=#ffffff>Продажа</font>",
        "TextSize"=>"large",
        "TextVAlign"=>"middle",
        "TextHAlign"=>"middle",
        "Image"=>"https://mengimm.github.io/button.png"
     ]];

     public $choise_type_buttons=[
     [//квартира
        "Columns"=>5,
        "Rows"=>4,
        "ActionType"=>"open-url",
        "ActionBody"=>"https://www.google.com",
        "Image"=>"https://mengimm.github.io/apartment.png"
     ],     
     [
        "Columns"=>5,
        "Rows"=>1,
        "ActionType"=>"reply",
        "ActionBody"=>"https://www.google.com",
        "Text"=>"<font color=#ffffff>Квартира</font>",
        "TextSize"=>"large",
        "TextVAlign"=>"middle",
        "TextHAlign"=>"middle",
        "Image"=>"https://mengimm.github.io/button.png"
     ],
     [//гараж
        "Columns"=>5,
        "Rows"=>4,
        "ActionType"=>"open-url",
        "ActionBody"=>"https://www.google.com",
        "Image"=>"https://mengimm.github.io/garage.png"
     ],     
     [
        "Columns"=>5,
        "Rows"=>1,
        "ActionType"=>"reply",
        "ActionBody"=>"https://www.google.com",
        "Text"=>"<font color=#ffffff>Гараж</font>",
        "TextSize"=>"large",
        "TextVAlign"=>"middle",
        "TextHAlign"=>"middle",
        "Image"=>"https://mengimm.github.io/button.png"
     ],
     [//частный дом
        "Columns"=>5,
        "Rows"=>4,
        "ActionType"=>"open-url",
        "ActionBody"=>"https://www.google.com",
        "Image"=>"https://mengimm.github.io/house.png"
     ],     
     [
        "Columns"=>5,
        "Rows"=>1,
        "ActionType"=>"reply",
        "ActionBody"=>"https://www.google.com",
        "Text"=>"<font color=#ffffff>Частный дом</font>",
        "TextSize"=>"large",
        "TextVAlign"=>"middle",
        "TextHAlign"=>"middle",
        "Image"=>"https://mengimm.github.io/button.png"
     ],
     [//участок
        "Columns"=>5,
        "Rows"=>4,
        "ActionType"=>"open-url",
        "ActionBody"=>"https://www.google.com",
        "Image"=>"https://mengimm.github.io/map.png"
     ],     
     [
        "Columns"=>5,
        "Rows"=>1,
        "ActionType"=>"reply",
        "ActionBody"=>"https://www.google.com",
        "Text"=>"<font color=#ffffff>Участок</font>",
        "TextSize"=>"large",
        "TextVAlign"=>"middle",
        "TextHAlign"=>"middle",
        "Image"=>"https://mengimm.github.io/button.png"
     ],
     [//коммерческая
        "Columns"=>5,
        "Rows"=>4,
        "ActionType"=>"open-url",
        "ActionBody"=>"https://www.google.com",
        "Image"=>"https://mengimm.github.io/moll.png"
     ],     
     [
        "Columns"=>5,
        "Rows"=>1,
        "ActionType"=>"reply",
        "ActionBody"=>"https://www.google.com",
        "Text"=>"<font color=#ffffff>Коммерческая</font>",
        "TextSize"=>"large",
        "TextVAlign"=>"middle",
        "TextHAlign"=>"middle",
        "Image"=>"https://mengimm.github.io/button.png"
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
        //$e=1;
        $content=$request->all();        
        if ($content["event"]=="message"){
            $vuser=$this->get_vuser($content);
            $id=$content["sender"]["id"];
            $text=$content["message"]["text"];            
            
            $this->edit_ad($vuser,$text);
        }
        return response()->json(['Success','viber bot'], 200);
    }

    public function edit_ad($vuser,$text){
        $a=$vuser->get_edit_ad();
        $prestr=['descr_','price_'];
        foreach($prestr as $p){
            if (strpos($text,$p)==1){
                $a->description=substr($text,strlen($p)+1);
            }
        }
        
        $a->save();
        return $a;
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

    public function choise_type(){
        $id="NAI5XANdAmJLb0oeJ7gIaA==";
        $text="type";
        $client= new GuzzleHttp\Client();

        $body=[
            "receiver"=>$id,
            "min_api_version"=>3,
            "type"=>"rich_media",
            "rich_media"=>[
                "Type"=>"rich_media",
                "ButtonsGroupColumns"=>5,
                "ButtonsGroupRows"=>5,
                "BgColor"=>"#FFFFFF",
                "Buttons"=>$this->choise_type_buttons                
         ]
//            "sender"=>[
//                "name"=>"John McClane"
//            ],
               
               //"avatar":"http://avatar.example.com"
            //},
            //"tracking_data"=>"tracking data",            
        ];
        $res=$client->request('POST',$this->url_send,['headers' => $this->get_vheaders(), GuzzleHttp\RequestOptions::JSON => $body]);
        $b=$res->getBody();
        return $b;

    }

    public function bot_get(Request $request){
        return response()->json(['Success','viber bot'], 200);
    }

}
