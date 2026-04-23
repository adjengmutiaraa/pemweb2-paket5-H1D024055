@extends('layouts.app')
@section('title','Cari Lapangan')
@section('page-title','Katalog Lapangan')
@section('content')
<div class="page-header fade-in">
    <div><div class="page-title">Cari Lapangan</div><div class="page-sub">{{ $fields->total() }} lapangan tersedia</div></div>
</div>

<div class="card-sb mb-4 fade-in-1">
    <div class="card-sb-body" style="padding:14px 18px">
        <form class="d-flex flex-wrap gap-2 align-items-end">
            <div style="flex:1;min-width:160px"><div class="form-label">Cari Lapangan</div><input type="text" name="search" class="form-control" placeholder="Nama lapangan..." value="{{ request('search') }}"></div>
            <div style="width:160px"><div class="form-label">Jenis Olahraga</div><select name="field_type_id" class="form-select"><option value="">Semua Jenis</option>@foreach($fieldTypes as $ft)<option value="{{ $ft->id }}" {{ request('field_type_id')==$ft->id?'selected':'' }}>{{ $ft->name }}</option>@endforeach</select></div>
            <button type="submit" class="btn-primary-sb"><i class="fas fa-search"></i>Filter</button>
            @if(request()->hasAny(['search','field_type_id']))<a href="{{ route('user.fields.index') }}" class="btn-ghost"><i class="fas fa-times"></i></a>@endif
        </form>
    </div>
</div>

<div class="row g-3">
@forelse($fields as $field)
<div class="col-md-6 col-lg-4 fade-in-{{ min($loop->iteration,5) }}">
    <div style="background:#111827;border:1px solid #1e2d45;border-radius:18px;overflow:hidden;height:100%;display:flex;flex-direction:column;transition:all .2s;cursor:pointer" onmouseover="this.style.borderColor='rgba(0,212,170,.3)';this.style.transform='translateY(-3px)';this.style.boxShadow='0 12px 36px rgba(0,0,0,.4)'" onmouseout="this.style.borderColor='#1e2d45';this.style.transform='';this.style.boxShadow=''">
        <div style="height:155px;overflow:hidden;position:relative">
            @if($field->photo)
            <img src="{{ asset('storage/'.$field->photo) }}" style="width:100%;height:100%;object-fit:cover">
            @else
            @php $palettes=['Futsal'=>['#0f1e3a','#00d4aa'],'Badminton'=>['#0a2010','#22c55e'],'Basket'=>['#1a1000','#f59e0b']]; $pal=$palettes[$field->fieldType->name]??['#1a1a2e','#0ea5e9']; @endphp
            <div style="background:linear-gradient(135deg,{{ $pal[0] }},{{ $pal[1] }}22);width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px">
                <div style="width:52px;height:52px;border-radius:14px;background:{{ $pal[1] }}22;border:1px solid {{ $pal[1] }}44;display:flex;align-items:center;justify-content:center">
                    @if($field->fieldType->name=='Futsal')<i class="fas fa-futbol" style="font-size:22px;color:{{ $pal[1] }}"></i>
                    @elseif($field->fieldType->name=='Basket')<i class="fas fa-basketball-ball" style="font-size:22px;color:{{ $pal[1] }}"></i>
                    @else<i class="fas fa-table-tennis" style="font-size:22px;color:{{ $pal[1] }}"></i>@endif
                </div>
                <span style="font-size:.72rem;font-weight:600;color:{{ $pal[1] }};opacity:.8">{{ $field->fieldType->name }}</span>
            </div>
            @endif
            <div style="position:absolute;top:10px;left:10px;background:rgba(14,165,233,.9);color:#fff;padding:2px 10px;border-radius:20px;font-size:.68rem;font-weight:700;backdrop-filter:blur(4px)">{{ $field->fieldType->name }}</div>
        </div>
        <div style="padding:16px;flex:1">
            <div style="font-weight:700;color:#fff;font-size:.95rem;margin-bottom:6px">{{ $field->name }}</div>
            <div style="font-size:.77rem;color:#64748b;margin-bottom:14px;line-height:1.5">{{ $field->description ? Str::limit($field->description,80) : 'Lapangan '.$field->fieldType->name.' berkualitas tinggi.' }}</div>
            <div style="display:flex;gap:6px;flex-wrap:wrap">
                <div style="background:rgba(0,212,170,.08);border:1px solid rgba(0,212,170,.2);border-radius:8px;padding:5px 10px;font-size:.72rem;font-weight:600;color:#00d4aa"><i class="fas fa-sun" style="margin-right:4px;opacity:.8"></i>Rp {{ number_format($field->price_offpeak/1000,0) }}rb/jam</div>
                <div style="background:rgba(245,158,11,.08);border:1px solid rgba(245,158,11,.2);border-radius:8px;padding:5px 10px;font-size:.72rem;font-weight:600;color:#f59e0b"><i class="fas fa-moon" style="margin-right:4px;opacity:.8"></i>Rp {{ number_format($field->price_peak/1000,0) }}rb/jam</div>
            </div>
        </div>
        <div style="padding:0 16px 16px">
            <a href="{{ route('user.booking.create',$field) }}" style="display:flex;align-items:center;justify-content:center;gap:8px;background:linear-gradient(135deg,#00d4aa,#0ea5e9);color:#000;border:none;border-radius:10px;padding:10px;font-weight:700;font-size:.82rem;font-family:'Sora',sans-serif;text-decoration:none;transition:all .2s" onmouseover="this.style.opacity='.9'" onmouseout="this.style.opacity='1'">
                <i class="fas fa-calendar-plus"></i>Booking Sekarang
            </a>
        </div>
    </div>
</div>
@empty
<div class="col-12"><div style="text-align:center;padding:60px;color:#64748b"><i class="fas fa-search fa-3x" style="display:block;margin-bottom:12px;opacity:.3"></i><div>Tidak ada lapangan ditemukan.</div><a href="{{ route('user.fields.index') }}" style="color:#00d4aa;font-size:.82rem">Reset filter</a></div></div>
@endforelse
</div>
<div style="margin-top:20px">{{ $fields->withQueryString()->links() }}</div>
@endsection
