<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordBundle extends Model
{
    protected $table = 'wordbundle';
    protected $fillable = ['user_id','title','level_base_id','maxsize'];

    public function levelbase()
    {
        return $this->hasOne(LevelBase::class,'id', 'level_base_id');
    }
}
