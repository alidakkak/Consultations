<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\Consulation;
use App\Models\Experience;

class RegisterECController extends Controller
{
    // Register Experiences and Consulations for Expert //
    use GeneralTrait;
    public function RegisterE(Request $request){
        $experience=$request->experience;
        foreach ( $experience as $exp) {
            Experience::create([
                "title"=>$exp["title"],
                "description"=>$exp["description"],
                "years"=>$exp["years"],
                "user_id"=>Auth()->id()
            ]);}
        return  $this->returnSuccessMessage();
    }
    public function RegisterC(Request $request){
        $consulation=$request->consulation;
        foreach ( $consulation as $con) {
            Consulation::create([
                "title"=>$con["title"],
                "description"=>$con["description"],
                "price"=>$con["price"],
                "user_id"=>Auth()->id()
            ]);}
        return  $this->returnSuccessMessage();
   }
    public function complete_infoexpert(Request $request){
            User::find(Auth()->id())
              ->update([
                "specialization"=>$request->specialization,
                "category"=>$request->category,
                "address"=>$request->address,
                "Phone_Number"=>$request->Phone_Number,
            ]);
        return  $this->returnSuccessMessage();
    }

}
