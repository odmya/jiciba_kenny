<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //
    protected $fillable = ['name','sub_header','image','price','discount_price','free','description'];
    public function chapter()
    {

      return $this->hasMany(Chapter::class);

    }

}
