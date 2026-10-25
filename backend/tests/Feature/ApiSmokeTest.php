<?php
namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{Athlete,TrainingType,User};
class ApiSmokeTest extends TestCase { use RefreshDatabase; public function test_seeded_roles_and_lookups_are_available(): void { $this->seed();$athlete=User::where('email','athlete@example.com')->firstOrFail();$this->actingAs($athlete)->getJson('/api/admin/dashboard')->assertForbidden();$this->actingAs($athlete)->getJson('/api/training-types')->assertOk();$this->assertGreaterThanOrEqual(10,Athlete::count());$this->assertSame(4,TrainingType::count()); } public function test_login_issues_a_token(): void { $this->seed();$this->postJson('/api/login',['email'=>'admin@example.com','password'=>'password'])->assertOk()->assertJsonStructure(['user','token']); } }
