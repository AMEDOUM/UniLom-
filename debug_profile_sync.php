<?php

use App\Models\User;
use App\Models\Universite;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Starting debug script...\n";

// Find the university user (assuming the user logged in is likely the first 'universite' user created)
// Or better, find a user with role 'universite'
$user = User::where('role', 'universite')->latest()->first();

if (!$user) {
    echo "No university user found.\n";
    exit(1);
}

echo "Found User: {$user->email} (ID: {$user->id})\n";
echo "User Role: {$user->role}\n";

// Check relationship
echo "Checking \$user->universite relationship...\n";
$universite = $user->universite;

if (!$universite) {
    echo "ERROR: \$user->universite returned null.\n";
    
    // Check direct query
    $directUniv = Universite::where('user_id', $user->id)->first();
    if ($directUniv) {
        echo "BUT a record exists via direct query: ID {$directUniv->id}\n";
        echo "This suggests a relationship issue or hydration issue.\n";
    } else {
        echo "No Universite record found for user_id {$user->id}.\n";
    }
} else {
    echo "Relationship SUCCESS. Found Universite ID: {$universite->id}\n";
    echo "Current Description: " . substr($universite->description, 0, 50) . "...\n";
    echo "Current Vision: " . ($universite->vision ?? 'NULL') . "\n";
    echo "Current Site Web: " . ($universite->site_web ?? 'NULL') . "\n";
    
    // Attempt update
    echo "Attempting update via relationship...\n";
    $timestamp = time();
    $newDesc = "Updated Description at {$timestamp}";
    $newVision = "Updated Vision at {$timestamp}";
    
    $updated = $universite->update([
        'description' => $newDesc,
        'vision' => $newVision
    ]);
    
    if ($updated) {
        echo "Update returned TRUE.\n";
        
        // Verify persistence
        $fresh = Universite::find($universite->id);
        echo "Fresh fetch Description: " . $fresh->description . "\n";
        echo "Fresh fetch Vision: " . ($fresh->vision ?? 'NULL') . "\n";
        
        if ($fresh->description === $newDesc && $fresh->vision === $newVision) {
            echo "VERIFICATION PASSED: Database was updated correctly.\n";
        } else {
            echo "VERIFICATION FAILED: Database does not match update values.\n";
            echo "Possible fillable issue?\n";
        }
    } else {
        echo "Update returned FALSE.\n";
        echo "Error: " . json_encode($universite->getErrors() ?? 'Unknown error') . "\n";
    }
}
