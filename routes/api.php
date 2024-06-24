<?php

use App\Http\Controllers\KeyValueController;

Route::post('/object', [KeyValueController::class, 'store']);
Route::get('/object/{key}', [KeyValueController::class, 'getData']);