@extends('layouts.app')
@section('title','Kelola Booking')
@section('page-title','Booking')
@section('content')

<div class="page-header fade-in">
    <div>
        <div class="page-title">Kelola Booking</div>
        <div class="page-sub">{{ $bookings->total() }} total booking ditemukan</div>
    </div>
</div>

<div class="card-sb mb-3 fade-in-1">
    <div class="card-sb-body" style="padding:14px 18px">
        <form class="d-flex flex-wrap gap-2 align-items-end">
            <div style="flex:1;min-width:180px">
                <div class="form-label">Cari</div>
                <input type="text" name="search" class="form-control" placeholder="Kode booking / nama user..." value="{{ request('search') }}">
            </div>
            <div style="width:160px">
                <div class="form-label">Status</div>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    @foreach(['menunggu_pembayaran'=>'Menunggu Pembayaran','terkonfirmasi'=>'Terkonfirmasi','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan','refund'=>'Refund'] as $v=>$l)
                    <option value="{{ $v }}" {{ request('status')==$v?'selected':'' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <div style="width:150px">
                <div class="form-label">Tanggal</div>
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
            <button type="submit" class="btn-primary-sb"><i class="fas fa-filter"></i>Filter</button>
            @if(request()->hasAny(['search','status','date']))
            <a href="{{ route('admin.bookings.index') }}" class="btn-ghost"><i class="fas fa-times"></i></a>
            @endif
        </form>
    </div>
</div>

<div class="card-sb fade-in-2">
    <div class="table-responsive">
        <table class="table-sb">
            <thead><tr>
                <th>Kode Booking</th><th>User</th><th>Lapangan</th><th>Tanggal</th><th>Waktu</th><th>Total</th><th>Status</th><th>Bukti</th><th>Aksi</th>
            </tr></thead>
            <tbody>
            @forelse($bookings as $b)
            <tr>
                <td><span class="mono" style="font-size:.78rem;color:#0ea5e9">{{ $b->booking_code }}</span></td>
                <td>
                    <div style="display:flex;align-items:center;gap:8px">
                        <div style="width:28px;height:28px;border-radius:7px;background:linear-gradient(135deg,#0ea5e9,#7c3aed);display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:700;color:#fff;flex-shrink:0">{{ strtoupper(substr($b->user->name,0,1)) }}</div>
                        <div style="font-size:.8rem;color:#e2e8f0">{{ $b->user->name }}</div>
                    </div>
                </td>
                <td>
                    <div style="font-size:.82rem;color:#e2e8f0">{{ $b->field->name }}</div>
                    <span class="badge-type">{{ $b->field->fieldType->name }}</span>
                </td>
                <td><span class="mono" style="font-size:.78rem">{{ $b->booking_date->format('d/m/Y') }}</span></td>
                <td><span class="mono" style="font-size:.78rem;color:#94a3b8">{{ substr($b->start_time,0,5) }}–{{ substr($b->end_time,0,5) }}</span></td>
                <td style="font-weight:700;color:#00d4aa">Rp {{ number_format($b->total_price,0,',','.') }}</td>
                <td>
                    @php $cls=['menunggu_pembayaran'=>'yellow','terkonfirmasi'=>'green','selesai'=>'blue','dibatalkan'=>'red','refund'=>'gray'][$b->status]??'gray'; @endphp
                    <span class="badge-sb badge-{{ $cls }}">{{ $b->statusLabel() }}</span>
                </td>
                <td>
                    @if($b->payment_proof)
                    <a href="{{ asset('storage/'.$b->payment_proof) }}" target="_blank" class="btn-icon" style="color:#00d4aa;border-color:rgba(0,212,170,.3)"><i class="fas fa-image"></i></a>
                    @else<span style="color:#334155;font-size:.75rem">–</span>@endif
                </td>
                <td><a href="{{ route('admin.bookings.show',$b) }}" class="btn-icon"><i class="fas fa-eye"></i></a></td>
            </tr>
            @empty
            <tr><td colspan="9" style="text-align:center;padding:40px;color:#64748b"><i class="fas fa-calendar-times fa-2x" style="display:block;margin-bottom:8px;opacity:.4"></i>Tidak ada booking ditemukan</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:14px 18px;border-top:1px solid #1e2d45">{{ $bookings->links() }}</div>
</div>
@endsection
