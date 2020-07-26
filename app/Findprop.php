<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Findprop extends Model
{
    protected $fillable = ['type','prop_type'];
    
    public function vuser()
    {
      return $this->belongsTo(Vuser::class);
    }
}
