<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamilyFeesDetail extends Model{

    protected $table = "family_fees_detail";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'family_id',
    ];

    public $timestamps = false;
}
