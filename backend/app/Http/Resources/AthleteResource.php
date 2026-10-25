<?php
namespace App\Http\Resources;
use Illuminate\Http\Request;use Illuminate\Http\Resources\Json\JsonResource;
class AthleteResource extends JsonResource { public function toArray(Request $request): array { return ['id'=>$this->id,'user_id'=>$this->user_id,'athlete_id_number'=>$this->athlete_id_number,'first_name'=>$this->first_name,'last_name'=>$this->last_name,'birthdate'=>$this->birthdate?->toDateString(),'age'=>$this->age,'sex'=>$this->sex,'sport'=>$this->sport,'team'=>$this->team,'height_cm'=>$this->height_cm,'weight_kg'=>$this->weight_kg,'address'=>$this->address,'contact_number'=>$this->contact_number,'emergency_contact_name'=>$this->emergency_contact_name,'emergency_contact_number'=>$this->emergency_contact_number,'user'=>new UserResource($this->whenLoaded('user'))]; } }
