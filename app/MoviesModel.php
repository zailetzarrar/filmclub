<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoviesModel extends Model
{
	protected $table = "movies";
    protected $primaryKey = 'mid';

    protected $fillable = [
        'uid', 'round','cid','title', 'director','year','description','genres','poster','time_limit','status','rid',
    ];


    public function curr_movie_user(){
        return $this->hasOne('App\User','uid','uid');
    }

    public function ratings()
    {
        return $this->hasMany('App\RatingModel','mid','mid');
    }

    public function ratings_given()
    {
        return $this->hasMany('App\RatingModel','mid','mid');
    }

    public function comments()
    {
        return $this->hasMany('App\CommentModel','mid','mid');
    }
}
