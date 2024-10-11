<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FineController extends Controller
{
    // Barcha jarimalarni olish
    public function index()
    {
        return Fine::all();
    }

    // Yangi jarima yaratish
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plate_number' => 'required|integer',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'type_id' => 'required|exists:types,id',
            'car_id' => 'required|exists:cars,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $fine = Fine::create($request->all());
        return response()->json($fine, 201);
    }

    // Bitta jarimani ko'rish
    public function show($id)
    {
        $fine = Fine::findOrFail($id);
        return response()->json($fine);
    }

    // Jarimani yangilash
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'plate_number' => 'integer',
            'amount' => 'numeric|min:0',
            'date' => 'date',
            'type_id' => 'exists:types,id',
            'car_id' => 'exists:cars,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $fine = Fine::findOrFail($id);
        $fine->update($request->all());
        return response()->json($fine);
    }

    // Jarimani o'chirish
    public function destroy($id)
    {
        $fine = Fine::findOrFail($id);
        $fine->delete();
        return response()->json(null, 204);
    }
}
