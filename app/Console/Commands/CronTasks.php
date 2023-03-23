<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\TestModel as testmodel;
use App\ClubModel as clubmodel;
use App\User as usermodel;
use App\ClubUserModel;
use App\ClubRoundModel as clubroundmodel;
use App\MoviesModel as moviemodel;
use App\NextMovieModel as nextmoviemodel;
use Carbon\Carbon;
use DB;
class CronTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:movies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run each day 12AM to check movie time limit';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $moviesends = moviemodel::where('status',1)->whereDate('time_limit', '<', Carbon::today()->toDateString())->get();
        foreach ($moviesends as $movie) {
            DB::beginTransaction();
            try {
                $nextmovie = moviemodel::where(['cid'=>$movie->cid,'status'=>2])->first();
                if(!empty($nextmovie)){
                    $data = find_club_round($nextmovie->cid,$nextmovie->uid,$movie->rid);
                    $nextmovie->fill(['rid'=>$data['rid'],'status'=>1]);
                    $nextmovie->save();
                    nextmoviemodel::where('cid',$movie->cid)->update(['mid'=>null,'uid'=>$data['uid'],'status'=>0]);
                    $movieover = true;
                }
                else{
                    $nextpicker = nextmoviemodel::where('cid',$movie->cid)->first();
                    if(empty($nextpicker)){
                        $added = Carbon::parse($movie->time_limit)->addDays(3);
                        $movie->where('mid',$movie->mid)->update(['time_limit'=>$added]);
                        $movieover = false;
                    }else{
                        $data = find_club_round($nextpicker->cid,$nextpicker->uid,$movie->rid);
                        nextmoviemodel::where('cid',$movie->cid)->update(['uid'=>$data['uid'],'pass'=>1]);
                        $movieover = true;
                    }
                }
                if($movieover){
                    $movie::where('mid',$movie->mid)->update(['status'=>0]);
                }
                DB::commit();
            }catch (\Exception $e) {
                DB::rollback();
                die($e);
            }
        }
    }
}
