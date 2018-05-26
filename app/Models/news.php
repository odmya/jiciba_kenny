<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class news extends Model
{

  protected $fillable = ['title','sub_title','author','category_id','image','description','is_enable','count'];

  public function scopeRecent($query)
    {
        // 按照创建时间排序
        return $query->orderBy('created_at', 'desc');
    }


}
