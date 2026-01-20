<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$posts = \App\Models\Post::limit(5)->get(['id', 'image']);

echo "=== Post Images (first 5) ===\n";
foreach ($posts as $post) {
    $img = $post->image;
    if (!$img) {
        echo "Post #{$post->id}: NULL\n";
        continue;
    }
    $publicPath = __DIR__ . '/public/storage/' . $img;
    $storagePath = __DIR__ . '/storage/app/public/' . $img;
    $exists = file_exists($publicPath) ? 'YES (public/storage)' : (file_exists($storagePath) ? 'YES (storage/app/public)' : 'NO');
    echo "Post #{$post->id}: {$img} -> {$exists}\n";
}
