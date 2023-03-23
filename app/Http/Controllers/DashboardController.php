<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClubModel;
use App\ClubUserModel;
use App\MoviesModel;
use App\User;
use DB;

class DashboardController extends Controller
{
	protected $clubmodel;
    protected $user_info;
    protected $cuidmodel;
    protected $moviemodel;
    protected $usermodel;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
        $this->user_info = auth()->user();
        return $next($request);
        });
        $this->clubmodel = new ClubModel;
        $this->cuidmodel = new ClubUserModel;
        $this->moviemodel = new MoviesModel;
        $this->usermodel = new User;

    }

    public function index()
    {
    	$clubs =  $this->clubmodel->select('*')->where('uid', $this->user_info['uid'])->get();

    	$membership = $this->usermodel->where('uid' , $this->user_info['uid'])->with('membership')->get();
        dd($clubs);    	

        return view('dashboard');

    }

}
