<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Faktur</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Faktur Barang</h2>
    <p><strong>Nomor Invoice:</strong> {{ $faktur->invoice_number }}</p>
    <p><strong>Alamat Pengiriman:</strong> {{ $faktur->alamat }}</p>
    <p><strong>Kode Pos:</strong> {{ $faktur->kode_pos }}</p>

    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($details as $barang)
                <tr>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->kategori ?? '-' }}</td>
                    <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                    <td>{{ $barang->jumlah }}</td>
                    <td>Rp {{ number_format($barang->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total Harga: Rp {{ number_format($faktur->total_harga, 0, ',', '.') }}</h3>
</body>
</html>