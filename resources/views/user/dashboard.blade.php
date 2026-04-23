@extends('layouts.app')
@section('title','Dashboard')
@section('page-title','Dashboard')
@section('content')
<div class="page-header fade-in">
    <div>
        <div class="page-title">Halo, {{ explode(' ',auth()->user()->name)[0] }} 👋</div>
        <div class="page-sub">Selamat datang di SportBook — GOR Satria Purwokerto</div>
    </div>
    <a href="{{ route('user.fields.index') }}" class="btn-primary-sb"><i class="fas fa-calendar-plus"></i>Booking Baru</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3 fade-in-1"><div class="stat-card blue"><div class="stat-icon blue"><i class="fas fa-calendar"></i></div><div class="stat-label">Total Booking</div><div class="stat-value">{{ $stats['total'] }}</div></div></div>
    <div class="col-6 col-md-3 fade-in-2"><div class="stat-card green"><div class="stat-icon green"><i class="fas fa-check-circle"></i></div><div class="stat-label">Booking Aktif</div><div class="stat-value">{{ $stats['aktif'] }}</div></div></div>
    <div class="col-6 col-md-3 fade-in-3"><div class="stat-card yellow"><div class="stat-icon yellow"><i class="fas fa-clock"></i></div><div class="stat-label">Menunggu</div><div class="stat-value">{{ $stats['menunggu'] }}</div></div></div>
    <div class="col-6 col-md-3 fade-in-4"><div class="stat-card red"><div class="stat-icon red"><i class="fas fa-flag-checkered"></i></div><div class="stat-label">Selesai</div><div class="stat-value">{{ $stats['selesai'] }}</div></div></div>
</div>

{{-- CTA Banner --}}
<div class="fade-in-2" style="background:linear-gradient(135deg,#0f1e3a,#0a2040);border:1px solid rgba(0,212,170,.2);border-radius:18px;padding:24px 28px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;position:relative;overflow:hidden">
    <div style="position:absolute;top:-30px;right:-30px;width:160px;height:160px;background:radial-gradient(circle,rgba(0,212,170,.08),transparent);pointer-events:none"></div>
    <div>
        <div style="font-size:1.05rem;font-weight:700;color:#fff;margin-bottom:4px">Cari lapangan untuk hari ini</div>
        <div style="font-size:.8rem;color:#64748b">7 lapangan tersedia · Booking langsung, konfirmasi cepat</div>
    </div>
    <a href="{{ route('user.fields.index') }}" class="btn-primary-sb"><i class="fas fa-search"></i>Lihat Lapangan</a>
</div>

<div class="row g-3">
    @if($upcomingBookings->count())
    <div class="col-lg-5 fade-in-3">
        <div class="card-sb h-100">
            <div class="card-sb-header"><div class="card-sb-title"><div class="dot" style="background:#00d4aa"></div>Booking Mendatang</div></div>
            @foreach($upcomingBookings as $b)
            <div style="display:flex;align-items:center;gap:14px;padding:14px 18px;border-bottom:1px solid #1e2d45">
                <div style="text-align:center;min-width:42px">
                    <div style="font-size:1.4rem;font-weight:800;color:#00d4aa;line-height:1">{{ $b->booking_date->format('d') }}</div>
                    <div style="font-size:.65rem;color:#64748b;text-transform:uppercase">{{ $b->booking_date->format('M') }}</div>
                </div>
                <div style="flex:1;min-width:0">
                    <div style="font-weight:600;color:#e2e8f0;font-size:.85rem">{{ $b->field->name }}</div>
                    <div style="font-size:.72rem;color:#64748b"><span class="mono">{{ substr($b->start_time,0,5) }}–{{ substr($b->end_time,0,5) }}</span> · {{ $b->field->fieldType->name }}</div>
                </div>
                <span class="badge-sb badge-green">Aktif</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="{{ $upcomingBookings->count() ? 'col-lg-7' : 'col-12' }} fade-in-4">
        <div class="card-sb">
            <div class="card-sb-header">
                <div class="card-sb-title"><div class="dot" style="background:#0ea5e9"></div>Riwayat Booking</div>
                <a href="{{ route('user.bookings.index') }}" class="btn-ghost" style="padding:5px 11px;font-size:.72rem">Lihat Semua</a>
            </div>
            @forelse($recentBookings as $b)
            @php $cls=['menunggu_pembayaran'=>'yellow','terkonfirmasi'=>'green','selesai'=>'blue','dibatalkan'=>'red','refund'=>'gray'][$b->status]??'gray'; @endphp
            <div style="display:flex;align-items:center;gap:12px;padding:13px 18px;border-bottom:1px solid #1e2d45">
                <div style="width:34px;height:34px;border-radius:9px;background:rgba(14,165,233,.12);display:flex;align-items:center;justify-content:center;color:#0ea5e9;flex-shrink:0"><i class="fas fa-calendar"></i></div>
                <div style="flex:1;min-width:0">
                    <div style="font-weight:600;color:#e2e8f0;font-size:.82rem">{{ $b->field->name }}</div>
                    <div style="font-size:.72rem;color:#64748b"><span class="mono">{{ $b->booking_date->format('d/m/Y') }}</span> · {{ $b->booking_code }}</div>
                </div>
                <div style="text-align:right">
                    <div style="font-weight:700;color:#00d4aa;font-size:.82rem">Rp {{ number_format($b->total_price,0,',','.') }}</div>
                    <span class="badge-sb badge-{{ $cls }}" style="font-size:.65rem">{{ $b->statusLabel() }}</span>
                </div>
            </div>
            @empty
            <div style="padding:36px;text-align:center;color:#64748b">
                <i class="fas fa-calendar fa-2x" style="display:block;margin-bottom:8px;opacity:.3"></i>
                <div style="font-size:.82rem">Belum ada booking.</div>
                <a href="{{ route('user.fields.index') }}" style="color:#00d4aa;font-size:.8rem">Booking sekarang →</a>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
