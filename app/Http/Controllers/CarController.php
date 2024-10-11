<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    // Barcha mashinalarni olish
    public function index()
    {
        return Car::all();
    }

    // Yangi mashina yaratish
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'model' => 'required|string|max:255',
            'color' => 'required|string|max:50',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'plate_number' => 'required|integer',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $car = Car::create($request->all());
        return response()->json($car, 201);
    }

    // Bitta mashinani ko'rish
    public function show($id)
    {
        $car = Car::findOrFail($id);
        return response()->json($car);
    }

    // Mashinani yangilash
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'model' => 'string|max:255',
            'color' => 'string|max:50',
            'year' => 'integer|min:1900|max:' . date('Y'),
            'plate_number' => 'integer',
            'user_id' => 'exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $car = Car::findOrFail($id);
        $car->update($request->all());
        return response()->json($car);
    }

    // Mashinani o'chirish
    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->delete();
        return response()->json(null, 204);
    }
}
