<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phrase extends Model
{
    //
    protected $fillable = ['english','chinese','s_url','n_url','f_url','default_url'];
    public function section()
    {

      return $this->belongsToMany(Section::class);

    }


}
