<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    public function index() : JsonResponse
    {
        $vehicles = Vehicle::all();
        return response()->json(VehicleResource::collection($vehicles));
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'mark' => 'required|string',
            'model' => 'required|string',
            'production_year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'plate_no' => 'required|string|unique:vehicles,plate_no',
            'color' => 'required|string',
            'mileage' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $vehicle = Vehicle::create($request->all());
        return response()->json(new VehicleResource($vehicle), 201);
    }

    // Update method to edit an existing vehicle
    public function update(Request $request, Vehicle $vehicle): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'mark' => 'required|string',
            'model' => 'required|string',
            'production_year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'plate_no' => 'required|string|unique:vehicles,plate_no,' . $vehicle->id,
            'color' => 'required|string',
            'mileage' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $vehicle->update($request->all());
        return response()->json(new VehicleResource($vehicle));
    }

    // Destroy method to delete a vehicle
    public function destroy(Vehicle $vehicle): JsonResponse
    {
        $vehicle->delete();
        return response()->json(['message' => 'Vehicle deleted successfully']);
    }

    // Show method to fetch details of a single vehicle
    public function show(Vehicle $vehicle): JsonResponse
    {
        return response()->json(new VehicleResource($vehicle));
    }
}
