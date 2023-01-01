<?php

namespace App\Http\Controllers;

use App\Models\Availabletime;
use App\Models\Registeraton;
use App\Models\User;
use App\Traits\GeneralTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Time extends Controller
{
    use GeneralTrait;

    public function availabletime(Request $request){

        $times=$request->avaliabletimes;
        foreach($times as $time)
        {
            $avaliabletimes=new Availabletime();
            $avaliabletimes->day=$time["day"];
            $avaliabletimes->start_time=$time["start_time"];
            $avaliabletimes->end_time=$time["end_time"];
            $avaliabletimes->user_id=Auth()->id();
            $avaliabletimes->save();
        }
        $times_for_register= $times;
        foreach ($times_for_register as $time){
            $start_h= Carbon::createFromFormat( 'H:i:s' , $time["start_time"] )->format('H');
            $start_i= Carbon::createFromFormat( 'H:i:s' , $time["start_time"] )->format('i');
            $start_s= Carbon::createFromFormat( 'H:i:s' , $time["start_time"] )->format('s');
            $end_h = Carbon::createFromFormat( 'H:i:s' , $time["end_time"] )->format('H');
            $end_i = Carbon::createFromFormat( 'H:i:s' , $time["end_time"] )->format('i');
            $end_s = Carbon::createFromFormat( 'H:i:s' , $time["end_time"] )->format('s');
            $start= Carbon::create(2012, 9, 5, $start_h, $start_i, $start_s);
            $end=Carbon::create(2012, 9, 5, $end_h, $end_i, $end_s);
            $s=$start->copy()->addMinutes(30);
            while ($end->greaterThanOrEqualTo($s)){
                $start_registeraton=$start->format('H:i:s');
                $end_registeraton=$start->addMinutes(30)->format('H:i:s');
                $start->addMinutes(10);
                $s=$s->addMinutes(40);
                Registeraton::create([
                    "day"=> $time["day"],
                    "registered"=> 0,
                    "start_time"=>  $start_registeraton,
                    "end_time"=>$end_registeraton,
                    "user_id"=>Auth()->id(),
                ]);
            }
        }
        return  $this -> returnSuccessMessage('Added');

    }
    public function getregisteraton(Request $request){
        if ($request->expert_id==null){
            return  $this -> returnError('false','send expert_id');
        }
        $x= User::find($request->expert_id);
        if (!$x ){
            return  $this -> returnError('404',' expert not found');
        }
        $registreation=   Registeraton::where("user_id",$request->expert_id)->get();
        return  $this -> returnData('registreation',$registreation,"sucesse");

    }
    public function getregisted(){

      $registed=Registeraton::where([["user_id",Auth()->id()],[ "registered",1]])->get();
        return  $this -> returnData('registed',$registed,"sucesse");
    }
    public function saveregisteraton(Request $request){
        if ($request->registeraton_id==null){
            return  $this -> returnError('false','send registeraton_id');
        }
        $x= Registeraton::find($request->registeraton_id);
        if (!$x ){
            return  $this -> returnError('404',' registeraton not found');
        }
           Registeraton::where("id",$request->registeraton_id)
            ->update([
            "registered"=> 1,
            "normal_id"=>Auth()->id()
        ]);
        return  $this->returnSuccessMessage();

    }

}
