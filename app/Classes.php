<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model{

    protected $table = "class";
    // protected $primaryKey = "class_id";
    public $timestamps = false;

    /**
     * Get the students associated with the class.
     */
    public function students(){
        return $this->hasMany('App\Student','class_id');
    }
}
