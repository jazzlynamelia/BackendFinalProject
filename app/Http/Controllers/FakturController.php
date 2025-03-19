<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\Session;
use App\Models\Faktur;
use App\Models\FakturDetail;

class FakturController extends Controller
{
    // public function tambahKeFaktur($id)
    // {
    //     $barang = Barang::findOrFail($id);

    //     // Ambil session faktur, jika tidak ada buat array kosong
    //     $faktur = session()->get('faktur', []);

    //     // Jika barang sudah ada di faktur, tambahkan jumlahnya
    //     if (isset($faktur[$id])) {
    //         $faktur[$id]['jumlah'] += 1;
    //     } else {
    //         // Jika barang belum ada, tambahkan ke faktur
    //         $faktur[$id] = [
    //             "id" => $barang->id,
    //             "nama" => $barang->nama,
    //             "harga" => $barang->harga,
    //             "jumlah" => 1
    //         ];
    //     }

    //     // Simpan kembali ke session
    //     session()->put('faktur', $faktur);

    //     return redirect()->back()->with('success', 'Barang berhasil ditambahkan ke faktur!');

    // }

    public function tambahKeFaktur(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $jumlah = $request->input('jumlah'); // Mengambil input jumlah dari form

        // Pastikan jumlah yang dimasukkan valid
        if ($jumlah < 1 || $jumlah > $barang->jumlah) {
            return redirect()->back()->with('error', 'Jumlah tidak valid!');
        }

        // Simpan ke faktur (gunakan session)
        $faktur = session()->get('faktur', []);

        // Jika barang sudah ada di faktur, update jumlahnya
        if (isset($faktur[$id])) {
            $faktur[$id]['jumlah'] += $jumlah;
        } else {
            // Jika belum ada, tambahkan barang ke faktur
            $faktur[$id] = [
                'id' => $barang->id,
                'nama' => $barang->nama,
                'kategori' => $barang->kategori->nama,
                'harga' => $barang->harga,
                'jumlah' => $jumlah
            ];
        }

        // Simpan kembali ke session
        session()->put('faktur', $faktur);

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan ke faktur!');
    }


    public function index()
    {
        // Ambil daftar barang yang ada di sesi faktur
        $faktur = Session::get('faktur', []);

        // Generate nomor invoice jika belum ada
        if (!session()->has('invoice_number')) {
            $invoiceNumber = 'INV-' . time();
            session()->put('invoice_number', $invoiceNumber);
        } else {
            $invoiceNumber = session()->get('invoice_number');
        }

        return view('barang.faktur', compact('faktur', 'invoiceNumber'));
    }

    public function reset()
    {
        session()->forget('faktur'); // Menghapus semua barang dalam faktur dari session
        session()->forget('checkout');

        return redirect()->route('faktur.index')->with('success', 'Faktur berhasil direset!');
    }

    public function hapus(Request $request, $id)
    {
        $faktur = session()->get('faktur', []);

        // Pastikan barang ada di faktur
        if (isset($faktur[$id])) {
            $jumlahHapus = $request->input('jumlah');

            // Jika jumlah yang akan dihapus lebih besar atau sama dengan jumlah barang, hapus total
            if ($jumlahHapus >= $faktur[$id]['jumlah']) {
                unset($faktur[$id]);
            } else {
                // Kurangi jumlah barang
                $faktur[$id]['jumlah'] -= $jumlahHapus;
            }

            // Simpan perubahan ke session
            session()->put('faktur', $faktur);
        }

        return redirect()->back()->with('success', 'Barang berhasil dikurangi dari faktur!');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string|max:255',
            'kode_pos' => 'required|numeric|digits:5',
        ]);

        session()->put('checkout', [
            'alamat' => $request->alamat,
            'kode_pos' => $request->kode_pos,
        ]);

        //Simpan Data

        $faktur = session('faktur', []);
        if (empty($faktur)) {
            return redirect()->route('faktur.index')->with('error', 'Faktur kosong!');
        }

        $totalHarga = array_reduce($faktur, function ($carry, $item) {
            return $carry + ($item['harga'] * $item['jumlah']);
        }, 0);

        $invoiceNumber = 'INV-' . time();

        // Simpan faktur ke database
        $fakturData = Faktur::create([
            'invoice_number' => $invoiceNumber,
            'alamat' => $request->alamat,
            'kode_pos' => $request->kode_pos,
            'total_harga' => $totalHarga,
        ]);

        // Simpan detail faktur ke database
        foreach ($faktur as $barang) {
            FakturDetail::create([
                'faktur_id' => $fakturData->id,
                'nama_barang' => $barang['nama'],
                'kategori' => $barang['kategori'] ?? null,
                'harga' => $barang['harga'],
                'jumlah' => $barang['jumlah'],
                'subtotal' => $barang['harga'] * $barang['jumlah'],
            ]);
        }

        // Hapus faktur dari session setelah disimpan
        session()->forget('faktur');

        return redirect()->route('faktur.index')->with('success', 'Alamat pengiriman berhasil disimpan!');
    }

    public function cetak($invoice)
    {
        $faktur = Faktur::where('invoice_number', $invoice)->firstOrFail();
        $details = FakturDetail::where('faktur_id', $faktur->id)->get();

        $pdf = PDF::loadView('faktur.cetak', compact('faktur', 'details'));
        return $pdf->stream("Faktur_$invoice.pdf");
    }

}
