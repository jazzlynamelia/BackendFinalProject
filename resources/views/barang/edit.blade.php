@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Barang</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="kategori_id" class="form-label">Kategori</label>
            <select class="form-control" id="kategori_id" name="kategori_id">
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ $barang->kategori_id == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $barang->nama }}" required>
        </div>

        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" id="harga" name="harga" value="{{ $barang->harga }}" required>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $barang->jumlah }}" required>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto Barang (Opsional)</label>
            <input type="file" class="form-control" id="foto" name="foto">
            <p>Foto saat ini:</p>
            @if ($barang->foto)
                <img src="{{ asset('storage/' . $barang->foto) }}" alt="Foto Barang" width="150">
            @else
                <p>Tidak ada foto</p>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <br>
        <a href="{{ route('barang.index') }}" class="btn btn-danger">Batal</a>
    </form>
</div>
@endsection
