<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentModel extends Model
{
    protected $table = "discussions";
    protected $primaryKey = 'comid';

    protected $fillable = [
        'mid','uid','comment',
    ];

    public function comment_user(){
        return $this->hasOne('App\User','uid','uid');
    }
}
