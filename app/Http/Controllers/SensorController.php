<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sensor;

class SensorController extends Controller
{

    public function sendWhatsAppNotification($message)
    {
        $token = 'W19Dffr#U_5Q356vEBZg';
        $phone = '089531637729';
        $url = 'https://api.fonnte.com/send';

        $data = [
            'target' => $phone,
            'message' => $message,
        ];

        $headers = [
            'Authorization: ' . $token
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Tambahkan ini jika mengalami masalah SSL

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            return "cURL Error: $error_msg";
        }

        curl_close($ch);
        return $result;
    }
    public function index()
    {
        // Mengambil semua data sensor
        $data = Sensor::orderBy('created_at','desc')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'List Data Temperature',
            'data' => $data
        // $data = Sensor::all();
        // return response()->json($data);
        ]);
        return view('sensors.sensor', compact('sensors'));
    }

    public function show($id)
    {
        // Mengambil data sensor berdasarkan ID
        $data = Sensor::find($id);
        if ($data) {
            return response()->json($data);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
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
            'device_id' => 'required|exists:devices,id',
        ]);

        // Buat data sensor baru
        $sensorData = Sensor::create($validatedData);

        if ($validatedData['gas_level'] > 300) {
            $message = "Gas Leak Detected!!!\nValue : {$validatedData['gas_level']} ppm\nDatetime : {$sensorData->created_at}";
            $this->sendWhatsAppNotification($message);
        }

        // Kembalikan respons sukses
        return response()->json($sensorData, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'temperature' => 'required|numeric',
            'humidity' => 'required|numeric',
            'gas_level' => 'required|numeric',
            'rain_detected' => 'required|boolean',
            'device_id' => 'required|exists:devices,id',
        ]);

        $sensorData = Sensor::find($id);
        if ($sensorData) {
            $sensorData->update($validatedData);
            return response()->json($sensorData);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    public function destroy($id)
    {
        $sensorData = Sensor::find($id);
        if ($sensorData) {
            $sensorData->delete();
            return response()->json(['message' => 'Data berhasil dihapus']);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
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
