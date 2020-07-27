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
    public $host='https://e4a953919304.ngrok.io/api/bot';

    public $action_keyboard=
    [
        "min_api_version"=>7,        
            "Type"=>"keyboard",
            "DefaultHeight"=>true,
            "BgColor"=>"#FFFFFF",
            "tracking_data"=>"action",
            "keyboard"=>[
            "Buttons"=>[    
                [
                    "Columns"=>3,
                    "Rows"=>1,
                    "ActionType"=>"reply",
                    "ActionBody"=>"1",
                    "Text"=>"<font color=#000000>Подать объявление</font>",
                    "TextSize"=>"large",
                    "TextVAlign"=>"middle",
                    "TextHAlign"=>"middle",
                ],
                [
                    "Columns"=>3,
                    "Rows"=>1,
                    "ActionType"=>"reply",
                    "ActionBody"=>"2",
                    "Text"=>"<font color=#000000>Смотреть объявления</font>",
                    "TextSize"=>"large",
                    "TextVAlign"=>"middle",
                    "TextHAlign"=>"middle",
                ]
            ]
        ]];

        public $type_ad_keyboard=
        [
            "min_api_version"=>7,        
                "Type"=>"keyboard",
                "DefaultHeight"=>true,
                "BgColor"=>"#FFFFFF",
                "tracking_data"=>"type_ad",
                "keyboard"=>[
                "Buttons"=>[    
                    [
                        "Columns"=>6,
                        "Rows"=>1,
                        "ActionType"=>"reply",
                        "ActionBody"=>"1",
                        "Text"=>"<font color=#000000>Аренда</font>",
                        "TextSize"=>"large",
                        "TextVAlign"=>"middle",
                        "TextHAlign"=>"middle",
                    ],
                    [
                        "Columns"=>6,
                        "Rows"=>1,
                        "ActionType"=>"reply",
                        "ActionBody"=>"2",
                        "Text"=>"<font color=#000000>Продажа</font>",
                        "TextSize"=>"large",
                        "TextVAlign"=>"middle",
                        "TextHAlign"=>"middle",
                    ]
                ]
            ]];  

    public $type_prop_keyboard=
            [
                "min_api_version"=>7,        
                    "Type"=>"keyboard",
                    "DefaultHeight"=>true,
                    "BgColor"=>"#FFFFFF",
                    "tracking_data"=>"type_prop",
                    "keyboard"=>[
                    "Buttons"=>[    
                        [
                            "Columns"=>6,
                            "Rows"=>1,
                            "ActionType"=>"reply",
                            "ActionBody"=>"1",
                            "Text"=>"<font color=#000000>Квартира</font>",
                            "TextSize"=>"large",
                            "TextVAlign"=>"middle",
                            "TextHAlign"=>"middle",
                        ],
                        [
                            "Columns"=>6,
                            "Rows"=>1,
                            "ActionType"=>"reply",
                            "ActionBody"=>"2",
                            "Text"=>"<font color=#000000>Гараж</font>",
                            "TextSize"=>"large",
                            "TextVAlign"=>"middle",
                            "TextHAlign"=>"middle",
                        ],
                        [
                            "Columns"=>6,
                            "Rows"=>1,
                            "ActionType"=>"reply",
                            "ActionBody"=>"3",
                            "Text"=>"<font color=#000000>Частный дом</font>",
                            "TextSize"=>"large",
                            "TextVAlign"=>"middle",
                            "TextHAlign"=>"middle",
                        ],
                        [
                            "Columns"=>6,
                            "Rows"=>1,
                            "ActionType"=>"reply",
                            "ActionBody"=>"4",
                            "Text"=>"<font color=#000000>Участок</font>",
                            "TextSize"=>"large",
                            "TextVAlign"=>"middle",
                            "TextHAlign"=>"middle",
                        ],
                        [
                            "Columns"=>6,
                            "Rows"=>1,
                            "ActionType"=>"reply",
                            "ActionBody"=>"5",
                            "Text"=>"<font color=#000000>Коммерческое</font>",
                            "TextSize"=>"large",
                            "TextVAlign"=>"middle",
                            "TextHAlign"=>"middle",
                        ]
                    ]
                ]];  


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
    public $location_keyboard=[        
        "Type"=>"keyboard",
        "min_api_version"=>7,        
        "tracking_data"=>"location",
        "keyboard"=>[
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

     public $price_keyboard=[
        "type"=>"text",
        "text"=>"укажите стоимость в тыс.р. (например 3,5)",
        "min_api_version"=>7,
        "tracking_data"=>"price",        
     ];

     public $description_keyboard=[
        "type"=>"text",
        "text"=>"добавьте описание",
        "min_api_version"=>7,
        "tracking_data"=>"description",        
     ];

     public $photo_keyboard=[
        "type"=>"text",
        "text"=>"отправьте до 5ти фотографий объекта или нажмите завершить если не хотите опубликовать фото",
        "min_api_version"=>7,        
        "tracking_data"=>"photo1",
        "keyboard"=>[
           "DefaultHeight"=>true,
           "Buttons"=>[
              [
                 "ActionType"=>"reply",
                 "ActionBody"=>"end_photo",
                 "Text"=>"завершить",
                 "TextSize"=>"regular"
              ]
           ]
        ]
     ];     

     public $publish_keyboard=
    [
        "min_api_version"=>7,        
            "Type"=>"keyboard",
            "DefaultHeight"=>true,
            "BgColor"=>"#FFFFFF",
            "tracking_data"=>"publish",
            "keyboard"=>[
            "Buttons"=>[    
                [
                    "Columns"=>3,
                    "Rows"=>1,
                    "ActionType"=>"reply",
                    "ActionBody"=>"1",
                    "Text"=>"<font color=#000000>Опубликовать</font>",
                    "TextSize"=>"large",
                    "TextVAlign"=>"middle",
                    "TextHAlign"=>"middle",
                ],
                [
                    "Columns"=>3,
                    "Rows"=>1,
                    "ActionType"=>"reply",
                    "ActionBody"=>"2",
                    "Text"=>"<font color=#000000>Отмена</font>",
                    "TextSize"=>"large",
                    "TextVAlign"=>"middle",
                    "TextHAlign"=>"middle",
                ]
            ]
        ]];

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

    public function process($content){
        $vuser=$this->get_vuser($content);

        if ($content["event"]=="subscribed"){
            $vuser=$this->get_vuser($content);
            $sender=$content["user"]["id"];            
            $this->send_keyboard($sender,$this->action_keyboard);
            
        }elseif ($content["event"]=="message"){            
            $sender=$content["sender"]["id"];            
            $td=$content['message']['tracking_data'];
            //if ($td=='')
            $array=['ins_ad','read_ad','ins_rent','ins_sale','read_rent','read_sale'];
            //если сообщение с первым выбором
            if ($td=='action'){
                if($content['message']['text']=='1'){                    
                    $this->send_keyboard($sender,$this->type_ad_keyboard);
                }elseif($content['message']['text']=='2'){
                    $this->send_keyboard($sender,$this->choise_ad_keyboard);
                }
                $ad=$vuser->get_edit_ad();
                $kb=$this->edit_ad($ad,$content);                
                $this->send_keyboard($sender,$kb);
                //если трекинг для подачи объявлений
            }elseif (in_array($td,['type_ad','type_prop','location','price','photo1','photo2','photo3','photo4','photo5','description','publish'])){
                $ad=$vuser->get_edit_ad();
                $next_kb=$this->edit_ad($ad,$content);                
                $res=$this->send_keyboard($sender,$next_kb);
                //$p=$res->getBody();
                //если трекинг для получение объявлений
            }elseif(in_array($td,['get_ad','find_choise_ad','find_choise_type'])){
                $f=$vuser->get_findprop();
                $kb=$this->set_read_prop($f,$content);
                $res=$this->send_keyboard($sender,$kb);
                //$p=$res->getBody();
            }elseif($td=='page_'){
                $this->get_ad($vuser,$td);
            }
            //$text=$content["message"]["text"];                        
        }        
    }

    public function bot(Request $request){
        $content=$request->all();
        $event=$content['event'];
        //обрабатываем тип "сообщение"

        if ($event=='webhook'){

        }elseif(in_array($event,['subscribed','message'])){
            $vuser=$this->get_vuser($content);
            if ($vuser->msg_exists($content['message_token'],$content['timestamp'])==false){        
                $this->process($content);
            }

        }                
        return response()->json(['Success','viber bot'], 200);
    }

    public function edit_ad($ad,$content){
        //$a=$vuser->get_edit_ad();
        //$id=$content['message']['id'];
        //$id="NAI5XANdAmJLb0oeJ7gIaA==";

        $td=$content['message']['tracking_data'];
        if ($td=='type_ad'){
            $ad->type=$content['message']['text'];
            $kb=$this->type_prop_keyboard;
        }elseif($td=='type_prop'){
            $ad->prop_type=$content['message']['text'];
            $kb=$this->location_keyboard;
        }elseif($td=='location'){
            $ad->lat=$content['message']['location']['lat'];
            $ad->lon=$content['message']['location']['lon'];
            $kb=$this->price_keyboard;
        }elseif($td=='price'){
            $ad->price=$content['message']['text'];
            $kb=$this->photo_keyboard;
        }elseif(in_array($td,['photo1','photo2','photo3','photo4','photo5'])){
            if ($content['message']['type']=='picture'){
                $kb=$this->photo_keyboard;
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
                    $kb=$this->description_keyboard;
                }                                
            }else{
                $kb=$this->description_keyboard;                
            }                                  
        }elseif($td=='description'){
            $ad->description=$content['message']['text'];
            $kb=$this->publish_keyboard;
        }elseif($td=='publish'){
            if ($content['message']['text']=='1'){
                $ad->status=1;
                $ad->save();
                $kb=$this->show_ad($content['sender']['id'],$ad);
            }
    }                        
        $ad->save();        
        return $kb;
    }

    public function show_ad($id,$ad){
    $keyboard=
    [
        "min_api_version"=>7,        
            "Type"=>"keyboard",
            "DefaultHeight"=>true,
            "BgColor"=>"#FFFFFF",
            "tracking_data"=>"detail_photo",
            "keyboard"=>[
            "Buttons"=>[    
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
                    "Text"=>"<font color=#000000>подробно</font>",
                    "TextSize"=>"large",
                    "TextVAlign"=>"middle",
                    "TextHAlign"=>"middle",
                ]
            ]
        ]];

        return $keyboard;
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
        try{
            $id=$content['sender']['id'];
        } catch (\Exception $e) {
            $id=$content["user"]["id"];
        }
        
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
        $id="NAI5XANdAmJLb0oeJ7gIaA==";
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
