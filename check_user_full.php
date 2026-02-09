<?php

use App\Models\User;
use App\Models\Universite;
use Illuminate\Support\Facades\Validator;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DIAGNOSTIC START ===\n";

$email = 'adngolfe1@gmail.com'; // Adjust if needed
$user = User::where('email', $email)->first();

if (!$user) {
    echo "USER NOT FOUND!\n";
    exit;
}

echo "User: {$user->name} (ID: {$user->id})\n";
echo "Role: {$user->role}\n";
echo "Nom Universite (User Model): {$user->nom_universite}\n";
echo "Description (User Model): {$user->description}\n";
echo "Vision (User Model): {$user->vision}\n";

$universite = Universite::where('user_id', $user->id)->first();

if (!$universite) {
    echo "NO UNIVERSITE RECORD FOUND!\n";
} else {
    echo "Universite Record Found (ID: {$universite->id})\n";
    echo "Nom: {$universite->nom}\n";
    echo "Description: {$universite->description}\n";
    echo "Vision: {$universite->vision}\n";
    echo "Site Web: {$universite->site_web}\n";
    
    // Check Fillable
    echo "Universite Fillable: " . implode(', ', $universite->getFillable()) . "\n";
}

echo "\n--- TESTING UPDATE ---\n";

// Emulate request data
$data = [
    'nom_universite' => 'TEST UNIVERSITY UPDATE ' . time(),
    'description' => 'TEST DESCRIPTION ' . time(),
    'vision' => 'TEST VISION ' . time(),
    'site_web' => 'https://test.com',
];

echo "Attempting to update User model...\n";
$user->fill($data);
$user->save();
echo "User updated.\n";

if ($user->role === 'universite' && $universite) {
    echo "Syncing to Universite model...\n";
    
    try {
        $updateData = [
            'nom' => $data['nom_universite'],
            'description' => $data['description'],
            'vision' => $data['vision'],
            'site_web' => $data['site_web'],
        ];
        
        $universite->update($updateData);
        echo "Universite update command execute.\n";
        
        // Refresh and check
        $universite->refresh();
        echo "New Description: {$universite->description}\n";
        echo "New Vision: {$universite->vision}\n";
        
        if ($universite->description === $data['description']) {
            echo "SUCCESS: Validation passed, DB updated.\n";
        } else {
            echo "FAILURE: DB did not update.\n";
        }
        
    } catch (\Exception $e) {
        echo "EXCEPTION DURING UPDATE: " . $e->getMessage() . "\n";
    }
} else {
    echo "SKIPPING SYNC: User role is {$user->role} or Universite record missing.\n";
}

echo "=== DIAGNOSTIC END ===\n";
