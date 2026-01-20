<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$submissions = \App\Models\PlantSubmission::whereIn('plant_id', ['Test 4', 'Test 3'])->get(['id', 'plant_id', 'image']);

echo "=== PlantSubmission Images ===\n";
foreach ($submissions as $sub) {
    echo "ID: {$sub->id}, Plant ID: {$sub->plant_id}\n";
    echo "  Raw image: " . ($sub->image ? $sub->image : 'NULL') . "\n";
    if ($sub->image) {
        $decoded = json_decode($sub->image, true);
        if (is_array($decoded)) {
            echo "  Is JSON array: YES\n";
            echo "  Decoded: " . print_r($decoded, true);
        } else {
            echo "  Is JSON array: NO (legacy string path)\n";
        }
    }
    echo "\n";
}
