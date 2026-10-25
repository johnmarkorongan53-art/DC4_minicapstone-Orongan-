<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable { use HasApiTokens, HasFactory, Notifiable; protected $fillable=['name','email','password','role']; protected $hidden=['password','remember_token']; protected function casts(): array { return ['email_verified_at'=>'datetime','password'=>'hashed']; } public function athlete(){return $this->hasOne(Athlete::class);} public function createdSessions(){return $this->hasMany(TrainingSession::class,'created_by');} public function reviewedSessions(){return $this->hasMany(TrainingSession::class,'reviewed_by');} }
