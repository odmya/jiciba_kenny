<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RootcixingWord extends Model
{
    protected $fillable = ['word_id','rootcixing_id','detail','explain','root_alias'];
    protected $table = 'rootcixing_word';

    public function rootcixing()
    {
        return $this->belongsTo(Rootcixing::class);
    }

    public function word()
    {
        return $this->belongsTo(Word::class);
    }

}
