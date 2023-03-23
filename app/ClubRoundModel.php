<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClubRoundModel extends Model
{
    protected $table = "club_rounds";
    protected $fillable = ['cid'];

    public function movies()
    {
        return $this->hasMany('App\MoviesModel','rid','id');
    }
}
