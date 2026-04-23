@extends('layouts.app')
@section('title','Laporan Pendapatan')
@section('page-title','Laporan')
@section('content')
<div class="page-header fade-in">
    <div><div class="page-title">Laporan Pendapatan</div><div class="page-sub">{{ \Carbon\Carbon::createFromFormat('Y-m',$month)->translatedFormat('F Y') }}</div></div>
    <a href="{{ route('admin.reports.pdf',['month'=>$month]) }}" class="btn-danger-sb" style="padding:9px 16px"><i class="fas fa-file-pdf"></i>Export PDF</a>
</div>
<div class="card-sb mb-3 fade-in-1"><div class="card-sb-body" style="padding:14px 18px">
    <form class="d-flex gap-2 align-items-end">
        <div><div class="form-label">Periode</div><input type="month" name="month" class="form-control" value="{{ $month }}"></div>
        <button type="submit" class="btn-primary-sb"><i class="fas fa-filter"></i>Tampilkan</button>
    </form>
</div></div>

<div class="row g-3 mb-4">
    <div class="col-md-4 fade-in-1">
        <div class="stat-card green">
            <div class="stat-icon green"><i class="fas fa-coins"></i></div>
            <div class="stat-label">Total Pendapatan</div>
            <div class="stat-value" style="font-size:1.1rem">Rp {{ number_format($totalRevenue,0,',','.') }}</div>
            <div class="stat-sub">Booking terkonfirmasi</div>
        </div>
    </div>
    <div class="col-md-8 fade-in-2">
        <div class="card-sb h-100">
            <div class="card-sb-header"><div class="card-sb-title"><div class="dot"></div>Per Lapangan</div></div>
            <div style="overflow-x:auto">
                <table class="table-sb">
                    <thead><tr><th>Lapangan</th><th>Jenis</th><th>Booking</th><th>Pendapatan</th></tr></thead>
                    <tbody>
                    @forelse($revenueByField as $r)
                    <tr>
                        <td style="font-weight:600;color:#e2e8f0">{{ $r->field->name }}</td>
                        <td><span class="badge-type">{{ $r->field->fieldType->name }}</span></td>
                        <td style="color:#94a3b8">{{ $r->count }}x</td>
                        <td style="font-weight:700;color:#00d4aa;font-family:'JetBrains Mono',monospace;font-size:.78rem">Rp {{ number_format($r->total,0,',','.') }}</td>
                    </tr>
                    @empty<tr><td colspan="4" style="text-align:center;padding:24px;color:#64748b">Tidak ada data</td></tr>@endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card-sb fade-in-3">
    <div class="card-sb-header"><div class="card-sb-title"><div class="dot" style="background:#0ea5e9"></div>Detail Booking Terkonfirmasi</div></div>
    <div class="table-responsive">
        <table class="table-sb">
            <thead><tr><th>#</th><th>Kode</th><th>User</th><th>Lapangan</th><th>Tanggal</th><th>Waktu</th><th>Total</th></tr></thead>
            <tbody>
            @forelse($bookings as $b)
            <tr>
                <td style="color:#64748b;font-size:.75rem">{{ $bookings->firstItem()+$loop->index }}</td>
                <td><span class="mono" style="color:#0ea5e9;font-size:.78rem">{{ $b->booking_code }}</span></td>
                <td style="color:#e2e8f0">{{ $b->user->name }}</td>
                <td>{{ $b->field->name }}</td>
                <td><span class="mono" style="font-size:.78rem">{{ $b->booking_date->format('d/m/Y') }}</span></td>
                <td><span class="mono" style="font-size:.78rem;color:#94a3b8">{{ substr($b->start_time,0,5) }}–{{ substr($b->end_time,0,5) }}</span></td>
                <td style="font-weight:700;color:#00d4aa">Rp {{ number_format($b->total_price,0,',','.') }}</td>
            </tr>
            @empty<tr><td colspan="7" style="text-align:center;padding:40px;color:#64748b">Tidak ada data bulan ini</td></tr>@endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:14px 18px;border-top:1px solid #1e2d45">{{ $bookings->appends(['month'=>$month])->links() }}</div>
</div>
@endsection
