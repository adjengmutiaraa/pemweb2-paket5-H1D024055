@extends('layouts.app')
@section('title','Tambah Lapangan')
@section('page-title','Tambah Lapangan')
@section('content')
<div class="page-header fade-in">
    <div><div class="page-title">Tambah Lapangan</div><div class="page-sub">Daftarkan lapangan baru ke sistem</div></div>
    <a href="{{ route('admin.fields.index') }}" class="btn-ghost"><i class="fas fa-arrow-left"></i>Kembali</a>
</div>
<div class="row justify-content-center">
<div class="col-lg-7">
<div class="card-sb fade-in-1">
    <div class="card-sb-header"><div class="card-sb-title"><div class="dot"></div>Form Lapangan Baru</div></div>
    <div class="card-sb-body">
        <form action="{{ route('admin.fields.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom:16px">
                <label class="form-label">Jenis Lapangan *</label>
                <select name="field_type_id" class="form-select {{ $errors->has('field_type_id')?'is-invalid':'' }}">
                    <option value="">-- Pilih Jenis --</option>
                    @foreach($fieldTypes as $ft)<option value="{{ $ft->id }}" {{ old('field_type_id')==$ft->id?'selected':'' }}>{{ $ft->name }}</option>@endforeach
                </select>
                @error('field_type_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div style="margin-bottom:16px">
                <label class="form-label">Nama Lapangan *</label>
                <input type="text" name="name" class="form-control {{ $errors->has('name')?'is-invalid':'' }}" value="{{ old('name') }}" placeholder="cth: Futsal A">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
                <div>
                    <label class="form-label">Harga Off-Peak/jam *</label>
                    <div style="display:flex">
                        <span style="background:#1a2234;border:1px solid #1e2d45;border-right:none;border-radius:10px 0 0 10px;padding:9px 12px;color:#64748b;font-size:.78rem;white-space:nowrap">Rp</span>
                        <input type="number" name="price_offpeak" class="form-control {{ $errors->has('price_offpeak')?'is-invalid':'' }}" style="border-radius:0 10px 10px 0" value="{{ old('price_offpeak') }}" placeholder="80000" min="0">
                    </div>
                    <div class="form-text">Jam 08:00–17:00</div>
                    @error('price_offpeak')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label">Harga Peak Hour/jam *</label>
                    <div style="display:flex">
                        <span style="background:#1a2234;border:1px solid #1e2d45;border-right:none;border-radius:10px 0 0 10px;padding:9px 12px;color:#64748b;font-size:.78rem;white-space:nowrap">Rp</span>
                        <input type="number" name="price_peak" class="form-control {{ $errors->has('price_peak')?'is-invalid':'' }}" style="border-radius:0 10px 10px 0" value="{{ old('price_peak') }}" placeholder="120000" min="0">
                    </div>
                    <div class="form-text">Jam 17:00–22:00</div>
                    @error('price_peak')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div style="margin-bottom:16px">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" rows="3" class="form-control {{ $errors->has('description')?'is-invalid':'' }}" placeholder="Deskripsi fasilitas lapangan...">{{ old('description') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div style="margin-bottom:16px">
                <label class="form-label">Foto Lapangan</label>
                <input type="file" name="photo" class="form-control {{ $errors->has('photo')?'is-invalid':'' }}" accept="image/*">
                <div class="form-text">JPG/PNG/WEBP, maks 2MB</div>
                @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div style="margin-bottom:20px;padding:12px;background:#1a2234;border:1px solid #1e2d45;border-radius:10px;display:flex;align-items:center;gap:10px">
                <input type="checkbox" name="is_active" id="is_active" style="width:16px;height:16px;accent-color:#00d4aa" {{ old('is_active',true)?'checked':'' }}>
                <label for="is_active" style="font-size:.82rem;color:#e2e8f0;cursor:pointer;margin:0">Lapangan Aktif (bisa dibooking user)</label>
            </div>
            <div style="display:flex;gap:10px">
                <button type="submit" class="btn-primary-sb"><i class="fas fa-save"></i>Simpan Lapangan</button>
                <a href="{{ route('admin.fields.index') }}" class="btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection
