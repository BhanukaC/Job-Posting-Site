<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use \App\Models\Listing;
use \App\Http\Controllers\ListingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing

//All listings
Route::get('/', [ListingController::class,'index']);

//show create Form
Route::get('/listings/create',[ListingController::class,'create'])->middleware('auth');

//store listing Data
Route::post('/listings',[ListingController::class,'store'])->middleware('auth');

//show edit form
Route::get('/listings/{listing}/edit',[ListingController::class,'edit'])->middleware('auth');

//update Listing
Route::put('/listings/{listing}',[ListingController::class,'update'])->middleware('auth');

//Delete Listing
Route::delete('/listings/{listing}',[ListingController::class,'destroy'])->middleware('auth');

//manage listings
Route::get('/listings/manage',[ListingController::class,'manage'])->middleware('auth');

//single Listings
Route::get("/listings/{listing}",[ListingController::class,'show']);

//Show Register/Create Form
Route::get('/register',[UserController::class,'create'])->middleware('guest');

//create new user
Route::post('/users',[UserController::class,'store'])->middleware('guest');

//Log user out
Route::post('/logout',[UserController::class,'logout']);

//show Login Form
Route::get('/login',[UserController::class,'login'])->name('login')->middleware('guest');

//Log in user
Route::post('/users/authenticate',[UserController::class,'authenticate'])->middleware('guest');



//Route::get('/hello',function (){
//    return response('<h1>Hello World</h1>')
//        ->header('content-Type','text/plain')
//        ->header('foo','bar')
//        ;
//});
//
//
//Route::get('/posts/{id}',function ($id){
//    return response('Post '.$id);
//})->where('id','[0-9]+');
//
//query string
//Route::get('/search',function (Request $request){
//    return $request->name . " " .$request->city;
//});


