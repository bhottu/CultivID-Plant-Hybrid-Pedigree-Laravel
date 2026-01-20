<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$subs = \App\Models\PlantSubmission::whereIn('plant_id', ['Test 4', 'Test 3'])->get(['plant_id', 'induk_betina', 'induk_jantan', 'image']);

echo "=== Test submissions parent info ===\n";
foreach ($subs as $s) {
    echo "Plant ID: {$s->plant_id}\n";
    echo "  induk_betina: '" . ($s->induk_betina ?? 'NULL') . "'\n";
    echo "  induk_jantan: '" . ($s->induk_jantan ?? 'NULL') . "'\n";
    echo "  Has image: " . ($s->image ? 'YES' : 'NO') . "\n";
    echo "\n";
}
