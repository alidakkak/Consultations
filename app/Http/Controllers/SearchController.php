<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Experience;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    use GeneralTrait;
        /////////////  الطلبات الأساسية/////////////
    ////////////////// Search By Name, Category //////////////////
    public function search(Request $request){
        if ($request->search==null){
            return  $this -> returnError('false','send search');
        }
        $search = $request->input('search');
        $posts = User::query()
            ->where([['name', 'LIKE', "%{$search}%"],["role","expert"]])
            ->orWhere('Category', 'LIKE', "%{$search}%")
            ->get();
        return  $this -> returnData('posts',$posts,"sucesse");
    }
    public function detels(Request $request) {
        if ($request->expert_id==null){
            return  $this -> returnError('false','send expert_id');
        }
        $x= User::find($request->expert_id);
        if (!$x ){
            return  $this -> returnError('404',' expert not found');
        }
        $detels = User::with("Experience"/*, "Registeraton"*/, "Availabletime", "Consulation")
        ->where('id', $request ->expert_id)->get();
        return  $this -> returnData('expert',$detels,"sucesse");
    }
}
