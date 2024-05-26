<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\leds;

class LEDController extends Controller
{
    public function index()
    {
        $data = leds::all();
        return response()->json($data);
    }

    public function show($id)
    {
        $data = leds::find($id);
        if ($data) {
            return response()->json($data);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'status' => 'required|boolean',
            'nama_led' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);


        $led = leds::create($data);

        return response()->json($led, 201);
    }

    public function update(Request $request, $id)
    {

        $data = $request->validate([
            'status' => 'required|boolean',
            'nama_led' => 'required|string|max:255',
        ]);


        $led = leds::findOrFail($id);
        $led->update($data);

        return response()->json($led);
    }

    public function destroy($id)
    {

        $led = leds::find($id);
        if ($led) {
            $led->delete();
            return response()->json(['message' => 'Data Berhasil Dihapus']);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }
}
