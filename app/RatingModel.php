<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RatingModel extends Model
{
    protected $table = "ratings";
    protected $primaryKey = 'rid';

    protected $fillable = [
        'mid','uid','rating',
    ];

    public function users(){
        return $this->hasOne('App\User','uid','uid');
    }
}
