<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\devices;


class DeviceController extends Controller
{
    public function index()
    {
        $data = devices::all();
        return response()->json($data);
    }

    public function show($id)
    {
        $data = devices::find($id);
        if ($data) {
            return response()->json($data);
        } else {
            return response()->json(['message' => 'Data not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_device' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $device = devices::create($validatedData);

        return response()->json($device, 201);
    }

    public function update(Request $request, $id)
    {
        $device = devices::find($id);
        if ($device) {
            $validatedData = $request->validate([
                'nama_device' => 'sometimes|required|string|max:255',
                'location' => 'nullable|string|max:255',
                'user_id' => 'sometimes|required|exists:users,id',
            ]);

            $device->update($validatedData);

            return response()->json($device);
        } else {
            return response()->json(['message' => 'Device not found'], 404);
        }
    }

    public function destroy($id)
    {
        $device = devices::find($id);
        if ($device) {
            $device->delete();
            return response()->json(['message' => 'Device deleted successfully']);
        } else {
            return response()->json(['message' => 'Device not found'], 404);
        }
    }
    // public function index()
    // {
    //     // Mengambil semua data sensor
    //     $devices = devices::all();
    //     return response()->json($devices);
    // }
}
