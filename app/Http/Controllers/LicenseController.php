<?php

namespace App\Http\Controllers;

use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class LicenseController extends Controller
{
    // Barcha litsenziyalarni olish
    public function index()
    {
        return License::all();
    }

    // Yangi litsenziya yaratish
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'passport' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'chat_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $license = License::create($request->all());
        return response()->json($license, 201);
    }

    // Bitta litsenziyani ko'rish
    public function show($id)
    {
        $license = License::findOrFail($id);
        return response()->json($license);
    }

    // Litsenziyani yangilash
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'last_name' => 'string|max:255',
            'first_name' => 'string|max:255',
            'date_of_birth' => 'date',
            'passport' => 'string|max:255',
            'phone' => 'string|max:15',
            'chat_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $license = License::findOrFail($id);
        $license->update($request->all());
        return response()->json($license);
    }

    // Litsenziyani o'chirish
    public function destroy($id)
    {
        $license = License::findOrFail($id);
        $license->delete();
        return response()->json(null, 204);
    }

}
