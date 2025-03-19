@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Faktur Barang</h1>

    @if(isset($invoiceNumber))
        <h2 class="text-xl font-semibold mb-2">Nomor Invoice: {{ $invoiceNumber }}</h2>
    @endif

    @php $total = 0; @endphp

    @if(empty($faktur))
        <p class="text-gray-500">Belum ada barang dalam faktur.</p>
    @else
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 p-2">Nama Barang</th>
                    <th class="border border-gray-300 p-2">Kategori</th>
                    <th class="border border-gray-300 p-2">Harga</th>
                    <th class="border border-gray-300 p-2">Jumlah</th>
                    <th class="border border-gray-300 p-2">Subtotal</th>
                    <th class="border border-gray-300 p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($faktur as $barang)
                    @php 
                        $subtotal = $barang['harga'] * $barang['jumlah']; // Inisialisasi subtotal di dalam loop
                        $total += $subtotal;
                    @endphp
                    <tr class="text-center">
                        <td class="border border-gray-300 p-2">{{ $barang['nama'] }}</td>
                        <td class="border border-gray-300 p-2">{{ $barang['kategori'] ?? 'Tidak Ada' }}</td>
                        <td class="border border-gray-300 p-2">Rp {{ number_format($barang['harga'], 0, ',', '.') }}</td>
                        <td class="border border-gray-300 p-2">{{ $barang['jumlah'] }}</td>
                        <td class="border border-gray-300 p-2">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        
                        <td class="border border-gray-300 p-2">
                            @if(isset($barang['id']))
                                <form action="{{ route('faktur.hapus', $barang['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <!-- Input jumlah yang ingin dikurangi -->
                                    <input type="number" name="jumlah" min="1" max="{{ $barang['jumlah'] }}" value="1" class="w-16 text-center border border-gray-300 rounded">

                                    <!-- Tombol Hapus -->
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Hapus</button>
                                </form>
                            @else
                                <span class="text-red-500">ID Tidak Tersedia</span>
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="border p-4 rounded-lg bg-gray-100 mt-4">
        <h2 class="text-lg font-semibold">Total Harga:</h2>
        <p class="text-xl font-bold">Rp {{ number_format($total, 0, ',', '.') }}</p>
    </div>

    <br>

    <form action="{{ route('faktur.checkout') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="alamat" class="block text-gray-700">Alamat Pengiriman:</label>
            <input type="text" id="alamat" name="alamat" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label for="kode_pos" class="block text-gray-700">Kode Pos:</label>
            <input type="text" id="kode_pos" name="kode_pos" class="w-full border rounded px-3 py-2" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Checkout</button>
    </form>
    
    @if(session()->has('checkout'))
        @php
            $alamat = session('checkout.alamat', '-');
            $kode_pos = session('checkout.kode_pos', '-');
        @endphp
    @else
        @php
            $alamat = '-';
            $kode_pos = '-';
        @endphp
    @endif

    <div class="border p-4 rounded-lg bg-gray-100 mt-4">
        <h2 class="text-lg font-semibold">Detail Pengiriman</h2>
        <p><strong>Alamat:</strong> {{ $alamat }}</p>
        <p><strong>Kode Pos:</strong> {{ $kode_pos }}</p>
        <p><strong>Total Harga: Rp {{ number_format($total, 0, ',', '.') }}</p>
    </div>
    
    <div class="mt-4">
        <a href="{{ route('faktur.cetak', $invoiceNumber ?? '') }}" class="bg-green-500 text-white px-4 py-2 rounded" target="_blank">
            Cetak Faktur
        </a>
    </div>


    <div class="mt-4">
        <a href="{{ route('barang.katalog') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali ke Katalog</a>
    </div>

    <div class="mt-4">
        <form action="{{ route('faktur.reset') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">
                Reset Faktur
            </button>
        </form>
    </div>

</div>
@endsection