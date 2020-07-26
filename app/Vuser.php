<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ad;
use App\Findprop;

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
        $f=$this->ads()->first();
        if ($f==null){
            $f=new Findprop();            
            $this->ads()->save($f);
        }
        return $f;
    }
}
