<?php

namespace App\Http\Controllers;

use App\Http\Resources\KeyValueResource;
use App\Models\KeyValue;
use Illuminate\Database\QueryException;
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
       
        KeyValue::create([
            'key' => $key,
            'value' => json_encode($value)
        ]);

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Key and Value successfully created.'
        ], 201); 
    }

    public function getData($key, Request $request)
    {
    
        if ($request->has('timestamp')) {
            $timestamp = $request->query('timestamp');

            // Query the database for the value at the specified timestamp
            $value = KeyValue::where('key', $key)
                                ->where('created_at', '<=', date('Y-m-d H:i:s', $timestamp))
                                ->orderBy('created_at', 'desc')
                                ->orderBy('id', 'desc')  
                                ->first();

            if ($value) {
                return response()->json([
                    'success' => true,
                    'data' => json_decode($value->value)
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No value found for the given timestamp.'
                ], 404);
            }
        } else {
            // If no timestamp parameter is provided, return the latest value for the key
            $record = KeyValue::where('key', $key)->latest('id')->first();

            if ($record) {
                return response()->json([
                    'success' => true,
                    'data' => json_decode($record->value)
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No value found for the given key.'
                ], 404);
            }
        }    
    }

     /**
     * Get all records and their values stored in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getAllRecords(Request $request) 
    {  
        $records = KeyValue::orderBy('created_at', 'desc')->paginate();

        return KeyValueResource::collection($records)->additional([
            'success' => true,
            'message' => 'Records retrieved successfully.'
        ]);
    }
}
