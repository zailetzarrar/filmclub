<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MoviesModel;
use App\RatingModel;
use App\CommentModel;
use DB;

class MovieController extends Controller
{
	protected $user_info;
	protected $moviemodel;
    protected $ratingmodel;
    protected $commentmodel;

	public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
        $this->user_info = auth()->user();
        return $next($request);
        });

        $this->moviemodel = new MoviesModel;
        $this->ratingmodel = new RatingModel;
        $this->commentmodel = new CommentModel;
    }

    public function ajax_handler()
    {
        $request = Request();
        $data = $request->all();
        $validations = $this->data_validation($data['film']);

        if(!empty($validations)){ 
            return response()->json(['error'=>$validations]);
        }
        
        if( isset($data['requesting']) && $data['requesting']=='movie_create_request' ){
            //before insert to db check the round
            $data['film']['round'] = check_round($data['cid']);
            DB::beginTransaction();
            try {
                $this->insertmovie($data['film']);
                DB::commit();
                return "success";
                }catch (\Exception $e) {
                DB::rollback(); 
                return "Error please try again later";
              }
        }
    }

    public function discussion($title){
        $movie = $this->moviemodel::with(['comments'=> function($query){
            $query->with('comment_user');
        }])->where('title',$title)->first();
        return view('discussion',compact('movie'));
    }

    public function data_validation($data){ 
        $validator = \Validator::make($data, [
            'title' => 'required|string',
            'director' => 'required|string',
            'year' => 'required|integer',
            'description' => 'required|string',
            'poster' => 'string',
            'time_limit' => 'required|date_format:Y-m-d H:i:s',
        ]);


        if ($validator->fails()) { 
            return $response['error'] = $validator->errors()->all();
        }
    }

    public function check_round($cid){
        return $round = $this->moviemodel->select('round')->where('cid',$cid)->lastest()->first();
    }

    //movie ratings
    public function submit_rating($just_comment=null){
        $request = Request()->all();
        unset($request->token);
        $mid = \Crypt::decryptString($request['mmdd']);
        //comment array
        $comarr = ['mid'=>$mid,'uid'=>$this->user_info['uid'],'comment'=>$request['comment']];
        if($just_comment !=null){
            if($just_comment == 'true'){
            $this->insert_comment($comarr);
            return redirect()->back();
            exit;
            }else{ return abort(404); }
        }
        //check user if user already submitted the ratings or not
        if($this->ratingmodel::where(['mid'=>$mid,'uid'=>$this->user_info['uid']])->first()){
            return back()->with('message','You already submitted the ratings for this movie');
        }
        //rating array
        $ratarr = ['mid'=>$mid,'uid'=>$this->user_info['uid'],'rating'=>$request['rating']];
        DB::beginTransaction();
        try {
            if(!empty($request['rating'])){
            $this->ratingmodel::create($ratarr); }
            if(!empty($request['comment'])){
                $this->insert_comment($comarr); }
            DB::commit();
            return back()->with('message','Recorded Successfully');
            }catch (\Exception $e) {
            DB::rollback(); 
            die($e);
            return back()->with('message','Oops! Problem occured try again later.If you continue face the issue please contact us');
          }        
    }

    //insert comment
    public function insert_comment($comarr){
        $this->commentmodel::create($comarr);
    }


}
