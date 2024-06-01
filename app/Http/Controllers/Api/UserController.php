<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('name', 'asc')->get();
        return response()->json([
            'message'   => 'Berhasil menampilkan data user',
            'data'      => $users
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // mmebuat validasi
        $validated = $request->validate([
            'name'      => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            'email'     => [
                'required',
                'email',
                'unique:users,email'
            ],
            'password'  => [
                'required',
                'min:8'
            ],
            // 'password_confirmation' => [
            //     'required',
            //     'same:password'
            // ],
            // 'avatar'    => [
            //     'nullable',
            //     'image',
            //     'mimes:jpg,jpeg,png',
            //     'max:2048' // 2MB
            // ]
        ]);

        // unggah avatar
        // if ($request->hasFile('avatar')) {
        //     $avatar = $request->file('avatar');
        //     $avatarPath = $avatar->store('avatars', 'public');

        //     $validated['avatar'] = $avatarPath;
        // }

        // membuat user baru
        $user = User::create($validated);

        return response()->json([
            'message'   => 'Berhasil menambahkan user baru',
            'data'      => $user
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        return response()->json([
            'message'   => 'Berhasil menampilkan detail user',
            'data'      => $user
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name'      => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            'email'     => [
                'required',
                'email',
                'unique:users,email,' . $id
            ],
            'password'  => [
                'nullable',
                'min:8'
            ],
            // 'password_confirmation' => [
            //     'required',
            //     'same:password'
            // ],
            // 'avatar'    => [
            //     'nullable',
            //     'image',
            //     'mimes:jpg,jpeg,png',
            //     'max:2048' // 2MB
            // ]
        ]);

        // unggah avatar
        // if ($request->hasFile('avatar')) {
        //     $avatar = $request->file('avatar');
        //     $avatarPath = $avatar->store('avatars', 'public');

        //     $validated['avatar'] = $avatarPath;
        // }

        // jika ada password baru, maka update password
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        }else{
            unset($validated['password']);
        }

        $user = User::find($id);
        $user->update($validated);

        return response()->json([
            'message'   => 'Berhasil mengupdate data user',
            'data'      => $user
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json([
            'message'   => 'Berhasil menghapus data user',
            'data'      => $user
        ], 200);
    }
}
