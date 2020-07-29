<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp;
use Response;
use App\Vuser;
use App\Ad;
use App\Http\Controllers\ins_ad;
use App\Http\Controllers\read_ad;
use App\Http\Controllers\Keyboards;

class viber extends Controller
{
    //public $token='492f977a90e7d70a-18d9b191728f6f18-7f85f97681896b9';

    public $token='48380f53e9e7d686-355fd1effe2d68ee-c92301ccbfd6a9df';
    public $url='https://chatapi.viber.com/pa/set_webhook';
    public $url_send='https://chatapi.viber.com/pa/send_message';
    public $host='https://b2b81474d3b1.ngrok.io';



    public function get_vheaders(){
        return ['X-Viber-Auth-Token' => $this->token, 'Content-Type' => 'multipart/form-data' ];
    }    

    public function sethook(Request $request){                    
        $b = $this->setwhook();

        return response()->json(["success"], 200);
    }

    public function setwhook(){        

        $client= new GuzzleHttp\Client();
        
        $body = ['url'=>$this->host.'/api/bot',
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

    public function home_menu($content){
        $k=new Keyboards();
        $vuser=$this->get_vuser($content);
        $sender=$vuser->vid;
        $kb=$k->action_keyboard;
        $kb['tracking_data']='action';
        $this->send_keyboard($sender,$kb);
    }

    public function process($content){
        $vuser=$this->get_vuser($content);
        $ins_ad=new ins_ad();
        $read_ad=new read_ad();
        $k=new Keyboards();

        if ($content["event"]=="subscribed"){
            $this->home_menu($content);            
            
        }elseif ($content["event"]=="message"){                                
            try{
                if($content['message']['text']=='home'){
                    $this->home_menu($content);
                }
            }catch( \Exception $e){

            }

            $sender=$content["sender"]["id"];
            $td=$content['message']['tracking_data'];

            $array=['ins_ad','read_ad','ins_rent','ins_sale','read_rent','read_sale'];
            //если сообщение с первым выбором
            if ($td=='action'){
                if($content['message']['text']=='1'){   
                    $kb=$k->type_ad_keyboard;
                    $kb['tracking_data']='type_ad';
                    $this->send_keyboard($sender,$kb);
                }elseif($content['message']['text']=='2'){
                    $kb=$k->type_ad_keyboard;
                    $kb['keyboard']['Buttons']=array_merge($k->top_buttons,$kb['keyboard']['Buttons']);
                    $kb['tracking_data']='read_type_ad';
                    $this->send_keyboard($sender,$kb);
                }
            //если трекинг для подачи объявлений
            }elseif (in_array($td,['type_ad','type_prop','location','price','photo1','photo2','photo3','photo4','photo5','description','publish'])){
                $ad=$vuser->get_edit_ad();
                $next_kb=$ins_ad->edit_ad($ad,$content);
                $res=$this->send_keyboard($sender,$next_kb);
            //если трекинг для настройки получение объявлений
            }elseif(in_array($td,['read_type_ad','read_type_prop','set_prop'])){
                $f=$vuser->get_findprop();
                $next_kb=$read_ad->set_prop_ad($this->host,$vuser,$f,$content);
                $res=$this->send_keyboard($sender,$next_kb);
                //$f=$vuser->get_findprop();
                //$kb=$k->set_read_prop($f,$content);
                //$res=$this->send_keyboard($sender,$kb);
            }elseif($td=='page_'){
                $this->get_ad($vuser,$td);
            }
            //$text=$content["message"]["text"];                        
        }        
    }

    public function bot(Request $request){
        $content=$request->all();
        $event=$content['event'];

        error_log('recieve event');

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
        error_log($b);
        return $b;

    }

    public function bot_get(Request $request){
        return response()->json(['Success','viber bot'], 200);
    }

}
