<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\DriverResource;
use App\Models\Driver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : JsonResponse
    {
        $drivers = Driver::all();
        return response()->json(DriverResource::collection($drivers));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) :JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'surname' => 'required|string',
            'name' => 'required|string',
            'middlename' => 'nullable|string',
            'phone' => 'required|string|unique:drivers,phone',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $driver = Driver::create([
            'surname' => $request->surname,
            'name' => $request->name,
            'middlename' => $request->middlename,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $driver->vehicles()->syncWithoutDetaching($request->vehicle_id);

        return response()->json(new DriverResource($driver), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {
        return response()->json(new DriverResource($driver));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Driver $driver) :JsonResponse
    {
        if(!$driver){
            return response()->json([
                'message' => 'Driver not found'
            ], 404);
        }
        $validator = Validator::make($request->all(), [
            'surname' => 'required|string',
            'name' => 'required|string',
            'middlename' => 'nullable|string',
            'phone' => 'required|string|unique:drivers,phone,' . $driver->id,
            'password' => 'nullable|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $driver->update([
            'surname' => $request->surname,
            'name' => $request->name,
            'middlename' => $request->middlename,
            'phone' => $request->phone,
            'password' => $request->password ? Hash::make($request->password) : $driver->password,
        ]);
        $driver->vehicles()->syncWithoutDetaching($request->vehicle_id);
        return response()->json(new DriverResource($driver));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver) : JsonResponse
    {
        $driver->delete();
        return response()->json(['message' => 'Driver deleted successfully']);
    }

    public function removeVehicle(Request $request, Driver $driver) : JsonResponse
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
        ]);

//        $driver->vehicles()->detach($request->vehicle_id);
        $driver->vehicles()->updateExistingPivot($request->vehicle_id, ['deleted_at' => now()]);

        return response()->json(['message' => 'Vehicle removed successfully']);
    }
}
