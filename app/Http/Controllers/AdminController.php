<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\User;
use App\Models\Food;
use App\Models\Reservation;
use App\Models\Foodchef;
use App\Models\Order;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function user()
    {
        $data['lists'] = User::all();
        return view('admin.user',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function food()
    {
        $data['lists'] = Food::paginate(3);
        return view('admin.foodmenu',$data);
    }

    public function upload(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'price' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg|max:1024',
            'description' => 'required|max:255',

        ]);
        if($validate->fails()){ 
            return back()->withErrors($validate)->withInput();
        }

        $insert = new Food();
        $insert->title = $request->title;
        $insert->price = $request->price;
        $insert->description = $request->description;
        if ($request->hasFile('image')) {
            $photo = $request->image;
            $photo_name = time().rand(111,999).'.'.$photo->getClientOriginalExtension();
            $resize_image = Image::make($photo->getRealPath());
            $resize_image->resize(300, 300, function($constraint){
                $constraint->aspectRatio();
            })->save(public_path('/foodimage/').$photo_name);
            $insert->image = $photo_name;
          
        }
        $insert->save();
        return redirect('/foodmenu')->back();
    }

    public function viewreservation()
    {
        if(Auth::id()){
            $data['lists'] = Reservation::paginate(5);
            return view('admin.adminreservation',$data);
        }
        else{
            return redirect('login');
        }
    }

    public function reservation(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'message' => 'required',

        ]);
        if($validate->fails()){ 
            return back()->withErrors($validate)->withInput();
        }

        $insert = new Reservation();
        $insert->name = $request->name;
        $insert->email = $request->email;
        $insert->phone = $request->phone;
        $insert->guest = $request->guest;
        $insert->date = $request->date;
        $insert->time = $request->time;
        $insert->message = $request->message;
        $insert->save();
        return redirect()->back();
    }

    public function viewchef()
    {
        $data['lists'] = Foodchef::paginate(3);
        return view('admin.adminchef',$data);
    }

    public function uploadchef(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'speciality' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg|max:1024',

        ]);
        if($validate->fails()){ 
            return back()->withErrors($validate)->withInput();
        }

        $insert = new Foodchef();
        $insert->name = $request->name;
        $insert->speciality = $request->speciality;
        if ($request->hasFile('image')) {
            $photo = $request->image;
            $photo_name = time().rand(111,999).'.'.$photo->getClientOriginalExtension();
            $resize_image = Image::make($photo->getRealPath());
            $resize_image->resize(300, 300, function($constraint){
                $constraint->aspectRatio();
            })->save(public_path('/chefimage/').$photo_name);
            $insert->image = $photo_name;
          
        }
        $insert->save();
        return redirect()->back();
    }

    public function updatechef(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'speciality' => 'required',
            'image' => 'nullable|mimes:jpeg,png,jpg|max:1024',

        ]);
        if($validate->fails()){    
            dd($validate);
            return back()->withErrors($validate)->withInput();
        }
        $update = Foodchef::find($request->id);
        $update->name = $request->name;
        $update->speciality = $request->speciality;
        if ($request->hasFile('image')) {
            if(file_exists(public_path('/chefimage/') .$update->image)){
                unlink(public_path('/chefimage/') .$update->image);
            };
            $photo = $request->image;
            $photo_name = time().rand(111,999).'.'.$photo->getClientOriginalExtension();
            $resize_image = Image::make($photo->getRealPath());
            $resize_image->resize(300, 300, function($constraint){
                $constraint->aspectRatio();
            })->save(public_path('/chefimage/').$photo_name);
            $update->image = $photo_name;
        }
        if($update->isDirty()){
            $update->save();
            return redirect('/viewchef')->with('updated');
        }
        else{
            return redirect('/viewchef')->with('warning');
        }
            
    }

    public function update(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'price' => 'required',
            'image' => 'nullable|mimes:jpeg,png,jpg|max:1024',
            'description' => 'required',

        ]);
        if($validate->fails()){    
            return back()->withErrors($validate)->withInput();
        }
        // dd($validate);
        $update = Food::find($request->id);
        $update->title = $request->title;
        $update->price = $request->price;
        $update->description = $request->description;
        if ($request->hasFile('image')) {
            if(file_exists(public_path('/foodimage/') .$update->image)){
                unlink(public_path('/foodimage/') .$update->image);
            };
            $photo = $request->image;
            $photo_name = time().rand(111,999).'.'.$photo->getClientOriginalExtension();
            $resize_image = Image::make($photo->getRealPath());
            $resize_image->resize(300, 300, function($constraint){
                $constraint->aspectRatio();
            })->save(public_path('/foodimage/').$photo_name);
            $update->image = $photo_name;
        }
        if($update->isDirty()){
            $update->save();
            return redirect('/foodmenu')->with('updated');
        }
        else{
            return redirect('/foodmenu')->with('warning');
        }
            
    }

    public function orders()
    {
        $data['lists'] = Order::paginate(4);
        return view('admin.orders',$data);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $data['lists'] = Order::where('name','LIKE','%' .$search. '%')
                        ->orWhere('foodname','LIKE','%' .$search. '%')->get();
        return view('admin.orders',$data);
    }

    public function deletefood($id)
    {
        Food::find($id)->delete();
        return redirect('/foodmenu')->back()->with('success');
    }

    public function deletechef($id)
    {
        Foodchef::find($id)->delete();
        return redirect()->back();
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->back();
    }
}
