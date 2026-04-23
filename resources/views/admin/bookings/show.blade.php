@extends('layouts.app')
@section('title','Detail Booking')
@section('page-title','Detail Booking')
@section('content')

<div class="page-header fade-in">
    <div>
        <div class="page-title">{{ $booking->booking_code }}</div>
        @php $cls=['menunggu_pembayaran'=>'yellow','terkonfirmasi'=>'green','selesai'=>'blue','dibatalkan'=>'red','refund'=>'gray'][$booking->status]??'gray'; @endphp
        <span class="badge-sb badge-{{ $cls }}" style="margin-top:6px;display:inline-flex">{{ $booking->statusLabel() }}</span>
    </div>
    <a href="{{ route('admin.bookings.index') }}" class="btn-ghost"><i class="fas fa-arrow-left"></i>Kembali</a>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        {{-- Info Utama --}}
        <div class="card-sb mb-3 fade-in-1">
            <div class="card-sb-header">
                <div class="card-sb-title"><div class="dot"></div>Informasi Booking</div>
                <span class="mono" style="font-size:.72rem;color:#64748b">Dibuat {{ $booking->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="card-sb-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-label">User</div>
                        <div style="display:flex;align-items:center;gap:10px;background:#1a2234;border:1px solid #1e2d45;border-radius:10px;padding:10px 14px">
                            <div style="width:34px;height:34px;border-radius:9px;background:linear-gradient(135deg,#0ea5e9,#7c3aed);display:flex;align-items:center;justify-content:center;font-weight:700;color:#fff;flex-shrink:0">{{ strtoupper(substr($booking->user->name,0,1)) }}</div>
                            <div>
                                <div style="font-weight:600;color:#e2e8f0;font-size:.85rem">{{ $booking->user->name }}</div>
                                <div style="font-size:.72rem;color:#64748b">{{ $booking->user->email }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-label">Lapangan</div>
                        <div style="background:#1a2234;border:1px solid #1e2d45;border-radius:10px;padding:10px 14px">
                            <div style="font-weight:600;color:#e2e8f0;font-size:.85rem">{{ $booking->field->name }}</div>
                            <span class="badge-type">{{ $booking->field->fieldType->name }}</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-label">Tanggal</div>
                        <div style="background:#1a2234;border:1px solid #1e2d45;border-radius:10px;padding:10px 14px;text-align:center">
                            <div class="mono" style="font-size:.85rem;color:#0ea5e9;font-weight:600">{{ $booking->booking_date->format('d/m/Y') }}</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-label">Waktu</div>
                        <div style="background:#1a2234;border:1px solid #1e2d45;border-radius:10px;padding:10px 14px;text-align:center">
                            <div class="mono" style="font-size:.82rem;color:#00d4aa;font-weight:600">{{ substr($booking->start_time,0,5) }}–{{ substr($booking->end_time,0,5) }}</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-label">Durasi</div>
                        <div style="background:#1a2234;border:1px solid #1e2d45;border-radius:10px;padding:10px 14px;text-align:center">
                            <div style="font-size:.85rem;color:#f59e0b;font-weight:700">{{ $booking->duration_hours }} jam</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Slot Breakdown --}}
        <div class="card-sb mb-3 fade-in-2">
            <div class="card-sb-header">
                <div class="card-sb-title"><div class="dot" style="background:#0ea5e9"></div>Rincian Slot & Harga</div>
                <span style="font-weight:700;color:#00d4aa">Total: Rp {{ number_format($booking->total_price,0,',','.') }}</span>
            </div>
            <table class="table-sb">
                <thead><tr><th>Slot Waktu</th><th>Jenis</th><th>Harga</th></tr></thead>
                <tbody>
                @foreach($booking->slots->sortBy('slot_hour') as $slot)
                <tr>
                    <td><span class="mono">{{ sprintf('%02d:00 – %02d:00',$slot->slot_hour,$slot->slot_hour+1) }}</span></td>
                    <td>@if($slot->slot_hour>=17)<span class="badge-sb badge-yellow">Peak Hour</span>@else<span class="badge-sb badge-green">Off-Peak</span>@endif</td>
                    <td style="font-weight:600;color:#e2e8f0">Rp {{ number_format($slot->price,0,',','.') }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        @if($booking->refund_amount>0)
        <div class="alert-sb alert-sb-info fade-in-3">
            <i class="fas fa-undo" style="margin-top:2px;flex-shrink:0"></i>
            <div>Refund: <strong>Rp {{ number_format($booking->refund_amount,0,',','.') }}</strong>
            @if($booking->cancelled_at) · Dibatalkan {{ $booking->cancelled_at->format('d/m/Y H:i') }}@endif</div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        {{-- Bukti Bayar --}}
        <div class="card-sb mb-3 fade-in-1">
            <div class="card-sb-header"><div class="card-sb-title"><div class="dot" style="background:#00d4aa"></div>Bukti Pembayaran</div></div>
            <div class="card-sb-body" style="text-align:center">
                @if($booking->payment_proof)
                <img src="{{ asset('storage/'.$booking->payment_proof) }}" style="max-width:100%;border-radius:10px;max-height:200px;object-fit:contain;border:1px solid #1e2d45">
                <a href="{{ asset('storage/'.$booking->payment_proof) }}" target="_blank" class="btn-ghost" style="margin-top:10px;justify-content:center;width:100%"><i class="fas fa-external-link-alt"></i>Buka Full</a>
                @else
                <div style="padding:28px;color:#64748b"><i class="fas fa-image fa-2x" style="display:block;margin-bottom:8px;opacity:.4"></i><div style="font-size:.8rem">Belum ada bukti pembayaran</div></div>
                @endif
            </div>
        </div>

        {{-- Update Status --}}
        <div class="card-sb fade-in-2">
            <div class="card-sb-header"><div class="card-sb-title"><div class="dot" style="background:#f59e0b"></div>Update Status</div></div>
            <div class="card-sb-body">
                <form action="{{ route('admin.bookings.update',$booking) }}" method="POST">
                    @csrf @method('PATCH')
                    <div style="margin-bottom:14px">
                        <div class="form-label">Status Booking</div>
                        <select name="status" class="form-select">
                            @foreach(['menunggu_pembayaran'=>'Menunggu Pembayaran','terkonfirmasi'=>'Terkonfirmasi','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan','refund'=>'Refund'] as $v=>$l)
                            <option value="{{ $v }}" {{ $booking->status==$v?'selected':'' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn-warning-sb" style="width:100%;justify-content:center"><i class="fas fa-save"></i>Simpan Status</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
