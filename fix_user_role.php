<?php

use App\Models\User;
use App\Models\Universite;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking user role...\n";

// Assuming the user is adngolfe1@gmail.com based on previous logs/context
$email = 'adngolfe1@gmail.com';
$user = User::where('email', $email)->first();

if (!$user) {
    echo "User NOT FOUND with email: $email\n";
    
    // List all users to see if there's a typo
    $users = User::all();
    echo "Available users:\n";
    foreach ($users as $u) {
        echo "- {$u->email} (Role: {$u->role})\n";
    }
    exit(1);
}

echo "User Found: {$user->email}\n";
echo "Current Role in DB: '{$user->role}'\n";

if ($user->role !== 'universite') {
    echo "MISMATCH DETECTED! User thinks they are university, but DB says '{$user->role}'.\n";
    echo "Fixing role to 'universite'...\n";
    
    $user->role = 'universite';
    $user->save();
    
    echo "Role updated successfully to 'universite'.\n";
} else {
    echo "Role is already 'universite'. This is unexpected given the logs.\n";
}

// Check if they have an associated university record
$univ = Universite::where('user_id', $user->id)->first();
if ($univ) {
    echo "Associated Universite record found (ID: {$univ->id}).\n";
} else {
    echo "WARNING: No associated Universite record found! Creating one...\n";
    Universite::create([
        'user_id' => $user->id,
        'nom' => $user->nom_universite ?? 'Nouvelle Université',
        'email' => $user->email,
        'description' => $user->description ?? 'Description à compléter',
        'adresse' => $user->localisation ?? 'Lomé',
        'ville' => 'Lomé',
        'pays' => 'Togo'
    ]);
    echo "Universite record created.\n";
}
