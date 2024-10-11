<?php

namespace App\Http\Controllers;

use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LicenseController extends Controller
{
    public function index()
    {
        return License::all();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required|string|max:255',
            'category' => 'required|string|max:10',
            'issued_date' => 'required|date',
            'expiry_date' => 'required|date|after:issued_date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $license = License::create($request->all());
        return response()->json($license, 201);
    }

    public function show($id)
    {
        $license = License::findOrFail($id);
        return response()->json($license);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'string|max:255',
            'category' => 'string|max:10',
            'issued_date' => 'date',
            'expiry_date' => 'date|after:issued_date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $license = License::findOrFail($id);
        $license->update($request->all());
        return response()->json($license);
    }

    public function destroy($id)
    {
        $license = License::findOrFail($id);
        $license->delete();
        return response()->json(null, 204);
    }
}
