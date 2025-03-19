<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    //Show semua barang
    public function index()
    {
        // $barangs = Barang::all();
        $barangs = Barang::with('kategori')->get();
        return view('barang.index', compact('barangs'));
    }

    //Form tambah barang
    public function create()
    {
        $kategoris = \App\Models\Kategori::all(); // Ambil semua kategori dari database
        return view('barang.create', compact('kategoris'));
    }

    //Simpan barang ke database
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama' => 'required|string|min:5|max:80',
            'harga' => 'required|integer',
            'jumlah' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('barang_fotos', 'public');
        }

        // Simpan ke database
        Barang::create([
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }


    //Form edit barang
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategoris = Kategori::all();
        return view('barang.edit', compact('barang', 'kategoris'));
    }

    //Update barang
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama' => 'required|string|min:5|max:80',
            'harga' => 'required|integer',
            'jumlah' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $barang = Barang::findOrFail($id);

        // Handle file upload jika ada
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('barang_fotos', 'public');
            $barang->foto = $fotoPath;
        }

        // Update data barang
        $barang->update([
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah,
            'foto' => $barang->foto, // Tetap gunakan foto lama jika tidak diubah
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui!');
    }

    //Hapus barang
    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus!');
    }

    public function katalog()
    {
        $barangs = Barang::all();
        return view('barang.katalog', compact('barangs'));
    }

}
