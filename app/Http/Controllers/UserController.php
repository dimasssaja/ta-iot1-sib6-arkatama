<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // read
    function index(){
        $data['title'] = 'Pengguna';
        $data['breadcrumbs'][]=[
            'title' => 'Dashboard',
            'url'   => route('dashboard')
        ];
        $data['breadcrumbs'][]=[
            'title' => 'Pengguna',
            'url'   => 'users.index'
        ];

        $users = User::orderBy('name')->get();
        $data['users'] = $users;

        return view('pages.user.index', $data);
    }

    // read by id
    public function show($id)
    {
        $data = User::find($id);
        if ($data) {
            return response()->json($data);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }


    // delete by id
    public function destroy($id)
    {
        $data = User::find($id);
        if ($data) {
            $data->delete();
            return response()->json(['message' => 'Data berhasil dihapus']);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }
}
