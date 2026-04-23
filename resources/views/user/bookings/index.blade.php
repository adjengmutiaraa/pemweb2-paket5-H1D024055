@extends('layouts.app')
@section('title','Booking Saya')
@section('page-title','Booking Saya')
@section('content')

<div class="page-header fade-in">
    <div>
        <div class="page-title">Booking Saya</div>
        <div class="page-sub">{{ $bookings->total() }} booking ditemukan</div>
    </div>
    <a href="{{ route('user.fields.index') }}" class="btn-primary-sb"><i class="fas fa-plus"></i>Booking Baru</a>
</div>

{{-- Status Filter --}}
<div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:20px" class="fade-in-1">
    @foreach(['' =>'Semua', 'menunggu_pembayaran'=>'Menunggu', 'terkonfirmasi'=>'Terkonfirmasi', 'selesai'=>'Selesai', 'dibatalkan'=>'Dibatalkan'] as $val=>$label)
    @php $isActive = request('status')===$val; @endphp
    <a href="{{ route('user.bookings.index', $val ? ['status'=>$val] : []) }}"
        style="padding:6px 14px;border-radius:20px;font-size:.78rem;font-weight:600;text-decoration:none;border:1px solid;transition:all .2s;
            {{ $isActive ? 'background:rgba(0,212,170,.15);border-color:rgba(0,212,170,.4);color:#00d4aa' : 'background:transparent;border-color:#1e2d45;color:#64748b' }}">
        {{ $label }}
    </a>
    @endforeach
</div>

@forelse($bookings as $b)
@php $cls=['menunggu_pembayaran'=>'yellow','terkonfirmasi'=>'green','selesai'=>'blue','dibatalkan'=>'red','refund'=>'gray'][$b->status]??'gray'; @endphp
<div class="card-sb mb-2 fade-in-{{ min($loop->iteration,5) }}" style="transition:all .2s" onmouseover="this.style.borderColor='#253553'" onmouseout="this.style.borderColor='#1e2d45'">
    <div style="padding:16px 18px;display:flex;align-items:center;gap:14px;flex-wrap:wrap">
        {{-- Date block --}}
        <div style="text-align:center;min-width:46px;background:#1a2234;border:1px solid #1e2d45;border-radius:10px;padding:8px 6px">
            <div style="font-size:1.3rem;font-weight:800;color:#0ea5e9;line-height:1">{{ $b->booking_date->format('d') }}</div>
            <div style="font-size:.62rem;color:#64748b;text-transform:uppercase;letter-spacing:.04em">{{ $b->booking_date->format('M') }}</div>
            <div style="font-size:.6rem;color:#334155">{{ $b->booking_date->format('Y') }}</div>
        </div>

        {{-- Info --}}
        <div style="flex:1;min-width:150px">
            <div style="font-weight:700;color:#fff;font-size:.9rem">{{ $b->field->name }}
                <span class="badge-type" style="margin-left:6px">{{ $b->field->fieldType->name }}</span>
            </div>
            <div style="font-size:.75rem;color:#64748b;margin-top:2px">
                <span class="mono">{{ substr($b->start_time,0,5) }}–{{ substr($b->end_time,0,5) }}</span>
                · {{ $b->duration_hours }} jam
                · <span class="mono" style="color:#3d5068">{{ $b->booking_code }}</span>
            </div>
        </div>

        {{-- Price --}}
        <div style="text-align:right;min-width:100px">
            <div style="font-weight:800;color:#00d4aa;font-size:.95rem">Rp {{ number_format($b->total_price,0,',','.') }}</div>
            <span class="badge-sb badge-{{ $cls }}" style="margin-top:4px">{{ $b->statusLabel() }}</span>
        </div>

        {{-- Action --}}
        <a href="{{ route('user.bookings.show',$b) }}" class="btn-ghost" style="padding:7px 14px;font-size:.78rem">
            <i class="fas fa-eye"></i>Detail
        </a>
    </div>
</div>
@empty
<div class="card-sb">
    <div style="text-align:center;padding:60px;color:#64748b">
        <i class="fas fa-calendar fa-3x" style="display:block;margin-bottom:14px;opacity:.2"></i>
        <div style="font-size:.9rem;margin-bottom:8px">Belum ada booking</div>
        <a href="{{ route('user.fields.index') }}" class="btn-primary-sb" style="display:inline-flex">
            <i class="fas fa-search"></i>Cari Lapangan
        </a>
    </div>
</div>
@endforelse
<div style="margin-top:16px">{{ $bookings->withQueryString()->links() }}</div>
@endsection
