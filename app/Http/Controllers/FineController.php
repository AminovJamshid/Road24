<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FineController extends Controller
{
    public function index()
    {
        return Fine::all();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $fine = Fine::create($request->all());
        return response()->json($fine, 201);
    }

    public function show($id)
    {
        $fine = Fine::findOrFail($id);
        return response()->json($fine);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'numeric|min:0',
            'reason' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $fine = Fine::findOrFail($id);
        $fine->update($request->all());
        return response()->json($fine);
    }

    public function destroy($id)
    {
        $fine = Fine::findOrFail($id);
        $fine->delete();
        return response()->json(null, 204);
    }
}
