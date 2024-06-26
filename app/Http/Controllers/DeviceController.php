<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\devices;


class DeviceController extends Controller
{
    // read
    public function index()
    {
        $data = devices::all();
        return response()->json($data);
    }

    // read by id
    public function show($id)
    {
        $data = devices::find($id);
        if ($data) {
            return response()->json($data);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    // create
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

    // update
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
            return response()->json(['message' => 'Device tidak ditemukan'], 404);
        }
    }

    // delete
    public function destroy($id)
    {
        $device = devices::find($id);
        if ($device) {
            $device->delete();
            return response()->json(['message' => 'data device berhasil dihapus']);
        } else {
            return response()->json(['message' => 'data device tidak ditemukan'], 404);
        }
    }
}
