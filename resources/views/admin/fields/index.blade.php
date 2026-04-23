@extends('layouts.app')
@section('title','Kelola Lapangan')
@section('page-title','Lapangan')
@section('content')
<div class="page-header fade-in">
    <div><div class="page-title">Kelola Lapangan</div><div class="page-sub">{{ $fields->total() }} lapangan terdaftar</div></div>
    <a href="{{ route('admin.fields.create') }}" class="btn-primary-sb"><i class="fas fa-plus"></i>Tambah Lapangan</a>
</div>
<div class="card-sb mb-3 fade-in-1"><div class="card-sb-body" style="padding:14px 18px">
    <form class="d-flex flex-wrap gap-2 align-items-end">
        <div style="flex:1;min-width:160px"><div class="form-label">Cari Lapangan</div><input type="text" name="search" class="form-control" placeholder="Nama lapangan..." value="{{ request('search') }}"></div>
        <div style="width:160px"><div class="form-label">Jenis</div><select name="field_type_id" class="form-select"><option value="">Semua Jenis</option>@foreach($fieldTypes as $ft)<option value="{{ $ft->id }}" {{ request('field_type_id')==$ft->id?'selected':'' }}>{{ $ft->name }}</option>@endforeach</select></div>
        <div style="width:130px"><div class="form-label">Status</div><select name="status" class="form-select"><option value="">Semua</option><option value="1" {{ request('status')==='1'?'selected':'' }}>Aktif</option><option value="0" {{ request('status')==='0'?'selected':'' }}>Nonaktif</option></select></div>
        <button type="submit" class="btn-primary-sb"><i class="fas fa-filter"></i>Filter</button>
        @if(request()->hasAny(['search','field_type_id','status']))<a href="{{ route('admin.fields.index') }}" class="btn-ghost"><i class="fas fa-times"></i></a>@endif
    </form>
</div></div>
<div class="card-sb fade-in-2">
    <div class="table-responsive">
        <table class="table-sb">
            <thead><tr><th>#</th><th>Lapangan</th><th>Jenis</th><th>Off-Peak</th><th>Peak</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($fields as $f)
            <tr>
                <td style="color:#64748b;font-size:.75rem">{{ $loop->iteration+($fields->currentPage()-1)*$fields->perPage() }}</td>
                <td>
                    <div style="display:flex;align-items:center;gap:10px">
                        @if($f->photo)<img src="{{ asset('storage/'.$f->photo) }}" style="width:38px;height:38px;border-radius:8px;object-fit:cover;border:1px solid #1e2d45">
                        @else<div style="width:38px;height:38px;border-radius:8px;background:#1a2234;border:1px solid #1e2d45;display:flex;align-items:center;justify-content:center;color:#334155"><i class="fas fa-image"></i></div>@endif
                        <div style="font-weight:600;color:#e2e8f0;font-size:.85rem">{{ $f->name }}</div>
                    </div>
                </td>
                <td><span class="badge-type">{{ $f->fieldType->name }}</span></td>
                <td style="color:#00d4aa;font-weight:600;font-family:'JetBrains Mono',monospace;font-size:.78rem">Rp {{ number_format($f->price_offpeak,0,',','.') }}</td>
                <td style="color:#f59e0b;font-weight:600;font-family:'JetBrains Mono',monospace;font-size:.78rem">Rp {{ number_format($f->price_peak,0,',','.') }}</td>
                <td>@if($f->is_active)<span class="badge-sb badge-green">Aktif</span>@else<span class="badge-sb badge-gray">Nonaktif</span>@endif</td>
                <td>
                    <div style="display:flex;gap:5px">
                        <a href="{{ route('admin.fields.edit',$f) }}" class="btn-icon btn-warning-icon" title="Edit"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.fields.destroy',$f) }}" method="POST" onsubmit="return confirm('Hapus lapangan ini?')">@csrf @method('DELETE')<button type="submit" class="btn-icon danger" title="Hapus"><i class="fas fa-trash"></i></button></form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;padding:40px;color:#64748b">Belum ada lapangan</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:14px 18px;border-top:1px solid #1e2d45">{{ $fields->links() }}</div>
</div>
@endsection
