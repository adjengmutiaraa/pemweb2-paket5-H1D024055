@extends('layouts.app')
@section('title','Tambah Jenis Lapangan')
@section('page-title','Jenis Lapangan')
@section('content')
<div class="page-header fade-in">
    <div><div class="page-title">Tambah Jenis Lapangan</div></div>
    <a href="{{ route('admin.field-types.index') }}" class="btn-ghost"><i class="fas fa-arrow-left"></i>Kembali</a>
</div>
<div class="row justify-content-center"><div class="col-md-5">
<div class="card-sb fade-in-1">
    <div class="card-sb-header"><div class="card-sb-title"><div class="dot"></div>Form Jenis Baru</div></div>
    <div class="card-sb-body">
        <form action="{{ route('admin.field-types.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom:16px">
                <label class="form-label">Nama Jenis *</label>
                <input type="text" name="name" class="form-control {{ $errors->has('name')?'is-invalid':'' }}" value="{{ old('name') }}" placeholder="cth: Futsal, Badminton">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div style="margin-bottom:20px">
                <label class="form-label">Ikon <span style="color:#64748b">(opsional)</span></label>
                <input type="file" name="icon" class="form-control {{ $errors->has('icon')?'is-invalid':'' }}" accept="image/*">
                <div class="form-text">JPG/PNG, maks 2MB</div>
                @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div style="display:flex;gap:10px">
                <button type="submit" class="btn-primary-sb"><i class="fas fa-save"></i>Simpan</button>
                <a href="{{ route('admin.field-types.index') }}" class="btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection
