<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: Arial, sans-serif; font-size: 11px; color: #1e293b; }
    .header { background: #1a56db; color: white; padding: 16px 20px; margin-bottom: 16px; }
    .header h1 { font-size: 18px; margin-bottom: 2px; }
    .header p { font-size: 11px; opacity: .85; }
    .meta { display: flex; gap: 20px; margin-bottom: 16px; font-size: 11px; }
    .meta-item { background: #f1f5f9; padding: 8px 12px; border-radius: 6px; flex: 1; }
    .meta-item .label { color: #64748b; font-size: 10px; }
    .meta-item .value { font-size: 16px; font-weight: bold; color: #1a56db; }
    h3 { font-size: 12px; color: #1a56db; border-bottom: 2px solid #1a56db; padding-bottom: 4px; margin-bottom: 8px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 16px; font-size: 10px; }
    thead th { background: #1a56db; color: white; padding: 6px 8px; text-align: left; }
    tbody td { padding: 5px 8px; border-bottom: 1px solid #e2e8f0; }
    tbody tr:nth-child(even) { background: #f8fafc; }
    .tfoot td { background: #e2e8f0; font-weight: bold; padding: 6px 8px; }
    .footer { margin-top: 20px; text-align: right; font-size: 10px; color: #64748b; border-top: 1px solid #e2e8f0; padding-top: 8px; }
    .badge-green { background: #dcfce7; color: #166534; padding: 2px 6px; border-radius: 4px; font-size: 9px; }
</style>
</head>
<body>

<div class="header">
    <h1>Laporan Pendapatan SportBook</h1>
    <p>GOR Satria Purwokerto · Program Reservasi Lapangan Olahraga</p>
</div>

<div class="meta">
    <div class="meta-item">
        <div class="label">Periode</div>
        <div class="value" style="font-size:13px">{{ \Carbon\Carbon::createFromFormat('Y-m',$month)->translatedFormat('F Y') }}</div>
    </div>
    <div class="meta-item">
        <div class="label">Total Booking</div>
        <div class="value">{{ $bookings->count() }}</div>
    </div>
    <div class="meta-item">
        <div class="label">Total Pendapatan</div>
        <div class="value" style="font-size:13px">Rp {{ number_format($totalRevenue,0,',','.') }}</div>
    </div>
    <div class="meta-item">
        <div class="label">Dicetak</div>
        <div class="value" style="font-size:11px">{{ now()->format('d/m/Y H:i') }}</div>
    </div>
</div>

<h3>Rekap Pendapatan per Lapangan</h3>
<table>
    <thead>
        <tr>
            <th>Lapangan</th>
            <th>Jenis</th>
            <th>Jumlah Booking</th>
            <th>Total Pendapatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($revenueByField as $r)
        <tr>
            <td>{{ $r['field']->name }}</td>
            <td>{{ $r['field']->fieldType->name }}</td>
            <td>{{ $r['count'] }} booking</td>
            <td><strong>Rp {{ number_format($r['total'],0,',','.') }}</strong></td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="tfoot">
            <td colspan="3">TOTAL KESELURUHAN</td>
            <td>Rp {{ number_format($totalRevenue,0,',','.') }}</td>
        </tr>
    </tfoot>
</table>

<h3>Detail Transaksi Booking</h3>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Kode Booking</th>
            <th>Nama User</th>
            <th>Lapangan</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Durasi</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bookings as $i => $b)
        <tr>
            <td>{{ $i+1 }}</td>
            <td><strong>{{ $b->booking_code }}</strong></td>
            <td>{{ $b->user->name }}</td>
            <td>{{ $b->field->name }}</td>
            <td>{{ $b->booking_date->format('d/m/Y') }}</td>
            <td>{{ substr($b->start_time,0,5) }}–{{ substr($b->end_time,0,5) }}</td>
            <td>{{ $b->duration_hours }} jam</td>
            <td>Rp {{ number_format($b->total_price,0,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="tfoot">
            <td colspan="7">TOTAL</td>
            <td>Rp {{ number_format($totalRevenue,0,',','.') }}</td>
        </tr>
    </tfoot>
</table>

<div class="footer">
    SportBook — GOR Satria Purwokerto · Laporan dibuat otomatis oleh sistem
</div>

</body>
</html>
