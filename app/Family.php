<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Family extends Model{

    protected $table = "family";
    // protected $primaryKey = "class_id";
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
    ];

    /**
     * Get the students associated with the class.
     */
    public function students(){
        return $this->hasMany('App\Student','family_id');
    }
}
