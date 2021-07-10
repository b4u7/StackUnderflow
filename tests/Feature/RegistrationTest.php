<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;

it('renders the registration  screen')->get('/register')->assertStatus(200);

it('registers new users', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password'
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
});
