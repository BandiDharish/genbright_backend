<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileUpdateTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@genbright.com',
            'password' => Hash::make('Admin@123'),
        ]);
    }

    public function test_admin_must_be_authenticated_to_update_profile()
    {
        $response = $this->putJson(route('admin.profile.update'), [
            'email' => 'new@genbright.com',
            'current_password' => 'Admin@123',
        ]);

        $response->assertStatus(401);
    }

    public function test_admin_can_update_email_with_correct_current_password()
    {
        $response = $this->actingAs($this->admin)
            ->putJson(route('admin.profile.update'), [
                'email' => 'admin_updated@genbright.com',
                'current_password' => 'Admin@123',
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'user' => [
                'email' => 'admin_updated@genbright.com',
            ]
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $this->admin->id,
            'email' => 'admin_updated@genbright.com',
        ]);
    }

    public function test_admin_cannot_update_email_with_incorrect_current_password()
    {
        $response = $this->actingAs($this->admin)
            ->putJson(route('admin.profile.update'), [
                'email' => 'admin_updated@genbright.com',
                'current_password' => 'wrong_password',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['current_password']);
        
        $this->assertDatabaseHas('users', [
            'id' => $this->admin->id,
            'email' => 'admin@genbright.com',
        ]);
    }

    public function test_email_must_be_unique_except_for_current_user()
    {
        // Create another user
        User::factory()->create([
            'email' => 'other@genbright.com',
        ]);

        // Attempt to change admin's email to other's email
        $response = $this->actingAs($this->admin)
            ->putJson(route('admin.profile.update'), [
                'email' => 'other@genbright.com',
                'current_password' => 'Admin@123',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_admin_can_change_password_with_correct_current_password()
    {
        $response = $this->actingAs($this->admin)
            ->putJson(route('admin.profile.update'), [
                'email' => 'admin@genbright.com',
                'current_password' => 'Admin@123',
                'new_password' => 'NewSecurePassword@123',
                'new_password_confirmation' => 'NewSecurePassword@123',
            ]);

        $response->assertStatus(200);
        
        $this->admin->refresh();
        $this->assertTrue(Hash::check('NewSecurePassword@123', $this->admin->password));
    }

    public function test_password_change_requires_matching_confirmation()
    {
        $response = $this->actingAs($this->admin)
            ->putJson(route('admin.profile.update'), [
                'email' => 'admin@genbright.com',
                'current_password' => 'Admin@123',
                'new_password' => 'NewSecurePassword@123',
                'new_password_confirmation' => 'mismatching_password',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['new_password']);
    }
}
