<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model{
    // protected $primaryKey = "student_id";
    public $timestamps = false;

    /**
     * Get the class associated with the student.
     */
    public function class(){
        return $this->belongsTo('App\Classes','class_id');
    }

    public function family(){
        return $this->belongsTo('App\Family','family_id');
    }
}


