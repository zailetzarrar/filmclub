<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClubUserModel extends Model
{
    protected $table = "club_member";
    protected $fillable = [
        'cid', 'uid', 'admin', 'position',
    ];

    //clubs
    public function get_clubs(){
        return $this->hasOne('App\ClubModel','cid','cid');
    }
    
}
