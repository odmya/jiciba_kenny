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
    public function scopeRecent($query)
      {
          // 按照创建时间排序
          return $query->orderBy('created_at', 'desc');
      }


}
