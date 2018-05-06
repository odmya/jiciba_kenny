<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NovelType extends Model
{
    protected $table = 'novel_types';
    protected $fillable = ['name'];

    public function novel()
    {
        return $this->hasMany(Novel::class);
    }
}
