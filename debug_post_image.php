<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$post = \App\Models\Post::where('image', '!=', null)->first();
if (!$post) {
    echo "No post with image found\n";
    exit(0);
}

echo "=== Post Image Details ===\n";
echo "Post ID: {$post->id}\n";
echo "DB image value: {$post->image}\n";
echo "Generated asset() URL: " . asset('storage/' . $post->image) . "\n";
echo "APP_URL: " . config('app.url') . "\n";
echo "File exists in public/storage: " . (file_exists('public/storage/' . $post->image) ? 'YES' : 'NO') . "\n";
