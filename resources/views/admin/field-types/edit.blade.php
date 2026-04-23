@extends('layouts.app')
@section('title','Edit Jenis Lapangan')
@section('page-title','Jenis Lapangan')
@section('content')
<div class="page-header fade-in">
    <div><div class="page-title">Edit: {{ $fieldType->name }}</div></div>
    <a href="{{ route('admin.field-types.index') }}" class="btn-ghost"><i class="fas fa-arrow-left"></i>Kembali</a>
</div>
<div class="row justify-content-center"><div class="col-md-5">
<div class="card-sb fade-in-1">
    <div class="card-sb-header"><div class="card-sb-title"><div class="dot" style="background:#f59e0b"></div>Edit Jenis Lapangan</div></div>
    <div class="card-sb-body">
        <form action="{{ route('admin.field-types.update',$fieldType) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div style="margin-bottom:16px">
                <label class="form-label">Nama Jenis *</label>
                <input type="text" name="name" class="form-control {{ $errors->has('name')?'is-invalid':'' }}" value="{{ old('name',$fieldType->name) }}">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div style="margin-bottom:20px">
                <label class="form-label">Ikon</label>
                @if($fieldType->icon)
                <div style="margin-bottom:8px;display:flex;align-items:center;gap:10px;background:#1a2234;border:1px solid #1e2d45;border-radius:10px;padding:10px">
                    <img src="{{ asset('storage/'.$fieldType->icon) }}" style="height:40px;border-radius:6px">
                    <span style="font-size:.75rem;color:#64748b">Ikon saat ini</span>
                </div>
                @endif
                <input type="file" name="icon" class="form-control" accept="image/*">
                <div class="form-text">Kosongkan jika tidak ingin mengubah</div>
            </div>
            <div style="display:flex;gap:10px">
                <button type="submit" class="btn-warning-sb"><i class="fas fa-save"></i>Update</button>
                <a href="{{ route('admin.field-types.index') }}" class="btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection
