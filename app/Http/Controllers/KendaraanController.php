<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KendaraanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kendaraan::where('user_id', Auth::id());

        $keyword = trim($request->query('nomor_polisi', $request->query('search', '')));
        if (!empty($keyword)) {
            $keywordClean = str_replace(' ', '', $keyword);
            $query->where(function ($q) use ($keyword, $keywordClean) {
                $q->where('nomor_polisi', 'like', '%' . $keyword . '%')
                  ->orWhereRaw("REPLACE(nomor_polisi, ' ', '') LIKE ?", ['%' . $keywordClean . '%'])
                  ->orWhere('nama_pemilik', 'like', '%' . $keyword . '%')
                  ->orWhere('jenis_kendaraan', 'like', '%' . $keyword . '%');
            });
        }

        $kendaraans = $query->latest()->paginate(10)->withQueryString();

        return view('kendaraan.index', compact('kendaraans'));
    }

    public function create()
    {
        return view('kendaraan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_polisi' => 'required|string|max:15|unique:kendaraans,nomor_polisi',
            'jenis_kendaraan' => 'required|string|max:50',
            'nama_pemilik' => 'required|string|max:100',
        ]);

        Kendaraan::create([
            'user_id' => Auth::id(),
            'nomor_polisi' => $request->nomor_polisi,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'nama_pemilik' => $request->nama_pemilik,
        ]);

        return redirect()->route('kendaraan.index')->with('success', 'Data kendaraan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        if ($kendaraan->user_id !== Auth::id()) {
            abort(403);
        }

        return view('kendaraan.edit', compact('kendaraan'));
    }

    public function update(Request $request, $id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        if ($kendaraan->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'nomor_polisi' => 'required|string|max:15|unique:kendaraans,nomor_polisi,' . $kendaraan->id,
            'jenis_kendaraan' => 'required|string|max:50',
            'nama_pemilik' => 'required|string|max:100',
        ]);

        $kendaraan->update([
            'nomor_polisi' => $request->nomor_polisi,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'nama_pemilik' => $request->nama_pemilik,
        ]);

        return redirect()->route('kendaraan.index')->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        if ($kendaraan->user_id !== Auth::id()) {
            abort(403);
        }

        $kendaraan->delete();

        return redirect()->route('kendaraan.index')->with('success', 'Data kendaraan berhasil dihapus.');
    }
}
