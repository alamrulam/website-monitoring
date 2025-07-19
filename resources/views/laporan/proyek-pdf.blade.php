<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Proyek</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 0;
        }

        .table-info {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .table-info td {
            padding: 5px;
        }

        .table-main {
            width: 100%;
            border-collapse: collapse;
        }

        .table-main th,
        .table-main td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .table-main th {
            background-color: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 40px;
        }

        .footer-signature {
            float: right;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Pertanggungjawaban Keuangan</h1>
        <p>Proyek: {{ $proyek->nama_proyek }}</p>
    </div>

    <table class="table-info">
        <tr>
            <td width="20%">Nama Proyek</td>
            <td width="1%">:</td>
            <td>{{ $proyek->nama_proyek }}</td>
        </tr>
        <tr>
            <td>Lokasi</td>
            <td>:</td>
            <td>{{ $proyek->lokasi }}</td>
        </tr>
        <tr>
            <td>Pelaksana</td>
            <td>:</td>
            <td>{{ $proyek->pelaksana->nama_perusahaan }}</td>
        </tr>
        <tr>
            <td>Tanggal Laporan</td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::now()->format('d F Y') }}</td>
        </tr>
    </table>

    <h3>Ringkasan Keuangan</h3>
    <table class="table-main">
        <tr>
            <td width="50%">Total Anggaran</td>
            <td class="text-right">Rp {{ number_format($proyek->anggaran, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Total Pengeluaran</td>
            <td class="text-right">Rp {{ number_format($totalPengeluaran, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Sisa Anggaran</th>
            <th class="text-right">Rp {{ number_format($sisaAnggaran, 2, ',', '.') }}</th>
        </tr>
    </table>

    <h3 style="margin-top: 30px;">Rincian Transaksi (Buku Kas)</h3>
    <table class="table-main">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Uraian</th>
                <th>Kategori</th>
                <th>Pemasukan (Rp)</th>
                <th>Pengeluaran (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($proyek->pembayaran as $bayar)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($bayar->tanggal_transaksi)->format('d-m-Y') }}</td>
                    <td>{{ $bayar->uraian }}</td>
                    <td>{{ $bayar->kategori }}</td>
                    <td class="text-right">
                        {{ $bayar->jenis == 'Pemasukan' ? number_format($bayar->jumlah, 2, ',', '.') : '' }}</td>
                    <td class="text-right">
                        {{ $bayar->jenis == 'Pengeluaran' ? number_format($bayar->jumlah, 2, ',', '.') : '' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Belum ada transaksi.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">Total</th>
                <th class="text-right">Rp
                    {{ number_format($proyek->pembayaran()->where('jenis', 'Pemasukan')->sum('jumlah'), 2, ',', '.') }}
                </th>
                <th class="text-right">Rp {{ number_format($totalPengeluaran, 2, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <div class="footer-signature">
            <p>Disiapkan oleh,</p>
            <br><br><br>
            <p>( {{ $proyek->pelaksana->nama_kontak }} )</p>
            <p><strong>{{ $proyek->pelaksana->nama_perusahaan }}</strong></p>
        </div>
    </div>

</body>

</html>
