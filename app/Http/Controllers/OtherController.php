<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class OtherController extends Controller
{
    use GeneralTrait;
    //wishlist
    public function getwishlist()
    {
        $u = User::find(Auth()->id());
        if (!$u) {
            return  $this->returnError('404', ' user not found');
        }
        return  $this->returnData('wishlist', $u->expert, "sucesse");
    }
    // 
    public function savewishlist(Request $request)
    {
        $u = User::find(Auth()->id());
        if ($request->expert_id == null) {
            return  $this->returnError('false', 'send expert_id');
        }
        $x = User::find($request->expert_id);

        if (!$u) {
            return  $this->returnError('404', ' user not found');
        }
        if (!$x) {
            return  $this->returnError('404', ' expert not found');
        }
        $u->expert()->syncWithoutDetaching($request->expert_id);

        return  $this->returnSuccessMessage('Added');
    }
    //rating
    public function saverating(Request $request)
    {
        if ($request->expert_id == null) {
            return  $this->returnError('false', 'send expert_id');
        }
        $x = User::find($request->expert_id);
        if (!$x) {
            return  $this->returnError('404', ' expert not found');
        }
        $old_rating = User::select("rating")->where("id", $request->expert_id)->get();
        if ($old_rating[0]["rating"] == null) {
            $old_rating[0]["rating"] = 0;
        }
        $new_rating = ($old_rating[0]["rating"] + $request->rating) / 2;
        $new_rating = number_format($new_rating, 1);
        User::where("id", $request->expert_id)->update(["rating" => $new_rating]);
        return  $this->returnSuccessMessage('sucesse');
    }
    public function getmaxrating()
    {
        // return  User::Where('rating', '>', 3) ->orderBy('rating',"DESC")->get();
        $u = User::whereNotNull('rating')->orderBy('rating', "DESC")->get();
        return  $this->returnData('experts', $u, "sucesse");
    }
    //category
    public function getcategory()
    {

        $categorys =  User::whereNotNull('category')->select("category")->distinct()->get();
        $categorys = json_decode($categorys, true);
        if (empty($categorys)) {
            return  $this->returnError('404', 'there are no category');
        }
        return  $this->returnData('categorys', $categorys, "sucesse");
    }
    public function getexpertsforcategory(Request $request)
    {
        if ($request->category == null) {
            return  $this->returnError('false', 'send category');
        }
        $x = User::where('category', $request->category)->get();
        $x = json_decode($x, true);
        if (empty($x)) {
            return  $this->returnError('404', ' experts not found for this category ');
        }
        $experts = User::with("Experience"/*, "Registeraton"*/, "Availabletime", "Consulation")
            ->where('category', $request->category)->get();
        return  $this->returnData('experts', $experts, "sucesse");
    }
}
