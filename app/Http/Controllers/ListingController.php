<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    public function index(){
//        dd(auth()->user());
//       dd(request(['tag']));
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag','search']))->paginate(6),
        ]);
    }

    public function show(Listing $listing){
        return view('listings.show',[
            'listing'=>$listing
        ]);
    }

    //show create form
    public function create(){
        return view('listings.create');
    }

    //Store Listing Data
    public function store(Request $request){
//        dd($request->file('logo'));
//        dd($request->all());
        $formFields=$request->validate([
            'title'=>'required',
            'company'=>['required',Rule::unique('listings','company')],
            'location'=>'required',
            'website'=>'required',
            'email'=>['required','email'],
            'tags'=>'required',
            'description'=>'required'
        ]);

        if($request->hasFile('logo')){
            $formFields['logo']=$request->file('logo')->store('logos','public');
        }

        $formFields['user_id']=auth()->user()->id;

        Listing::create($formFields);
        return redirect('/')->with('message','Listing created successfully !');
    }


    public function edit(Listing $listing){
        return view('listings.edit',['listing'=>$listing]);
    }

    //Update Listing Data
    public function update(Request $request,Listing $listing){
//        dd($request->file('logo'));
//        dd($request->all());

        //make sure login in user is owner
        if($listing->user_id != auth()->id()){
            abort(403,'Unauthorized Action');
        }

        $formFields=$request->validate([
            'title'=>'required',
            'company'=>['required'],
            'location'=>'required',
            'website'=>'required',
            'email'=>['required','email'],
            'tags'=>'required',
            'description'=>'required'
        ]);

        if($request->hasFile('logo')){
            $formFields['logo']=$request->file('logo')->store('logos','public');
        }

        $listing->update($formFields);
        return back()->with('message','Listing updated successfully !');
    }

    public function destroy(Listing $listing){
        //make sure login in user is owner
        if($listing->user_id != auth()->id()){
            abort(403,'Unauthorized Action');
        }
        $listing->delete();
        return redirect('/')->with('message','Listing delete successfully!');
    }

    public function manage(){
        return view('listings.manage',['listings'=>auth()->user()->listings()->get()]);
    }


}
