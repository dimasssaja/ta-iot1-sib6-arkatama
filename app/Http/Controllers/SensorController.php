<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sensor;

class SensorController extends Controller
{
    public function index()
    {
        // Mengambil semua data sensor
        $data = Sensor::all();
        return response()->json($data);
    }

    public function show($id)
    {
        // Mengambil data sensor berdasarkan ID
        $data = Sensor::find($id);
        if ($data) {
            return response()->json($data);
        } else {
            return response()->json(['message' => 'Data not found'], 404);
        }
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'temperature' => 'required|numeric',
            'humidity' => 'required|numeric',
            'gas_level' => 'required|numeric',
            'rain_detected' => 'required|boolean',
            'device_id' => 'required|integer',
        ]);

        // Buat data sensor baru
        $sensorData = Sensor::create($validatedData);

        // Kembalikan respons sukses
        return response()->json($sensorData, 201);
    }

    // public function getData(){
    //     $data=Sensor::all();
    //     return response()->json([
    //         "message" => "data temperature berhasil diambil",
    //         "data"    => $data
    //     ],200);
    // }

    // function deleteData(Request $request){
    //     $value=$request->temperature;
    //     $temperature = Sensor::findOrFail($request->id);
    //     $temperature->delete();

    //     return response()->json([
    //         "message" => "Data temperature berhasil dihapus",
    //         "data"    => $temperature
    //     ], 200);
    // }

}
