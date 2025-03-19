@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Katalog Barang</h1>

    <div class="mb-4">
        <a href="{{ route('faktur.index') }}" class="bg-green-500 text-white px-4 py-2 rounded">
            Lihat Faktur
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($barangs as $barang)
            <div class="border p-4 rounded-lg shadow-lg">
                <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama }}" class="w-full h-40 object-cover rounded">
                <h2 class="text-lg font-semibold mt-2">{{ $barang->nama }}</h2>
                <p class="text-gray-700">Kategori: {{ $barang->kategori->nama }}</p>
                <p class="text-green-600 font-bold">Rp {{ number_format($barang->harga, 0, ',', '.') }}</p>
                <p class="text-gray-600">Stok: {{ $barang->jumlah }}</p>

                <td class="border border-gray-300 p-2">
                    <form action="{{ route('faktur.tambah', $barang->id) }}" method="POST" onsubmit="return validateForm(this)">
                        @csrf
                        <div class="flex items-center gap-2 mt-2">
                            <input type="number" name="jumlah" min="1" max="{{ $barang->jumlah }}" value="1"
                                class="w-16 border border-gray-300 rounded px-2 py-1 text-center" required>
                            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">
                                Tambah ke Faktur
                            </button>
                        </div>
                    </form>
                </td>

            </div>
        @endforeach
    </div>
</div>
@endsection

<script>
    function validateForm(form) {
        let jumlahInput = form.querySelector('input[name="jumlah"]');
        let jumlah = parseInt(jumlahInput.value);
        let maxJumlah = parseInt(jumlahInput.max);

        if (jumlah < 1 || jumlah > maxJumlah) {
            alert("Jumlah harus antara 1 dan " + maxJumlah);
            return false; // Mencegah form terkirim
        }

        return confirm("Tambahkan " + jumlah + " item ke faktur?");
    }
</script>

