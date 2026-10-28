<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows all users from the database on the users page', function () {
    $users = User::factory(3)->create();

    $response = $this->get(route('users.index'));

    $response->assertOk();
    $response->assertSee('Gebruikers (3)');

    foreach ($users as $user) {
        $response->assertSee($user->name);
        $response->assertSee($user->email);
    }
});

it('shows an empty state when there are no users', function () {
    $response = $this->get(route('users.index'));

    $response->assertOk();
    $response->assertSee('Geen gebruikers gevonden.');
});
