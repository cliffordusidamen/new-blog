<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{

    /**
     * Test that the password is properly encrypted
     *
     * @test
     * @return void
     */
    public function user_password_is_properly_encrypted()
    {
        $user = User::factory()->state([
            'name' => 'name',
            'email' => 'user@email.com',
            'password' => 'password1',
        ])->make();

        $this->assertNotSame('password1', $user->password);
    }
}
