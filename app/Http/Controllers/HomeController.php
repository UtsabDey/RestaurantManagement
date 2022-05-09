<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Food;
use App\Models\Foodchef;
use App\Models\Cart;
use App\Models\Order;

class HomeController extends Controller
{
    public function index()
    {
        if(Auth::id()){
            return redirect('redirects');
        }
        else{
            $data['lists'] = Food::all();
            $data['chefs'] = Foodchef::all();
            return view('home',$data);
        }
    }

    public function redirects()
    {
        $data['lists'] = Food::all();
        $data['chefs'] = Foodchef::all();
        $usertype = Auth::user()->usertype;
        if ($usertype == '1') {
            return view('admin.adminhome',$data);
        }
        else {
            $user_id = Auth::id();
            $data['count'] = Cart::where('user_id',$user_id)->count();
            return view('home',$data);
        }
    }

    public function addcart(Request $request,$id)
    {
        if(Auth::id()){
            $user_id = Auth::id();
            $food_id = $id;
            $quantity = $request->quantity;

            $insert = new Cart;
            $insert->user_id = $user_id;
            $insert->food_id = $food_id;
            $insert->quantity = $quantity;
            $insert->save();
            return redirect()->back();
        }
        else{
            return redirect('/login');
        }
    }

    public function showcart(Request $request,$id)
    {
        if(Auth::id()==$id){
            $data['count'] = Cart::where('user_id',$id)->count();
            $data['lists'] = Cart::where('user_id',$id)->join('food', 'carts.food_id', '=', 'food.id')->get();
            return view('showcart',$data);
        }
        else{
            return redirect()->back();
        }
    }

    public function orderconfirm(Request $request)
    {
        foreach($request->foodname as $key => $foodname){
            $data = new Order;
            $data->foodname = $foodname;
            $data->price = $request->price[$key];
            $data->quantity = $request->quantity[$key];
            $data->name = $request->name;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $data->save();
        }

        return redirect()->back();
    }

    public function deletecart($id)
    {
        Cart::where('food_id',$id)->delete();
        return redirect()->back();
    }
}
