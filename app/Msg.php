<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Msg extends Model
{
    protected $fillable = ['token','timestamp'];
    
    public function vuser()
    {
      return $this->belongsTo(Vuser::class);
    }
}
