@extends('layouts.app')
@section('title','Detail Booking')
@section('page-title','Detail Booking')
@section('content')

@php $cls=['menunggu_pembayaran'=>'yellow','terkonfirmasi'=>'green','selesai'=>'blue','dibatalkan'=>'red','refund'=>'gray'][$booking->status]??'gray'; @endphp

<div class="page-header fade-in">
    <div>
        <div class="page-title mono" style="font-size:1.1rem">{{ $booking->booking_code }}</div>
        <div style="margin-top:6px;display:flex;align-items:center;gap:8px">
            <span class="badge-sb badge-{{ $cls }}">{{ $booking->statusLabel() }}</span>
            <span style="font-size:.72rem;color:#64748b">Dibuat {{ $booking->created_at->format('d/m/Y H:i') }}</span>
        </div>
    </div>
    <a href="{{ route('user.bookings.index') }}" class="btn-ghost"><i class="fas fa-arrow-left"></i>Kembali</a>
</div>

<div class="row g-3">
    <div class="col-lg-7">
        {{-- Info --}}
        <div class="card-sb mb-3 fade-in-1">
            <div class="card-sb-header"><div class="card-sb-title"><div class="dot"></div>Informasi Booking</div></div>
            <div class="card-sb-body">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px">
                    <div style="background:#1a2234;border:1px solid #1e2d45;border-radius:10px;padding:12px">
                        <div style="font-size:.68rem;color:#64748b;font-weight:700;letter-spacing:.08em;margin-bottom:4px">LAPANGAN</div>
                        <div style="font-weight:700;color:#fff;font-size:.88rem">{{ $booking->field->name }}</div>
                        <span class="badge-type" style="margin-top:4px;display:inline-flex">{{ $booking->field->fieldType->name }}</span>
                    </div>
                    <div style="background:#1a2234;border:1px solid #1e2d45;border-radius:10px;padding:12px">
                        <div style="font-size:.68rem;color:#64748b;font-weight:700;letter-spacing:.08em;margin-bottom:4px">TANGGAL MAIN</div>
                        <div style="font-weight:700;color:#0ea5e9;font-size:.88rem;font-family:'JetBrains Mono',monospace">{{ $booking->booking_date->format('d/m/Y') }}</div>
                        <div style="font-size:.72rem;color:#64748b">{{ $booking->booking_date->translatedFormat('l') }}</div>
                    </div>
                    <div style="background:#1a2234;border:1px solid #1e2d45;border-radius:10px;padding:12px">
                        <div style="font-size:.68rem;color:#64748b;font-weight:700;letter-spacing:.08em;margin-bottom:4px">WAKTU</div>
                        <div style="font-weight:700;color:#00d4aa;font-size:.88rem;font-family:'JetBrains Mono',monospace">{{ substr($booking->start_time,0,5) }} – {{ substr($booking->end_time,0,5) }}</div>
                        <div style="font-size:.72rem;color:#64748b">{{ $booking->duration_hours }} jam</div>
                    </div>
                    <div style="background:#1a2234;border:1px solid #1e2d45;border-radius:10px;padding:12px">
                        <div style="font-size:.68rem;color:#64748b;font-weight:700;letter-spacing:.08em;margin-bottom:4px">STATUS BAYAR</div>
                        <div style="font-weight:800;color:{{ $booking->remaining_payment > 0 ? '#f59e0b' : '#00d4aa' }};font-size:1rem">
                            {{ $booking->payment_type == 'dp' ? 'DP 50%' : 'LUNAS' }}
                        </div>
                        <div style="font-size:.72rem;color:#64748b">Metode Pembayaran</div>
                    </div>
                </div>

                {{-- Slot Breakdown --}}
                <div style="font-size:.75rem;font-weight:700;color:#64748b;letter-spacing:.08em;text-transform:uppercase;margin-bottom:10px">Rincian Slot</div>
                @foreach($booking->slots->sortBy('slot_hour') as $slot)
                {{-- Rincian Pembayaran Lengkap --}}
                <div style="margin-top:12px; padding:12px; background:rgba(13, 21, 38, 0.5); border-radius:10px; border:1px solid #1e2d45">
                    <div style="display:flex;justify-content:space-between;margin-bottom:6px">
                        <span style="color:#94a3b8;font-size:.82rem">Total Sewa</span>
                        <span style="color:#e2e8f0;font-size:.82rem;font-weight:600">Rp {{ number_format($booking->total_price,0,',','.') }}</span>
                    </div>
                    
                    <div style="display:flex;justify-content:space-between;margin-bottom:6px; padding-bottom:6px; border-bottom:1px dashed #1e2d45">
                        <span style="color:#00d4aa;font-size:.82rem;font-weight:700">Sudah Dibayar (Via Transfer)</span>
                        <span style="color:#00d4aa;font-size:.9rem;font-weight:800">Rp {{ number_format($booking->amount_paid,0,',','.') }}</span>
                    </div>

                    @if($booking->remaining_payment > 0)
                    <div style="display:flex;justify-content:space-between;margin-top:6px">
                        <span style="color:#f59e0b;font-size:.82rem;font-weight:700">Sisa Bayar di Lapangan</span>
                        <span style="color:#f59e0b;font-size:.9rem;font-weight:800">Rp {{ number_format($booking->remaining_payment,0,',','.') }}</span>
                    </div>
                    @endif
                </div>
                @endforeach
                <div style="display:flex;justify-content:space-between;padding:10px 12px;margin-top:6px;border-top:1px solid #1e2d45">
                    <span style="font-weight:700;color:#94a3b8;font-size:.82rem">Total</span>
                    <span style="font-weight:800;color:#00d4aa;font-size:.9rem">Rp {{ number_format($booking->total_price,0,',','.') }}</span>
                </div>
            </div>
        </div>

        @if($booking->refund_amount>0)
        <div class="alert-sb alert-sb-info fade-in-2">
            <i class="fas fa-undo" style="flex-shrink:0;margin-top:1px"></i>
            <div>Refund: <strong>Rp {{ number_format($booking->refund_amount,0,',','.') }}</strong>
            @if($booking->cancelled_at) · Dibatalkan {{ $booking->cancelled_at->format('d/m/Y H:i') }}@endif</div>
        </div>
        @endif
    </div>

    <div class="col-lg-5">
        {{-- Upload Bukti Bayar --}}
        @if($booking->status==='menunggu_pembayaran')
        <div class="card-sb mb-3 fade-in-2" style="border-color:rgba(245,158,11,.25)">
            <div class="card-sb-header" style="background:rgba(245,158,11,.05)">
                <div class="card-sb-title">
                    <div class="dot" style="background:#f59e0b"></div>
                    Upload Bukti Bayar (Rp {{ number_format($booking->amount_paid,0,',','.') }})
                </div>
            </div>
            <div class="card-sb-body">
                @if($booking->payment_proof)
                <div style="margin-bottom:14px;text-align:center">
                    <img src="{{ asset('storage/'.$booking->payment_proof) }}" style="max-width:100%;border-radius:10px;max-height:160px;object-fit:contain;border:1px solid #1e2d45">
                    <div style="display:inline-flex;align-items:center;gap:5px;margin-top:8px;background:rgba(0,212,170,.08);border:1px solid rgba(0,212,170,.2);border-radius:8px;padding:4px 10px;font-size:.72rem;color:#00d4aa">
                        <i class="fas fa-check-circle"></i>Sudah diupload — menunggu konfirmasi admin
                    </div>
                </div>
                @endif
                <form action="{{ route('user.bookings.payment',$booking) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div style="margin-bottom:12px">
                        <div class="form-label">{{ $booking->payment_proof ? 'Ganti Bukti Bayar' : 'Upload Bukti Bayar' }}</div>
                        <input type="file" name="payment_proof" class="form-control {{ $errors->has('payment_proof')?'is-invalid':'' }}" accept="image/*" required>
                        <div class="form-text">JPG/PNG/WEBP, maks 2MB</div>
                        @error('payment_proof')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn-warning-sb" style="width:100%;justify-content:center"><i class="fas fa-upload"></i>Upload Sekarang</button>
                </form>
            </div>
        </div>
        @elseif($booking->payment_proof)
        <div class="card-sb mb-3 fade-in-2">
            <div class="card-sb-header"><div class="card-sb-title"><div class="dot" style="background:#00d4aa"></div>Bukti Pembayaran</div></div>
            <div class="card-sb-body" style="text-align:center">
                <img src="{{ asset('storage/'.$booking->payment_proof) }}" style="max-width:100%;border-radius:10px;max-height:200px;object-fit:contain;border:1px solid #1e2d45">
            </div>
        </div>
        @endif

        {{-- Batalkan --}}
        @if(in_array($booking->status,['menunggu_pembayaran','terkonfirmasi']))
        @php
            $bookingStart = \Carbon\Carbon::parse($booking->booking_date->format('Y-m-d').' '.$booking->start_time);
            $hoursLeft    = now()->diffInHours($bookingStart,false);
        @endphp
        <div class="card-sb fade-in-3" style="border-color:rgba(239,68,68,.2)">
            <div class="card-sb-header" style="background:rgba(239,68,68,.04)">
                <div class="card-sb-title"><div class="dot" style="background:#ef4444"></div>Batalkan Booking</div>
            </div>
            <div class="card-sb-body">
                <div style="margin-bottom:14px;padding:10px;border-radius:10px;
                    {{ $hoursLeft>=24 ? 'background:rgba(0,212,170,.06);border:1px solid rgba(0,212,170,.2)' : ($hoursLeft>=12 ? 'background:rgba(245,158,11,.06);border:1px solid rgba(245,158,11,.2)' : 'background:rgba(239,68,68,.06);border:1px solid rgba(239,68,68,.2)') }}">
                    @if($hoursLeft>=24)
                        <div style="font-weight:700;color:#00d4aa;font-size:.82rem"><i class="fas fa-check-circle me-1"></i>Refund 100%</div>
                        <div style="font-size:.72rem;color:#64748b;margin-top:2px">Batal ≥ 24 jam sebelum waktu main</div>
                    @elseif($hoursLeft>=12)
                        <div style="font-weight:700;color:#f59e0b;font-size:.82rem"><i class="fas fa-exclamation-circle me-1"></i>Refund 50%</div>
                        <div style="font-size:.72rem;color:#64748b;margin-top:2px">Batal 12–24 jam sebelum waktu main</div>
                    @elseif($hoursLeft>=0)
                        <div style="font-weight:700;color:#ef4444;font-size:.82rem"><i class="fas fa-times-circle me-1"></i>Tidak Ada Refund</div>
                        <div style="font-size:.72rem;color:#64748b;margin-top:2px">Batal &lt; 12 jam sebelum waktu main</div>
                    @else
                        <div style="font-weight:700;color:#64748b;font-size:.82rem"><i class="fas fa-ban me-1"></i>Tidak Dapat Dibatalkan</div>
                        <div style="font-size:.72rem;color:#64748b;margin-top:2px">Waktu booking sudah lewat</div>
                    @endif
                </div>
                @if($hoursLeft>=0)
                <form action="{{ route('user.bookings.cancel',$booking) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                    @csrf
                    <button type="submit" class="btn-danger-sb" style="width:100%;justify-content:center">
                        <i class="fas fa-ban"></i>Batalkan Booking
                    </button>
                </form>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
