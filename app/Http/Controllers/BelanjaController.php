<?php

namespace App\Http\Controllers;

use App\Models\Belanja;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BelanjaController extends Controller
{

    private function base64tojpeg($base64_string, $output_file)
    {
        $file = base64_decode($base64_string);
        $img_file = public_path('/image/belanja') . "/$output_file";
        file_put_contents($img_file, $file);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $belanja = Belanja::all();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil mengambil data belanja',
                "data" => $belanja
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $belanja = $request->all();
            $validate = Validator::make($belanja, [
                'nama' => 'required',
                'deskripsi' => 'required',
                'alamat' => 'required',
                'foto' => 'required',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            $imageName = time() . '.jpg';
            $this->base64tojpeg($request->foto, $imageName);
            $belanja['foto'] = '/image/belanja/' . $imageName;
            $buy = Belanja::create($belanja);

            return response()->json([
                "status" => true,
                "message" => 'Berhasil insert data belanja',
                "data" => $buy
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $belanja = Belanja::find($id);

            if (!$belanja) throw new \Exception("Data belanja tidak ditemukan");

            return response()->json([
                "status" => true,
                "message" => 'Berhasil mengambil data belanja',
                "data" => $belanja
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $belanja = Belanja::find($id);

            if (!$belanja) throw new \Exception("Data belanja tidak ditemukan");
            $updateBelanja = $request->all();
            $validate = Validator::make($updateBelanja, [
                'nama' => 'required',
                'deskripsi' => 'required',
                'alamat' => 'required',
                'foto' => 'required',
            ]);
            if ($validate->fails()) {
                return response()->json(['message' => $validate->errors()], 400);
            }
            if ($request->foto && strpos($request->foto, '/image/belanja') !== 0) {
                $imageName = time() . '.jpg';
                $this->base64tojpeg($request->foto, $imageName);
                $updateData['foto'] = '/image/belanja/' . $imageName;
                if (file_exists(public_path($belanja->foto))) {
                    unlink(public_path($belanja->foto));
                }
            }
            $belanja->update($updateBelanja);
            return response()->json([
                "status" => true,
                "message" => 'Berhasil update data belanja',
                "data" => $belanja
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }

    public function search($nama)
    {
        try {
            $belanja = Belanja::where("nama", "like", "%" . $nama . "%")->get();
            if ($belanja->isEmpty()) {
                throw new \Exception("Booking tidak ditemukan");
            }
            return response()->json([
                "status" => true,
                "message" => 'Berhasil Search data',
                "data" => $belanja
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }
}
