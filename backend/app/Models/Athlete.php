<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Athlete extends Model { protected $fillable=['user_id','athlete_id_number','first_name','last_name','birthdate','sex','sport','team','height_cm','weight_kg','address','contact_number','emergency_contact_name','emergency_contact_number']; protected function casts(): array { return ['birthdate'=>'date','height_cm'=>'decimal:2','weight_kg'=>'decimal:2']; } public function getAgeAttribute(): int { return $this->birthdate?->age ?? 0; } public function user(){return $this->belongsTo(User::class);} public function trainingSessions(){return $this->hasMany(TrainingSession::class);} }
