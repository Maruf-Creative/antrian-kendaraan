<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $kendaraanIds = $user->kendaraans()->pluck('id');

        $totalKendaraan = $kendaraanIds->count();
        $totalAntrian = Antrian::whereIn('kendaraan_id', $kendaraanIds)->count();
        $menunggu = Antrian::whereIn('kendaraan_id', $kendaraanIds)->where('status', 'Menunggu')->count();
        $diproses = Antrian::whereIn('kendaraan_id', $kendaraanIds)->where('status', 'Diproses')->count();
        $selesai = Antrian::whereIn('kendaraan_id', $kendaraanIds)->where('status', 'Selesai')->count();

        $antrianTerbaru = Antrian::whereIn('kendaraan_id', $kendaraanIds)
            ->with('kendaraan')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalKendaraan',
            'totalAntrian',
            'menunggu',
            'diproses',
            'selesai',
            'antrianTerbaru'
        ));
    }
}
