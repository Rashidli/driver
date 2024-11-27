<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Http\Resources\DriverResource;
use App\Models\Driver;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function login(Request $request) :JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $driver = Driver::query()->where('phone', $request->phone)->first();

        if (!$driver || !Hash::check($request->password, $driver->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $driver->createToken('driver_token')->plainTextToken;

        return response()->json(['token' => $token, 'driver' => new DriverResource($driver)]);
    }

    public function logout(Request $request) : JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function show()
    {

        $driver = auth()->user();
        return response()->json($driver);
    }

}
