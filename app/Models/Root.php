<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Root extends Model
{

protected $fillable = ['name','description','version', 'types'];

  public function rootcixing()
  {

    return $this->hasMany(Rootcixing::class);

  }

}
