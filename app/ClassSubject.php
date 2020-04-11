<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassSubject extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "class_subjects";
    // protected $primaryKey = "class_subjects_id";
    public $timestamps = false;
}
