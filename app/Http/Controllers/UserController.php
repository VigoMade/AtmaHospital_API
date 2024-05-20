<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    private function base64tojpeg($base64_string, $output_file)
    {
        $file = base64_decode($base64_string);
        $img_file = public_path('/image/user') . "/$output_file";
        file_put_contents($img_file, $file);
    }


    public function index()
    {
        try {
            $users = User::all();
            return response()->json([
                'success' => true,
                'message' => 'List Semua User',
                'data' => $users
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 400);
        }
    }

    public function store(Request $request)
    {
        try {
            $registerData = $request->all();
            Validator::make($registerData, [
                'email' => 'required',
                'password' => 'required',
                'username' => 'required',
                'noTelp' => 'required',
                'tanggal' => 'required',
            ]);
            $registerData['active'] = 1;
            $user = User::create($registerData);
            return response()->json([
                'success' => true,
                'message' => 'User Berhasil Ditambahkan',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 400);
        }
    }


    public function show($email)
    {
        try {
            $user = User::where('email', $email)->first();
            if (!$user) throw new \Exception('User Tidak Ditemukan');
            return response()->json([
                'success' => true,
                'message' => 'Detail User',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 400);
        }
    }

    public function update(Request $request, $email)
    {
        try {
            $user = User::where('email', $email)->first();
            if (!$user) {
                throw new \Exception("User tidak ditemukan");
            }

            $updateData = $request->all();



            if ($request->has('image')) {
                $imageName = time() . '.jpg';
                $this->base64tojpeg($request->image, $imageName);
                $updateData['image'] = '/image/user/' . $imageName;

                if ($user->image !== null && file_exists(public_path($user->image))) {
                    unlink(public_path($user->image));
                }
            }

            $user->update($updateData);

            return response()->json([
                "status" => true,
                "message" => 'Berhasil Update data',
                "data" => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }


    public function login($email, $password)
    {
        try {
            $user = User::where('email', $email)->first();

            if (!$user) {
                throw new \Exception("User not found");
            }


            if ($password == $user->password) {
                return response()->json([
                    "status" => true,
                    "message" => 'Login successful',
                    "data" => $user
                ], 200);
            } else {
                throw new \Exception("Invalid password");
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }
}
