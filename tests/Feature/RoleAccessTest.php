<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Enums\UserRole;

class RoleAccessTest extends TestCase
{
    // This trait resets the database after every test so data doesn't leak
    use RefreshDatabase;

    public function test_a_landlord_can_access_the_properties_page(): void
    {
        // 1. Create a dummy landlord
        $landlord = User::factory()->create([
            'role' => UserRole::Landlord,
        ]);

        // 2. Act as the landlord and try to visit the properties index
        $response = $this->actingAs($landlord)->get('/properties');

        // 3. Assert they are allowed (200 OK status)
        $response->assertStatus(200);
    }

    public function test_a_tenant_cannot_access_the_properties_page(): void
    {
        // 1. Create a dummy tenant
        $tenant = User::factory()->create([
            'role' => UserRole::Tenant,
        ]);

        // 2. Act as the tenant and try to visit the properties index
        $response = $this->actingAs($tenant)->get('/properties');

        // 3. Assert they are blocked by the middleware (403 Forbidden status)
        $response->assertStatus(403);
    }
}
