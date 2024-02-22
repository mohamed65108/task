<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

class AuthControllerTest extends TestCase
{

    public function testLoginSuccessWithValidFOOLogin()
    {
        $response = $this->postJson('/api/login', ['login' => 'FOO_123', 'password' => 'foo-bar-baz']);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ]);
    }

    public function testLoginSuccessWithValidBARLogin()
    {
        $response = $this->postJson('/api/login', ['login' => 'BAR_123', 'password' => 'foo-bar-baz']);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ]);
    }

    public function testLoginSuccessWithValidBAZLogin()
    {
        $response = $this->postJson('/api/login', ['login' => 'BAZ_123', 'password' => 'foo-bar-baz']);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ]);
    }

    public function testLoginFailWithInvalidLogin()
    {
        $response = $this->postJson('/api/login', ['login' => 'FOo_123', 'password' => 'foo-bar-baz']);

        $response->assertStatus(401)
            ->assertJson([
                'status' => 'failure'
            ]);
    }

    public function testLoginFailWithInvalidPassword()
    {
        $response = $this->postJson('/api/login', ['login' => 'FOO_123', 'password' => 'foo-bar']);

        $response->assertStatus(401)
            ->assertJson([
                'status' => 'failure'
            ]);
    }
}
