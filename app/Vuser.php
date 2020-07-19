<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ad;

class Vuser extends Model
{
    protected $fillable = ['vid','name','nick','photo','phone','status'];

    public function Ads()
    {
        return $this->hasMany(Ad::class);
    }

    public function get_edit_ad(){
        return $this->ads()->where('status','2')->first();
    }
}
