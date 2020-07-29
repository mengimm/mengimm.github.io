<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ad;
use App\Findprop;
use App\Msg;
use App\Listener;

class Vuser extends Model
{
    protected $fillable = ['vid','name','nick','photo','phone','status'];

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }    

    public function findprops()
    {
        return $this->hasMany(Findprop::class);
    }

    public function listeners()
    {
        return $this->hasMany(Listener::class);
    }

    public function get_edit_ad(){
        $ad=$this->ads()->where('status','2')->first();
        if ($ad==null){
            $ad=new Ad();            
            $ad->status=2;
            $this->ads()->save($ad);            
        }
        return $ad;
    }

    public function get_findprop(){
        $f=$this->findprops()->first();
        if ($f==null){
            $f=new Findprop();            
            $this->findprops()->save($f);
        }
        return $f;
    }

    public function msgs()
    {
        return $this->hasMany(Msg::class);
    }

    public function msg_exists($token,$timestamp){
        try{
            $m=$this->msgs()->where('token',$token)->first();
        }catch( \Exception $e){
            $m=null;
        }
        
        if ($m==null){
            $m=new Msg();            
            $m->token=$token;
            $m->timestamp=$timestamp;
            $this->msgs()->save($m);
            return false;
        }else{
            return true;
        }
        
    }

    public function make_listener($type,$type_prop){
        //создать слушатели для всех
        if ($type==0){
            foreach([1,2] as $t){
                foreach([1,2,3,4,5] as $tp){
                $this->listen($t,$tp);
                }
            }
        //создать слушатели для типов объектов
        }elseif($type_prop==0){
            foreach([1,2,3,4,5] as $tp){
                $this->listen($type,$tp);
            }
        }else{
        //создать слушатель
            $this->listen($type,$type_prop);
        }
    }

    public function listen($type,$type_prop){
        try{
            $l=$this->listeners()->where('type',$type)->where('type_prop',$type_prop)->first();
        }catch( \Exception $e){
            $l=null;
        }
        
        if ($l==null){
            $l=new Listener();
            $l->type=$type;
            $l->type_prop=$type_prop;            
            $this->listeners()->save($l);
        }
        return $l;        
    }


}
