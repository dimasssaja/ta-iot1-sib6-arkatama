<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notifications;

class NotificationsController extends Controller
{
    // read
    public function index()
    {
        $data = Notifications::all();
        return response()->json($data);
    }

    // read by id
    public function show($id)
    {
        $data = Notifications::find($id);
        if ($data) {
            return response()->json($data);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    // create
    public function store(Request $request)
    {
        $data = $request->validate([
            'message' => 'required|string',
            'sent' => 'boolean',
            'user_id' => 'required|exists:users,id',
        ]);

        $notification = Notifications::create($data);

        return response()->json($notification, 201);
    }

    // update
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'message' => 'required|string',
            'sent' => 'boolean',
        ]);

        $notification = Notifications::findOrFail($id);
        $notification->update($data);

        return response()->json($notification);
    }

    // delete
    public function destroy($id)
    {
        $notification = Notifications::find($id);
        if ($notification) {
            $notification->delete();
            return response()->json(['message' => 'Data Berhasil Dihapus']);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    // menampilkan notifikasi terbaru
    public function latest()
    {
        $latestNotification = Notifications::latest()->first();
        return response()->json($latestNotification);
    }
}
