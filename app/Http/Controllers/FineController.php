<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class FineController extends Controller
{
    public function index()
    {
        return Fine::all();
    }

    public function store(Request $request)
    {
        // Validatsiya
        $validator = Validator::make($request->all(), [
            'plate_number' => 'required|integer',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'type_id' => 'required|exists:types,id',
            'car_id' => 'required|exists:cars,id',
        ]);

        // Agar validatsiyadan o'tmasa, xatolikni qaytaring
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Fine yaratish
        $fine = Fine::create($request->all());

        // Telegramga xabar yuborish
        $message = "Yangi jarima: \n" .
            "Plate Number: " . $fine->plate_number . "\n" .
            "Amount: $" . $fine->amount . "\n" .
            "Date: " . $fine->date->format('Y-m-d') . "\n" .
            "Car ID: " . $fine->car_id . "\n" .
            "Type ID: " . $fine->type_id;

        $this->sendMessage($message);

        // Fine yaratilganini qaytaring
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

    public function sendMessage($message)
    {

        $chat_id = '6323844344';


        $url = "https://api.telegram.org/bot7712034554:AAGNsJrBQDBe46KhD1BICjHaKm3CrlbruTg/sendMessage";

        Http::post($url, [
            'chat_id' => $chat_id,
            'text' => $message,
        ]);

        return response()->json(['status' => 'Message sent to ' . $chat_id]);
    }
}
