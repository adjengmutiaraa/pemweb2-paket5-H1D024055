@extends('layouts.app')
@section('title','Dashboard Admin')
@section('page-title','Dashboard')
@section('content')

<div class="page-header fade-in">
    <div>
        <div class="page-title">Overview</div>
        <div class="page-sub">Pantau aktivitas booking dan pendapatan GOR Satria</div>
    </div>
    <a href="{{ route('admin.bookings.index') }}" class="btn-primary-sb"><i class="fas fa-calendar-check"></i>Lihat Semua Booking</a>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3 fade-in-1">
        <div class="stat-card green">
            <div class="stat-icon green"><i class="fas fa-calendar-check"></i></div>
            <div class="stat-label">Total Booking</div>
            <div class="stat-value">{{ $stats['total_bookings'] }}</div>
            <div class="stat-sub">Semua waktu</div>
        </div>
    </div>
    <div class="col-6 col-xl-3 fade-in-2">
        <div class="stat-card blue">
            <div class="stat-icon blue"><i class="fas fa-calendar-day"></i></div>
            <div class="stat-label">Booking Hari Ini</div>
            <div class="stat-value">{{ $stats['today_bookings'] }}</div>
            <div class="stat-sub">{{ $today->format('d M Y') }}</div>
        </div>
    </div>
    <div class="col-6 col-xl-3 fade-in-3">
        <div class="stat-card yellow">
            <div class="stat-icon yellow"><i class="fas fa-clock"></i></div>
            <div class="stat-label">Menunggu Konfirmasi</div>
            <div class="stat-value">{{ $stats['pending_payment'] }}</div>
            <div class="stat-sub">Perlu ditinjau</div>
        </div>
    </div>
    <div class="col-6 col-xl-3 fade-in-4">
        <div class="stat-card red">
            <div class="stat-icon red"><i class="fas fa-coins"></i></div>
            <div class="stat-label">Pendapatan Hari Ini</div>
            <div class="stat-value" style="font-size:1.1rem">Rp {{ number_format($stats['today_revenue'],0,',','.') }}</div>
            <div class="stat-sub">Booking terkonfirmasi</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4 fade-in-1">
        <div class="stat-card blue" style="display:flex;align-items:center;gap:14px;padding:16px 18px">
            <div style="width:44px;height:44px;border-radius:12px;background:rgba(14,165,233,.12);display:flex;align-items:center;justify-content:center;font-size:18px;color:#0ea5e9;flex-shrink:0"><i class="fas fa-map-marker-alt"></i></div>
            <div><div class="stat-label" style="margin-bottom:2px">Total Lapangan</div><div style="font-size:1.5rem;font-weight:800;color:#fff">{{ $stats['total_fields'] }}</div></div>
        </div>
    </div>
    <div class="col-md-4 fade-in-2">
        <div class="stat-card green" style="display:flex;align-items:center;gap:14px;padding:16px 18px">
            <div style="width:44px;height:44px;border-radius:12px;background:rgba(0,212,170,.12);display:flex;align-items:center;justify-content:center;font-size:18px;color:#00d4aa;flex-shrink:0"><i class="fas fa-users"></i></div>
            <div><div class="stat-label" style="margin-bottom:2px">Total User</div><div style="font-size:1.5rem;font-weight:800;color:#fff">{{ $stats['total_users'] }}</div></div>
        </div>
    </div>
    <div class="col-md-4 fade-in-3">
        <div class="stat-card yellow" style="display:flex;align-items:center;gap:14px;padding:16px 18px">
            <div style="width:44px;height:44px;border-radius:12px;background:rgba(245,158,11,.12);display:flex;align-items:center;justify-content:center;font-size:18px;color:#f59e0b;flex-shrink:0"><i class="fas fa-hourglass-half"></i></div>
            <div><div class="stat-label" style="margin-bottom:2px">Menunggu Bayar</div><div style="font-size:1.5rem;font-weight:800;color:#fff">{{ $stats['pending_payment'] }}</div></div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Pending Bookings --}}
    <div class="col-lg-7 fade-in-2">
        <div class="card-sb h-100">
            <div class="card-sb-header">
                <div class="card-sb-title"><div class="dot" style="background:#f59e0b"></div>Perlu Dikonfirmasi</div>
                <a href="{{ route('admin.bookings.index',['status'=>'menunggu_pembayaran']) }}" class="btn-ghost" style="padding:5px 11px;font-size:.72rem">Lihat Semua</a>
            </div>
            @forelse($pendingBookings as $b)
            <div style="display:flex;align-items:center;gap:14px;padding:13px 18px;border-bottom:1px solid #1e2d45">
                <div style="width:36px;height:36px;border-radius:9px;background:rgba(245,158,11,.12);display:flex;align-items:center;justify-content:center;color:#f59e0b;flex-shrink:0"><i class="fas fa-calendar"></i></div>
                <div style="flex:1;min-width:0">
                    <div style="font-size:.82rem;font-weight:600;color:#e2e8f0">{{ $b->booking_code }}</div>
                    <div style="font-size:.72rem;color:#64748b">{{ $b->user->name }} · {{ $b->field->name }} · {{ $b->booking_date->format('d/m/Y') }}</div>
                </div>
                <div style="text-align:right">
                    <div style="font-size:.82rem;font-weight:700;color:#00d4aa">Rp {{ number_format($b->total_price,0,',','.') }}</div>
                    @if($b->payment_proof)<span class="badge-sb badge-green" style="font-size:.65rem">Bukti Ada</span>@else<span class="badge-sb badge-yellow" style="font-size:.65rem">Belum Upload</span>@endif
                </div>
                <a href="{{ route('admin.bookings.show',$b) }}" class="btn-icon"><i class="fas fa-arrow-right"></i></a>
            </div>
            @empty
            <div style="padding:36px;text-align:center;color:#64748b">
                <i class="fas fa-check-circle fa-2x" style="color:#00d4aa;margin-bottom:8px;display:block"></i>
                <div style="font-size:.82rem">Semua booking sudah dikonfirmasi</div>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Revenue Chart --}}
    <div class="col-lg-5 fade-in-3">
        <div class="card-sb h-100">
            <div class="card-sb-header">
                <div class="card-sb-title"><div class="dot"></div>Pendapatan 7 Hari</div>
            </div>
            <div class="card-sb-body">
                @forelse($dailyRevenue as $r)
                @php $pct = $dailyRevenue->max('revenue') > 0 ? ($r->revenue / $dailyRevenue->max('revenue')) * 100 : 0; @endphp
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px">
                    <div style="width:38px;font-size:.7rem;color:#64748b;font-family:'JetBrains Mono',monospace;flex-shrink:0">{{ \Carbon\Carbon::parse($r->booking_date)->format('d/m') }}</div>
                    <div style="flex:1;background:#1a2234;border-radius:6px;height:22px;overflow:hidden">
                        <div style="width:{{ max($pct,4) }}%;height:100%;background:linear-gradient(90deg,#00d4aa,#0ea5e9);border-radius:6px;display:flex;align-items:center;padding:0 8px;transition:width .5s">
                            <span style="font-size:.65rem;font-weight:700;color:#000;white-space:nowrap">{{ $r->count }}x</span>
                        </div>
                    </div>
                    <div style="width:70px;text-align:right;font-size:.7rem;font-weight:600;color:#e2e8f0;font-family:'JetBrains Mono',monospace">{{ number_format($r->revenue/1000,0) }}rb</div>
                </div>
                @empty
                <div style="text-align:center;color:#64748b;padding:24px;font-size:.82rem">Belum ada data</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Calendar --}}
    <div class="col-12 fade-in-4">
        <div class="card-sb">
            <div class="card-sb-header">
                <div class="card-sb-title"><div class="dot" style="background:#0ea5e9"></div>Kalender Booking (7 Hari ke Depan)</div>
            </div>
            <div class="card-sb-body">
                <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:8px">
                    @for($i=0;$i<7;$i++)
                    @php $d=$today->copy()->addDays($i);$key=$d->format('Y-m-d'); @endphp
                    <div style="background:{{ $i==0 ? 'rgba(0,212,170,.08)' : '#1a2234' }};border:1px solid {{ $i==0 ? 'rgba(0,212,170,.3)' : '#1e2d45' }};border-radius:10px;padding:10px 8px;min-height:90px">
                        <div style="font-size:.65rem;font-weight:700;color:{{ $i==0 ? '#00d4aa' : '#64748b' }};text-align:center;margin-bottom:6px;text-transform:uppercase;letter-spacing:.06em">{{ $d->format('D') }}</div>
                        <div style="font-size:.9rem;font-weight:800;color:{{ $i==0 ? '#00d4aa' : '#e2e8f0' }};text-align:center;margin-bottom:6px">{{ $d->format('d') }}</div>
                        @if(isset($calendarBookings[$key]))
                            @foreach($calendarBookings[$key]->take(2) as $bk)
                            <div style="background:rgba(0,212,170,.12);border:1px solid rgba(0,212,170,.2);border-radius:5px;padding:2px 6px;font-size:.6rem;color:#00d4aa;margin-bottom:3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $bk->field->name }}</div>
                            @endforeach
                            @if($calendarBookings[$key]->count()>2)
                            <div style="font-size:.6rem;color:#64748b;text-align:center">+{{ $calendarBookings[$key]->count()-2 }} lagi</div>
                            @endif
                        @else
                        <div style="text-align:center;color:#334155;font-size:.7rem">–</div>
                        @endif
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
