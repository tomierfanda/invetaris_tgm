<?php

namespace App\Http\Controllers;

use App\Exports\InventarisExport;
use Illuminate\Http\Request;
use App\Models\Inventaris;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class InventarisController extends Controller
{
    public function index()
    {
        $inventaris = Inventaris::orderBy('created_at', 'desc')->paginate(10); // 10 data per page
        return view('inventaris.index', compact('inventaris'));
    }

    public function create()
    {
        return view('inventaris.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_lebelisasi' => 'required|string|unique:inventaris',
            'kode_barang' => 'nullable|string',
            'nama_barang' => 'required|string',
            'tahun_pembelian' => 'nullable|numeric',
            'foto_lokasi' => 'nullable|image|max:2048',
        ]);

        $data = array_merge($request->all(), $validated);

        if ($request->hasFile('foto_lokasi')) {
            $path = $request->file('foto_lokasi')->store('foto_lokasi', 'public');
            $data['foto_lokasi'] = $path;
        }

        $inventaris = Inventaris::create($data);

    try {
        $qrDir = storage_path('app/public/qrcodes/');
        if (!file_exists($qrDir)) {
            mkdir($qrDir, 0755, true);
        }

        $filename = $inventaris->nomor_lebelisasi . '.svg'; // ubah ke SVG biar ringan
        $qrContent = url('/inventaris/' . $inventaris->id);

        // Paksa pakai backend SVG biar gak butuh imagick
        QrCode::format('svg')
            ->size(300)
            ->margin(2)
            ->generate($qrContent, $qrDir . $filename);

        $inventaris->update([
            'barcode_path' => 'storage/qrcodes/' . $filename,
        ]);

        Log::info('✅ QR Code berhasil dibuat (SVG): ' . $qrDir . $filename);
    } catch (\Exception $e) {
        Log::error('❌ Gagal generate QR Code untuk Inventaris ID ' . $inventaris->id . ': ' . $e->getMessage());
    }

    return redirect()->route('inventaris.index')->with('success', 'Data berhasil disimpan');
}



    public function show($id)
    {
        $inventaris = Inventaris::find($id);
        if (!$inventaris) {
            abort(404, 'Data tidak ditemukan');
        }
        return view('inventaris.show', compact('inventaris'));
    }

    public function edit(Inventaris $inventaris)
    {
        return view('inventaris.edit', compact('inventaris'));
    }

    public function update(Request $request, Inventaris $inventaris)
    {
        $request->validate([
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('foto_lokasi')) {
            // Hapus foto lama dulu kalau ada
            if ($inventaris->foto_lokasi && Storage::disk('public')->exists($inventaris->foto_lokasi)) {
                Storage::disk('public')->delete($inventaris->foto_lokasi);
            }

            // Simpan file ke storage/app/public/foto_lokasi
            $path = $request->file('foto_lokasi')->store('foto_lokasi', 'public');
            // Simpan PATH RELATIF lengkap di DB (misal: foto_lokasi/1759983994.png)
            $data['foto_lokasi'] = $path;
        }

        $inventaris->update($data);

        return redirect()->route('inventaris.index')
            ->with('success', 'Data inventaris berhasil diperbarui.');
    }

    public function destroy(Inventaris $inventaris)
    {
        // Hapus file foto & barcode jika mau
        if ($inventaris->foto_lokasi) {
            Storage::delete(str_replace('/storage/', 'public/', $inventaris->foto_lokasi));
        }
        if ($inventaris->barcode_path) {
            Storage::delete(str_replace('storage/', 'public/', $inventaris->barcode_path));
        }

        $inventaris->delete();
        return redirect()->route('inventaris.index')->with('success', 'Data berhasil dihapus');
    }

    // 🔍 Cari lewat barcode / nomor label
    public function search(Request $request)
    {
        $q = $request->q;
        $items = Inventaris::where('nomor_lebelisasi', 'like', "%$q%")
            ->orWhere('kode_barang', 'like', "%$q%")
            ->orWhere('nama_barang', 'like', "%$q%")
            ->get();

        return view('inventaris.search', compact('items', 'q'));
    }

    public function printBarcode($id)
    {

        $inventaris = Inventaris::findOrFail($id);

        if (!$inventaris->barcode_path) {
            return redirect()->route('inventaris.index')->with('error', 'Barcode belum tersedia untuk item ini.');
        }

        return view('inventaris.print', compact('inventaris'));
    }

    public function export()
    {
        return Excel::download(new InventarisExport, 'inventaris.xlsx');
    }

}
