<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeController extends Controller
{
    // Barcha turlarni olish
    public function index()
    {
        return Type::all();
    }

    // Yangi tur yaratish
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'penalty_type' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $type = Type::create($request->all());
        return response()->json($type, 201);
    }

    // Bitta tur ko'rish
    public function show($id)
    {
        $type = Type::findOrFail($id);
        return response()->json($type);
    }

    // Tur yangilash
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'penalty_type' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $type = Type::findOrFail($id);
        $type->update($request->all());
        return response()->json($type);
    }

    // Tur o'chirish
    public function destroy($id)
    {
        $type = Type::findOrFail($id);
        $type->delete();
        return response()->json(null, 204);
    }
}
