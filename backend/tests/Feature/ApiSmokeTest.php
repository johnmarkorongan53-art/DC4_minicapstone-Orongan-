<?php
namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\Models\{Athlete,TrainingType,TrainingSession,User};
class ApiSmokeTest extends TestCase {
 use RefreshDatabase;
 public function test_seeded_roles_and_lookups_are_available(): void { $this->seed();$athlete=User::where('email','athlete@example.com')->firstOrFail();$this->actingAs($athlete)->getJson('/api/admin/dashboard')->assertForbidden();$this->actingAs($athlete)->getJson('/api/training-types')->assertOk();$this->assertGreaterThanOrEqual(10,Athlete::count());$this->assertSame(4,TrainingType::count()); }
 public function test_login_issues_a_token(): void { $this->seed();$this->postJson('/api/login',['email'=>'admin@example.com','password'=>'password'])->assertOk()->assertJsonStructure(['user','token']); }
 public function test_athlete_can_schedule_start_complete_and_get_a_coach_review(): void {
  $this->seed();
  $athleteToken=$this->postJson('/api/login',['email'=>'athlete@example.com','password'=>'password'])->assertOk()->json('token');
  $athlete=$this->withToken($athleteToken);
  $payload=['training_type_id'=>TrainingType::firstOrFail()->id,'title'=>'Progressive tempo run','session_date'=>now()->addDays(10)->toDateString(),'start_time'=>'09:00','end_time'=>'10:00','intensity'=>'medium'];
  $sessionId=$athlete->postJson('/api/my-sessions',$payload)->assertCreated()->json('id');
  $athlete->postJson('/api/my-sessions',[...$payload,'title'=>'Overlapping session','start_time'=>'09:30','end_time'=>'10:30'])->assertUnprocessable();
  $athlete->patchJson("/api/my-sessions/$sessionId/start")->assertOk()->assertJsonPath('status','in_progress');
  $athlete->patchJson("/api/my-sessions/$sessionId/complete")->assertUnprocessable();
  $athlete->patchJson("/api/my-sessions/$sessionId/complete",['duration_minutes'=>46,'perceived_exertion'=>7,'distance_km'=>5.25,'athlete_notes'=>'Even pace throughout'])->assertOk()->assertJsonPath('status','completed');
  $adminToken=$this->postJson('/api/login',['email'=>'admin@example.com','password'=>'password'])->assertOk()->json('token');
  Auth::forgetGuards();
  $this->withToken($adminToken)->patchJson("/api/admin/training-sessions/$sessionId/review",['coach_feedback'=>'Good pacing. Keep building gradually.'])->assertOk()->assertJsonPath('reviewer.id',User::where('email','admin@example.com')->value('id'));
  $this->assertDatabaseHas('training_sessions',['id'=>$sessionId,'status'=>'completed','duration_minutes'=>46,'reviewed_by'=>User::where('email','admin@example.com')->value('id')]);
 }
}
