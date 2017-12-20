<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    //
    protected $fillable = ['course_id','name','sub_header','description','notes'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function section()
    {

      return $this->hasMany(Section::class);

    }

    


}
