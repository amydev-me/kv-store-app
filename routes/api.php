<?php

use App\Http\Controllers\KeyValueController;

Route::post('/object', [KeyValueController::class, 'store']);

