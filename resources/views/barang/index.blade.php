@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Barang</h1>
    
    <!-- Tombol Tambah Barang -->
    <div class="mb-4">
        <a href="{{ route('barang.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            + Tambah Barang
        </a>
    </div>

    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-300 p-2">No</th>
                <th class="border border-gray-300 p-2">Kategori</th>
                <th class="border border-gray-300 p-2">Nama Barang</th>
                <th class="border border-gray-300 p-2">Harga</th>
                <th class="border border-gray-300 p-2">Jumlah</th>
                <th class="border border-gray-300 p-2">Aksi</th>
                <th class="border border-gray-300 p-2">Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangs as $key => $barang)
                <tr class="text-center">
                    <td class="border border-gray-300 p-2">{{ $key + 1 }}</td>
                    <td class="border border-gray-300 p-2">{{ $barang->kategori->nama }}</td>
                    <td class="border border-gray-300 p-2">{{ $barang->nama}}</td>
                    <td class="border border-gray-300 p-2">Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                    <td class="border border-gray-300 p-2">{{ $barang->jumlah}}</td>
                    <td class="border border-gray-300 p-2">
                        <!-- <a href="#" class="text-blue-500">Edit</a> | 
                        <a href="#" class="text-red-500">Hapus</a> -->
                        <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <br>
                        <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</button>
                        </form>
                    </td>
                    <td  class="text-center">
                        @if ($barang->foto)
                            <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama }}" width="100" class="d-block mx-auto">
                        @else
                            Tidak ada foto
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
