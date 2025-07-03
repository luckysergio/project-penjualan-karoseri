<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Invoice Order HOPE-KDT-00{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #1e3a8a;
            border-bottom: 1px solid #ccc;
            margin-bottom: 10px;
            padding-bottom: 4px;
        }

        .info-table,
        .product-table,
        .totals {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 6px 0;
        }

        .product-table th,
        .product-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .product-table th {
            background-color: #f3f4f6;
            font-weight: bold;
        }

        .totals td {
            padding: 6px;
        }

        .text-right {
            text-align: right;
        }

        .text-bold {
            font-weight: bold;
        }

        .footer-note {
            font-size: 10px;
            color: #666;
            margin-top: 40px;
            text-align: center;
        }

        .status-note {
            font-weight: bold;
            margin-top: 10px;
        }

        .status-paid {
            color: green;
        }

        .status-unpaid {
            color: red;
        }
    </style>
</head>

<body>
    <h2>INVOICE ORDER - HOPE-KDT-00{{ $order->id }}</h2>

    <div class="section">
        <div class="section-title">Informasi Pemesan</div>
        <table class="info-table">
            <tr>
                <td>Nama</td>
                <td>: {{ $order->pelanggan->user->name }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>: {{ $order->pelanggan->user->email }}</td>
            </tr>
            <tr>
                <td>No HP</td>
                <td>: {{ $order->pelanggan->no_hp }}</td>
            </tr>
        </table>
    </div>

    @if ($order->sales)
        <div class="section">
            <div class="section-title">Informasi Sales</div>
            <table class="info-table">
                <tr>
                    <td>Nama Sales</td>
                    <td>: {{ $order->sales->user->name }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>: {{ $order->sales->user->email ?? '-' }}</td>
                </tr>
            </table>
        </div>
    @endif

    <div class="section">
        <div class="section-title">Detail Produk</div>
        <table class="product-table">
            <thead>
                <tr>
                    <th>Type Dump</th>
                    <th>Jenis Dump</th>
                    <th>Chassis</th>
                    <th>Qty</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalProduk = 0;
                @endphp
                @foreach ($order->detailOrders as $detail)
                    @php
                        $hargaSatuan = $detail->typeDump->harga ?? 0;
                        $subtotal = $detail->qty * $hargaSatuan;
                        $totalProduk += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $detail->typeDump->nama }}</td>
                        <td>{{ $detail->jenisDump->nama }}</td>
                        <td>{{ $detail->chassis->nama }}</td>
                        <td>{{ $detail->qty }}</td>
                        <td>Rp {{ number_format($hargaSatuan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-bold text-right">Total Harga Produk</td>
                    <td class="text-bold">Rp {{ number_format($totalProduk, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Informasi Pengiriman</div>
        @if ($order->pengiriman)
            <table class="info-table">
                <tr>
                    <td>Alamat</td>
                    <td>: {{ $order->pengiriman->alamat }}</td>
                </tr>
                <tr>
                    <td>Tanggal Kirim</td>
                    <td>: {{ \Carbon\Carbon::parse($order->pengiriman->tanggal_kirim)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td>Biaya Pengiriman</td>
                    <td>: Rp {{ number_format($order->pengiriman->biaya, 0, ',', '.') }}</td>
                </tr>
            </table>
        @else
            <p style="color: red;">Tidak menggunakan layanan pengiriman.</p>
        @endif
    </div>

    @php
        $biayaPengiriman = $order->pengiriman->biaya ?? 0;
        $totalTagihan = $order->total_harga + $biayaPengiriman;
        $totalDibayar = $order->pembayarans->sum('pembayaran');
        $sisa = $totalTagihan - $totalDibayar;
    @endphp

    <div class="section">
        <div class="section-title">Informasi Pembayaran</div>
        <table class="totals">
            <tr>
                <td class="text-bold">Total Tagihan</td>
                <td class="text-right">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-bold">Total Dibayar</td>
                <td class="text-right">Rp {{ number_format($totalDibayar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-bold">Sisa Pembayaran</td>
                <td class="text-right">Rp {{ number_format($sisa, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div class="footer-note">
        Dokumen ini dihasilkan secara otomatis oleh sistem. Tidak memerlukan tanda tangan atau cap perusahaan.
    </div>
</body>

</html>
