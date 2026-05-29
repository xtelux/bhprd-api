<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RekonPajak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RekonPajakController extends Controller
{
    public function index()
    {
        // paginate(10) untuk pagination, bisa disesuaikan
        $rekon = RekonPajak::paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Data rekonsiliasi pajak berhasil diambil',
            'data' => $rekon
        ]);
    }

    // pencairan data berdasarkan tgl_bayar
    // 'tgl_bayar': '2026-03-03 11:05:00'
    public function filterByDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tgl_bayar' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $rekon = RekonPajak::whereDate('tgl_bayar', $request->tgl_bayar)->get();

        return response()->json([
            'success' => true,
            'message' => 'Data rekonsiliasi pajak berhasil diambil berdasarkan tanggal bayar',
            'data' => $rekon
        ]);
    }

    // pencairan data berdasarkan kd_jns_pajak
    // 'kd_jns_pajak': 1
    public function filterByJenisPajak(Request $request){
        $validator = Validator::make($request->all(), [
            'kd_jns_pajak' => 'required|exists:jns_pajaks,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $rekon = RekonPajak::where('kd_jns_pajak', $request->kd_jns_pajak)->get();

        return response()->json([
            'success' => true,
            'message' => 'Data rekonsiliasi pajak berhasil diambil berdasarkan jenis pajak',
            'data' => $rekon
        ]);
    }


    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'sspd' => 'required|string',
            'no_objek_pajak' => 'required|string',
            'subjek_pajak' => 'required|string|max:255',
            'tgl_bayar' => 'required|date',
            'jumlah_bayar' => 'required|numeric|min:0',
            'kd_jns_pajak' => 'required|exists:jns_pajaks,id',
            'kd_kelurahan' => 'required|numeric|exists:subjeks,kd_kelurahan',
        ]);

       if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $rekon = RekonPajak::create([
            'sspd' => $request->sspd,
            'no_objek_pajak' => $request->no_objek_pajak,
            'subjek_pajak' => strtoupper($request->subjek_pajak),
            'tgl_bayar' => $request->tgl_bayar,
            'jumlah_bayar' => $request->jumlah_bayar,
            'kd_jns_pajak' => $request->kd_jns_pajak,
            'kd_kelurahan' => $request->kd_kelurahan,
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data rekonsiliasi pajak berhasil disimpan',
            'data' => $rekon
        ], 201);
    }

}
