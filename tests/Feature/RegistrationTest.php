<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;

it('renders the registration screen', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

it('registers new users', function () {
    $response = $this->post('/register', [
        'name' => 'Test',
        'username' => 'test_user',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password'
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect('/email/verify');
});

