<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AntrianController extends Controller
{
    public function index(Request $request)
    {
        $kendaraanIds = Kendaraan::where('user_id', Auth::id())->pluck('id');

        $query = Antrian::whereIn('kendaraan_id', $kendaraanIds)->with('kendaraan');

        // Search by: nomor_antrian, nomor_polisi (with/without space), nama_pemilik, jenis_kendaraan
        if ($request->filled('search')) {
            $search = trim($request->search);
            $searchClean = str_replace(' ', '', $search);

            $query->where(function ($q) use ($search, $searchClean) {
                $q->where('nomor_antrian', 'like', '%' . $search . '%')
                  ->orWhereHas('kendaraan', function ($qk) use ($search, $searchClean) {
                      $qk->where('nomor_polisi', 'like', '%' . $search . '%')
                         ->orWhereRaw("REPLACE(nomor_polisi, ' ', '') LIKE ?", ['%' . $searchClean . '%'])
                         ->orWhere('nama_pemilik', 'like', '%' . $search . '%')
                         ->orWhere('jenis_kendaraan', 'like', '%' . $search . '%');
                  });
            });
        }

        // Filter by tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Filter by status (case-insensitive)
        if ($request->filled('status') && $request->status !== 'Semua' && $request->status !== '') {
            $status = $request->status;
            $query->where(function ($q) use ($status) {
                $q->where('status', $status)
                  ->orWhereRaw('LOWER(status) = ?', [strtolower($status)]);
            });
        }

        $antrians = $query->orderBy('tanggal', 'desc')
                          ->orderBy('nomor_antrian', 'desc')
                          ->paginate(10)
                          ->withQueryString();

        // Calculate count for each status badge tab
        $counts = [
            'semua' => Antrian::whereIn('kendaraan_id', $kendaraanIds)->count(),
            'menunggu' => Antrian::whereIn('kendaraan_id', $kendaraanIds)->where('status', 'Menunggu')->count(),
            'diproses' => Antrian::whereIn('kendaraan_id', $kendaraanIds)->where('status', 'Diproses')->count(),
            'selesai' => Antrian::whereIn('kendaraan_id', $kendaraanIds)->where('status', 'Selesai')->count(),
            'dibatalkan' => Antrian::whereIn('kendaraan_id', $kendaraanIds)->where('status', 'Dibatalkan')->count(),
        ];

        return view('antrian.index', compact('antrians', 'counts'));
    }

    public function create()
    {
        $kendaraans = Kendaraan::where('user_id', Auth::id())->get();

        return view('antrian.create', compact('kendaraans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'tanggal' => 'required|date',
            'waktu' => 'required',
        ]);

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        if ($kendaraan->user_id !== Auth::id()) {
            abort(403);
        }

        $lastAntrian = Antrian::where('tanggal', $request->tanggal)
            ->orderByRaw('LENGTH(nomor_antrian) DESC, nomor_antrian DESC')
            ->first();

        if ($lastAntrian && preg_match('/(\d+)$/', $lastAntrian->nomor_antrian, $matches)) {
            $newNumber = (int) $matches[1] + 1;
        } else {
            $newNumber = 1;
        }

        $nomorAntrian = 'A' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        Antrian::create([
            'kendaraan_id' => $request->kendaraan_id,
            'nomor_antrian' => $nomorAntrian,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'status' => 'Menunggu',
        ]);

        return redirect()->route('antrian.index')->with('success', 'Data antrian berhasil ditambahkan. Nomor antrian: ' . $nomorAntrian);
    }

    public function edit($id)
    {
        $kendaraanIds = Kendaraan::where('user_id', Auth::id())->pluck('id');
        $antrian = Antrian::whereIn('kendaraan_id', $kendaraanIds)->findOrFail($id);
        $kendaraans = Kendaraan::where('user_id', Auth::id())->get();

        return view('antrian.edit', compact('antrian', 'kendaraans'));
    }

    public function update(Request $request, $id)
    {
        $kendaraanIds = Kendaraan::where('user_id', Auth::id())->pluck('id');
        $antrian = Antrian::whereIn('kendaraan_id', $kendaraanIds)->findOrFail($id);

        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'status' => 'required|in:Menunggu,Diproses,Selesai,Dibatalkan',
        ]);

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        if ($kendaraan->user_id !== Auth::id()) {
            abort(403);
        }

        $antrian->update([
            'kendaraan_id' => $request->kendaraan_id,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'status' => $request->status,
        ]);

        return redirect()->route('antrian.index')->with('success', 'Data antrian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kendaraanIds = Kendaraan::where('user_id', Auth::id())->pluck('id');
        $antrian = Antrian::whereIn('kendaraan_id', $kendaraanIds)->findOrFail($id);

        $antrian->delete();

        return redirect()->route('antrian.index')->with('success', 'Data antrian berhasil dihapus.');
    }
}
