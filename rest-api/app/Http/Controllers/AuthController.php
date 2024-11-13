<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    # Membuat fitur Register
    public function register(Request $request)
    {
        # Validasi inputan
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        # Menangkap inputan dan hashing password
        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        # Menginsert data ke tabel user
        $user = User::create($input);

        $data = [
            'message' => 'User is created successfully',
            'user' => $user
        ];

        # Mengirim response JSON
        return response()->json($data, 201);
    }

    # Membuat fitur Login
    public function login(Request $request)
    {
        # Validasi input user
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        # Menangkap input user
        $input = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        # Mengambil data user (DB) berdasarkan email
        $user = User::where('email', $input['email'])->first();

        # Memeriksa apakah user ditemukan dan password sesuai
        if ($user && Hash::check($input['password'], $user->password)) {
            # Membuat token
            $token = $user->createToken('auth_token');

            $data = [
                'message' => 'Login successfully',
                'token' => $token->plainTextToken,
                'user' => $user
            ];

            # Mengembalikan response JSON
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Username or Password is wrong'
            ];

            return response()->json($data, 401);
        }
    }
}
