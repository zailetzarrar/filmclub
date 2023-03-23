<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClubModel extends Model
{
	protected $table = "club";
    protected $primaryKey = 'cid';
    protected $fillable = [
        'uid','name', 'members', 'token',
    ];

    public function movies()
    {
        return $this->hasMany('App\MoviesModel');
    }

    public function rounds()
    {
        return $this->hasMany('App\ClubRoundModel','cid','cid');
    }

    public function members()
    {
        return $this->belongsToMany('App\User','club_member','cid','uid');
    }

    //club name with last position
    public function club_name_last_position(){
        return $this->hasOne('App\ClubUserModel','cid');
    }

    //directly access the ratings
    public function averageratings()
    {
        return $this->hasManyThrough('App\RatingModel', 'App\MoviesModel','cid','mid','cid','cid');
    }
    
}
