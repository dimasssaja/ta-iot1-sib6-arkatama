<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\leds;

class LEDController extends Controller
{
    // read
    public function index()
    {
        $data['title'] = 'Pengguna';
        $data['breadcrumbs'][]=[
            'title' => 'Dashboard',
            'url'   => route('led')
        ];
        $data['breadcrumbs'][]=[
            'title' => 'LED Controller',
            'url'   => 'leds.led'
        ];

        $users = leds::orderBy('id')->get();
        $data['leds'] = $users;

        return view('pages.led', $data);
    }


    // read by id
    public function show($id)
    {
        $data = leds::find($id);
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
            'status' => 'required|boolean',
            'nama_led' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);


        $led = leds::create($data);

        return response()->json($led, 201);
    }

    // data led terbaru
    public function latestleds()
    {
        $latestledss = leds::latest()->first();
        return response()->json($latestledss);
    }

    // update
    public function update(Request $request, $id)
    {

        $data = $request->validate([
            'status' => 'required|boolean',
        ]);


        $led = leds::findOrFail($id);
        $led->update($data);

        return response()->json($led);
    }

    // delete
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
