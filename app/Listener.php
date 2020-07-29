<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listener extends Model
{
    protected $fillable = ['type','type_prop'];
    
    public function vuser()
    {
      return $this->belongsTo(Vuser::class);
    }
}
