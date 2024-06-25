<?php

use App\Http\Controllers\KeyValueController;

Route::get('/object/get_all_records', [KeyValueController::class, 'getAllRecords']);
Route::post('/object', [KeyValueController::class, 'store']);
Route::get('/object/{key}', [KeyValueController::class, 'getData']);
