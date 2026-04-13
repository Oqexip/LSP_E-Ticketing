<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi E-Ticketing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #1e3a8a;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
        }
        .summary {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
        }
        .summary-item {
            margin-bottom: 8px;
        }
        .summary-label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f1f5f9;
            font-weight: bold;
            color: #475569;
        }
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .badge {
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            color: white;
        }
        .bg-success { background-color: #22c55e; }
        .bg-warning { background-color: #f59e0b; }
        .bg-danger { background-color: #ef4444; }
        .text-right { text-align: right; }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Pinto Air</h1>
        <p>Laporan Transaksi Pemesanan Tiket</p>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <span class="summary-label">Total Transaksi (Baris)</span>: {{ count($transactions) }}
        </div>
        <div class="summary-item">
            <span class="summary-label">Total Pendapatan (Lunas)</span>: <strong>Rp {{ number_format($totalRevenue) }}</strong>
        </div>
        <div class="summary-item">
            <span class="summary-label">Waktu Cetak</span>: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="8%">ID</th>
                <th width="15%">Tanggal</th>
                <th width="20%">Pelanggan</th>
                <th width="25%">Rute Penerbangan</th>
                <th width="12%">Total (Rp)</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $t)
                <tr>
                    <td>#{{ $t->id }}</td>
                    <td>{{ $t->created_at->format('d/m/y H:i') }}</td>
                    <td>{{ $t->booking->user->name ?? '-' }}</td>
                    <td>
                        {{ Str::before($t->booking->schedule->origin ?? '-', ' (') }} - 
                        {{ Str::before($t->booking->schedule->destination ?? '-', ' (') }}
                    </td>
                    <td class="text-right">{{ number_format($t->amount) }}</td>
                    <td>
                        @if($t->status === 'Lunas')
                            <span class="badge bg-success">Lunas</span>
                        @elseif($t->status === 'Pending')
                            <span class="badge bg-warning">Pending</span>
                        @else
                            <span class="badge bg-danger">{{ $t->status }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" align="center">Tidak ada transaksi pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak secara otomatis oleh Sistem Pinto Air.
    </div>
</body>
</html>
