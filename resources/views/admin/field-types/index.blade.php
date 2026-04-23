@extends('layouts.app')
@section('title','Jenis Lapangan')
@section('page-title','Jenis Lapangan')
@section('content')
<div class="page-header fade-in">
    <div><div class="page-title">Jenis Lapangan</div><div class="page-sub">{{ $fieldTypes->total() }} jenis terdaftar</div></div>
    <a href="{{ route('admin.field-types.create') }}" class="btn-primary-sb"><i class="fas fa-plus"></i>Tambah Jenis</a>
</div>
<div class="card-sb mb-3 fade-in-1"><div class="card-sb-body" style="padding:14px 18px">
    <form class="d-flex gap-2 align-items-end">
        <div style="flex:1"><div class="form-label">Cari</div><input type="text" name="search" class="form-control" placeholder="Nama jenis lapangan..." value="{{ request('search') }}"></div>
        <button type="submit" class="btn-primary-sb"><i class="fas fa-search"></i>Cari</button>
        @if(request('search'))<a href="{{ route('admin.field-types.index') }}" class="btn-ghost"><i class="fas fa-times"></i></a>@endif
    </form>
</div></div>
<div class="card-sb fade-in-2">
    <div class="table-responsive">
        <table class="table-sb">
            <thead><tr><th>#</th><th>Nama</th><th>Ikon</th><th>Jumlah Lapangan</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($fieldTypes as $ft)
            <tr>
                <td style="color:#64748b;font-size:.75rem">{{ $loop->iteration+($fieldTypes->currentPage()-1)*$fieldTypes->perPage() }}</td>
                <td style="font-weight:600;color:#e2e8f0">{{ $ft->name }}</td>
                <td>@if($ft->icon)<img src="{{ asset('storage/'.$ft->icon) }}" style="width:36px;height:36px;border-radius:8px;object-fit:cover;border:1px solid #1e2d45">@else<div style="width:36px;height:36px;border-radius:8px;background:#1a2234;border:1px solid #1e2d45;display:flex;align-items:center;justify-content:center;color:#334155;font-size:12px"><i class="fas fa-image"></i></div>@endif</td>
                <td><span class="badge-sb badge-blue">{{ $ft->fields_count }} lapangan</span></td>
                <td>
                    <div style="display:flex;gap:5px">
                        <a href="{{ route('admin.field-types.edit',$ft) }}" class="btn-icon" title="Edit"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.field-types.destroy',$ft) }}" method="POST" onsubmit="return confirm('Hapus jenis lapangan ini?')">@csrf @method('DELETE')<button type="submit" class="btn-icon danger" title="Hapus"><i class="fas fa-trash"></i></button></form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;padding:40px;color:#64748b">Belum ada data</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:14px 18px;border-top:1px solid #1e2d45">{{ $fieldTypes->links() }}</div>
</div>
@endsection
