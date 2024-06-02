<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notifications;

class NotificationsController extends Controller
{
    public function index()
    {
        $data = Notifications::all();
        return response()->json($data);
    }

    public function show($id)
    {
        $data = Notifications::find($id);
        if ($data) {
            return response()->json($data);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

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

    public function latest()
    {
        $latestNotification = Notifications::latest()->first();
        return response()->json($latestNotification);
    }

    // New function to check sensor data and create notification
    // public function checkSensors()
    // {
    //     $sensors = Sensor::all();
    //     foreach ($sensors as $sensor) {
    //         if ($sensor->gas_level >= 100) { // Threshold for gas level
    //             $message = "Warning! High gas level detected: " . $sensor->gas_level;

    //             $notification = Notification::create([
    //                 'message' => $message,
    //                 'sent' => false
    //             ]);

    //             // Optionally, call a function to send WhatsApp notification here
    //             // $this->sendWhatsAppNotification($message);
    //         }
    //     }

    //     return response()->json(['status' => 'Sensor check completed']);
    // }

    // // Optionally, add a function to send WhatsApp notifications
    // private function sendWhatsAppNotification($message)
    // {
    //     // Here you can use a service like Twilio or any other WhatsApp API
    //     // Example using Twilio:
    //     // $client = new \Twilio\Rest\Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    //     // $client->messages->create(
    //     //     'whatsapp:+1234567890', // to
    //     //     [
    //     //         'from' => 'whatsapp:+1234567890', // from
    //     //         'body' => $message
    //     //     ]
    //     // );
    // }
}
