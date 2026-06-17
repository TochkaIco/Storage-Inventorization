<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:make-admin {email}', function (string $email) {

    $user = User::where('email', $email)->first();
    if (! $user) {
        $this->error("Det finns ingen användare med användarnamnet '$email'!");

        return;
    }

    if ($user->is_admin) {
        $this->error('Användaren har redan admin rollen!');

        return;
    }

    $user->update(['is_admin' => true]);

    $this->info("Lade till admin rollen på användare $user->name ($email)");
})->purpose('Lägg till en användare som ska få admin rollen');
