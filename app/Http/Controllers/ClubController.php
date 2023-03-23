<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use App\ClubModel;
use App\User;
use App\ClubUserModel;
use App\ClubRoundModel;
use App\RatingModel as ratingmodel;
use App\MoviesModel;
use App\NextMovieModel;
use App\Http\Controllers\MovieController;
use DB;


class ClubController extends Controller
{
    protected $user_info;
    protected $clubmodel;
    protected $cuidmodel;
    protected $moviecontroller;
    protected $moviemodel;
    protected $croundmodel;
    protected $nextmoviemodel;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
        $this->user_info = auth()->user();
        return $next($request);
        });
        $this->usermodel = new User;
        $this->clubmodel = new ClubModel;
        $this->cuidmodel = new ClubUserModel;
        $this->croundmodel = new ClubRoundModel;
        $this->moviemodel = new MoviesModel;
        $this->nextmoviemodel = new NextMovieModel;
        $this->moviecontroller = new MovieController;
    }

    public function index()
    {
        return view('create-club');
    }


    public function ajax_handler()
    {
    	$request = Request();
    	$data = $request->all();
        if( isset($data['requesting']) ){
        $data['film']['time_limit'] = time_formater($data['film']['time_limit']);
        $validations = $this->data_validation($data['club']);
        $validations_external = $this->moviecontroller->data_validation($data['film']);
        if(!empty($validations)){ 
            return response()->json(['error'=>$validations]);
        }
        if(!empty($validations_external)){ 
            return response()->json(['error'=>$validations_external]);
        }
      	if( $data['requesting']=='club_create_request') {
      	    return $this->creat_club($data);
          }
        }
    }

    public function creat_club($data)
    {
        //create token for club
        $token = Str::random(16).md5(time());
        $data['club']['uid'] = $data['film']['uid'] = $this->user_info['uid'];
        $data['club']['token'] = $token;
        $data['film']['status'] = 1;
        DB::beginTransaction();
        try {
            $clubs = $this->clubmodel::create($data['club']);
            $cid = $clubs->cid;
            $cuid_data = array('cid' => $cid , 'uid' => $this->user_info['uid'] , 'admin' => 1 , 'position' => 1);
            $this->cuidmodel->create($cuid_data);
            //get club id for movie
            $data['film']['cid'] = $cid;
            //insert in round table
            $rid = $this->croundmodel::insertGetId(array('cid'=>$cid,'created_at'=>date('Y-m-d H:i:s')));
            $data['film']['rid'] = $rid;
            $this->moviecontroller->insertmovie($data['film']);
            $link = url('/').'/invitation/'.$token;
            $this->clubmodel::where('cid',$cid)->update(['link'=>$link]);
            DB::commit();
            $faketoken = env('clubtoken');
            $fakelink = url('/').'/club-info/'.$faketoken;
            return response()->json(['success' => $link,'fakelink'=>$fakelink], Response::HTTP_CREATED);
          }catch (\Exception $e){
           DB::rollback();
           return response()->json(['error' => 'Opps! problem occured try again later.If you still face the same issue again please contact us'],Response::HTTP_UNPROCESSABLE_ENTITY);
          }

    }


    public function club_stats()
    { 
        $request = Request();
        $params = $request->route()->parameters();
        if(empty($params)){
            return response()->json(['message' => 'Not Found!'], 404); 
        } 
        if(count($params)==2){
            // stats where user as admins of that clubs
            $club_stats =  $this->clubmodel->select('*')->where([['uid' ,'=', $this->user_info['uid']],['cid','=',$params['id']]])->first();
            if(empty($club_stats)){
                dd('no club found');
            }
            $movie = $this->moviemodel->select('*')->where([['uid' ,'=', $this->user_info['uid']],['cid','=',$club_stats->cid],['status','=',1]])->first();
            dd($movie);
        }
        else{
            // stats where user as member of that clubs
            if($this->cuidmodel->select('cid')->where([['uid' ,'=', $this->user_info['uid']],['cid','=',$params['id']],['admin','=',0]])->first()){
            $club_stats = $this->clubmodel::find($params['id']);
            $movie = $this->moviemodel->select('*')->where([['uid' ,'=', $this->user_info['uid']],['cid','=',$club_stats->cid],['status','=',1]])->first();
            if(empty($club_stats)){
                dd('no club found');
            }
            dd($club_stats);                       
            }
            dd('no club found outer');
          }
    }


    public function club_info($token)
    {
        $cid = $this->clubmodel->select('cid')->where('token',$token)->firstOrFail()->cid;
        //check user is member or not for the requested club
        if(!$this->cuidmodel->select('uid')->where([['uid' ,'=', $this->user_info['uid']],['cid','=',$cid]])->first()){
            return redirect('/')->with('error', 'No club found');
        }
        //current movie for the club
        if($cpick = $this->moviemodel->select('*')->where(['cid'=>$cid,'status'=>1])->with('curr_movie_user')->first()){
              $cmid = $cpick->mid;
        }else { $cmid = null; }
        //fetch club data with rounds,movies and members
        $club =  $this->clubmodel->with(['rounds'=> function ($query) use ($cmid){ 
            $query->with(['movies' => function($query2) use ($cmid){
                $query2->with('ratings')->where('mid','!=',$cmid)->get();
              }])->get();
        },'members'])->find($cid);
        //next movie picker
        $npick = $this->nextmoviemodel::where(['cid'=>$cid])->first();
        if(!empty($npick)){
            if($npick->status == 1){
              //if its 1 movie picked by user
                $npick = 1;
            }else
            //else findout whos turn
             $npick = $this->usermodel::select('username','uid')->where('uid',$npick->uid)->first();
        }
        return view('dashboard',compact('cpick','club','npick'));
    }

    public function awards($token){
        $cid = $this->clubmodel->select('cid')->where('token',$token)->firstOrFail()->cid;
        //check user is member or not for the requested club
        if(!$this->cuidmodel->select('uid')->where([['uid' ,'=', $this->user_info['uid']],['cid','=',$cid]])->first()){
            return redirect('/')->with('error', 'No club found');
        }
        //average rating given to other members
          $rat_given = $this->clubmodel::find($cid)->members()->with(['user_movies'=>function($query) use ($cid){
            $query->with(['ratings_given'=>function($query2){
                $query2->where('uid',$this->user_info['uid'])->get();
            }])->where(['cid'=>$cid,'status'=>0])->get();
          }])->wherePivot('uid','!=',$this->user_info['uid'])->get();

        //average rating recieved from other members
         $rat_recieved = $this->moviemodel->with(['ratings_given'=>function($query){
            $query->with('users')->where('uid','!=',$this->user_info['uid'])->get();
         }])->where(['cid'=>$cid,'uid'=>$this->user_info['uid'],'status'=>0])->get();

         //users rating history
          $user_rat_hist = $this->clubmodel::find($cid)->members()->with(['user_movies'=>function($query) use ($cid){
            $query->with('ratings_given')->where(['cid'=>$cid,'status'=>0])->get();
          }])->get();
          
         //analytics of ratings for each user
          $users = $this->clubmodel::find($cid)->members()->get();
          $movies = $this->moviemodel->with('curr_movie_user')->where('cid',$cid)->get();
          foreach ($movies as $movie) {
              $average = $movie->ratings_given()->avg('rating');
              $movie->setAttribute('average',$average);
              //best($best) and ($worst) movie in the club
              if($average == null){ continue; }
              if(!empty($waverage)){ 
                  if($average<$waverage && $average != null){ $worst = $movie; $waverage = $average; }
                  if($average>$baverage){  $best = $movie; $baverage = $average; }
              }else{ 
                $best = $movie;  $worst = $movie;
                $baverage = $waverage= $average;
              }
          }
          //user ratings in the club with average
          foreach ($users as $user) {
            $avg = []; $arr_average = []; $average = 0;
              foreach ($movies as $movie) {
                  $avg[] = $movie->ratings_given()->where('uid',$user->uid)->avg('rating');
              }
              $arr_average = $avg;
              $average = number_format((array_sum($avg)/count($avg)),2);
              $user->setAttribute('average_arr',$arr_average);
              $user->setAttribute('average',$average);
              //harshest critic & generous 
              if($average == null){ continue; }
              if(!empty($laverage)){ 
                  if($average<$laverage){ $hc = $user; $laverage = $average; }
                  if($average>$haverage){  $gc = $user; $haverage = $average; }
              }else{ 
                $hc = $user;  $gc = $user;
                $laverage = $haverage= $average;
              }
          }
     
         return view('stats',compact('rat_given','rat_recieved','user_rat_hist','hc','gc','best','worst'));
    }



    public function data_validation($data)
    { 

        $validator = \Validator::make($data, [
            'name' => 'required|string',
            'members' => 'required|integer',
        ]);

        if ($validator->fails()) { 
            return $response['error'] = $validator->errors()->all();
        }

    }


}
