<?php

namespace Tests\Feature;

it('renders the registration screen', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

it('registers new users', function () {
    $response = $this->post('/register', [
        'name' => 'Test',
        'username' => 'test_user',
        'email' => 'test@example.com',
        'password' => 'P@ssw0rd',
        'password_confirmation' => 'P@ssw0rd'
    ]);

    $response->assertRedirect('/email/verify');
    $this->assertAuthenticated();
});

