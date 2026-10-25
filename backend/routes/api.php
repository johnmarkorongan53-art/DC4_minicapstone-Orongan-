<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController as Api;

Route::post('/register',[Api::class,'register']);
Route::post('/login',[Api::class,'login']);
Route::middleware('auth:sanctum')->group(function(){
 Route::post('/logout',[Api::class,'logout']); Route::get('/user',[Api::class,'user']); Route::get('/training-types',[Api::class,'types']); Route::get('/session-statuses',[Api::class,'statuses']);
 Route::middleware('role:athlete')->group(function(){
  Route::get('/my-profile',[Api::class,'profile']); Route::put('/my-profile',[Api::class,'updateProfile']); Route::get('/my-progress',[Api::class,'progress']); Route::get('/my-sessions',[Api::class,'mySessions']); Route::post('/my-sessions',[Api::class,'storeMy']); Route::get('/my-sessions/{id}',[Api::class,'showMy']); Route::put('/my-sessions/{id}',[Api::class,'updateMy']);
  Route::patch('/my-sessions/{id}/start',fn(\Illuminate\Http\Request $r,$id,\App\Services\SessionWorkflow $w)=>(new Api)->transitionMy($r,$id,'in_progress',$w)); Route::patch('/my-sessions/{id}/complete',fn(\Illuminate\Http\Request $r,$id,\App\Services\SessionWorkflow $w)=>(new Api)->transitionMy($r,$id,'completed',$w)); Route::patch('/my-sessions/{id}/cancel',fn(\Illuminate\Http\Request $r,$id,\App\Services\SessionWorkflow $w)=>(new Api)->transitionMy($r,$id,'cancelled',$w));
 });
 Route::prefix('admin')->middleware('role:admin')->group(function(){
  Route::get('/dashboard',[Api::class,'dashboard']); Route::get('/athletes',[Api::class,'athletes']); Route::post('/athletes',[Api::class,'storeAthlete']); Route::get('/athletes/{id}',[Api::class,'showAthlete']); Route::put('/athletes/{id}',[Api::class,'updateAthlete']); Route::delete('/athletes/{id}',[Api::class,'deleteAthlete']);
  Route::get('/training-sessions',[Api::class,'sessions']); Route::post('/training-sessions',[Api::class,'storeSession']); Route::get('/training-sessions/{id}',[Api::class,'showSession']); Route::put('/training-sessions/{id}',[Api::class,'updateSession']); Route::delete('/training-sessions/{id}',[Api::class,'deleteSession']); Route::patch('/training-sessions/{id}/status',[Api::class,'adminStatus']); Route::patch('/training-sessions/{id}/review',[Api::class,'review']);
  Route::post('/training-types',[Api::class,'storeType']); Route::put('/training-types/{id}',[Api::class,'updateType']); Route::delete('/training-types/{id}',[Api::class,'deleteType']);
 });
});
