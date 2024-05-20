<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Exception;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $book = Booking::all();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil Ambil data',
                "data" => $book
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
            $book = Booking::create($request->all());
            return response()->json([
                "status" => true,
                "message" => 'Berhasil Insert data',
                "data" => $book
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
            $book = Booking::find($id);
            if (!$book) throw new \Exception("Booking tidak ditemukan");
            return response()->json([
                "status" => true,
                "message" => 'Berhasil Ambil data',
                "data" => $book
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
            $book = Booking::find($id);
            if (!$book) throw new \Exception("Booking tidak ditemukan");
            $book->update($request->all());
            return response()->json([
                "status" => true,
                "message" => 'Berhasil Update data',
                "data" => $book
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
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $book = Booking::find($id);
            if (!$book) throw new \Exception("Booking tidak ditemukan");
            $book->delete();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil Delete data',
                "data" => $book
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
            $book = Booking::where("nama", "like", "%" . $nama . "%")->get();
            if ($book->isEmpty()) {
                throw new \Exception("Booking tidak ditemukan");
            }
            return response()->json([
                "status" => true,
                "message" => 'Berhasil Search data',
                "data" => $book
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
