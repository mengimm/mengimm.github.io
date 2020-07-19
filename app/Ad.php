<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = ['type','price','description','dt','status','views','photos'];
    
    public function Vuser()
    {
      return $this->belongsTo(Vuser::class);
    }
}
