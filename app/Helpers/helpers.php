<?php
use App\ClubModel as clubmodel;
use App\User;
use App\ClubUserModel as cuimodel;
use App\MoviesModel;
use App\NextMovieModel as nextmoviemodel;
use App\ClubRoundModel as roundmodel;


function film_find_last_position($cid) {
	return clubmodel::with(['club_name_last_position' => function($query){
		$query->latest('position')->first();
	}])->find($cid);
}

function member_joined_club($cid) {
	clubmodel::where('cid',$cid)->increment('joined');
}

function first_update_next_table($cid,$uid) {
    $entry = nextmoviemodel::where('cid',$cid)->first();
    if(empty($entry)){
        nextmoviemodel::unguard();
        $arr = ['cid'=>$cid,'uid'=>$uid,'status'=>0];
        nextmoviemodel::create($arr);
        nextmoviemodel::reguard();
    }
}


?>