<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ad;
use App\Findprop;
use App\Msg;

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
}
