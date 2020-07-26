<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = ['type','price','description','dt','status','views','photos','prop_type'];
    
    public function vuser()
    {
      return $this->belongsTo(Vuser::class);
    }

    //public function 
}
