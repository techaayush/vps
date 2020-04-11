<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcademicYearHistory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'session',
    ];

    protected $table = "academic_year_history";
    // protected $primaryKey = "academic_year_history_id";
    public $timestamps = false;
}
