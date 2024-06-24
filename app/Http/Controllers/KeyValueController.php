<?php

namespace App\Http\Controllers;

use App\Models\KeyValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KeyValueController extends Controller
{
    // Store key-value pair
    public function store(Request $request) {

        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'key' => 'required|string',
            'value' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()
            ], 400);
        }

        $key = $request->input('key');
        $value = $request->input('value');

        // Create a new KeyValue instance and save it to the database
        $record = new KeyValue();
        $record->key = $key;
        $record->value = json_encode($value);
        $record->save();

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Key and Value successfully created.'
        ], 201);
    }
}
