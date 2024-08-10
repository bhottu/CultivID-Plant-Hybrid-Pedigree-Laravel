<?php
// routes/api.php

use App\Http\Controllers\API\ListProductController;



Route::get('/api/list/products', [ListProductController::class, 'index']);

