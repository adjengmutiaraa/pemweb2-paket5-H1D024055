@extends('layouts.app')
@section('title','Booking '.$field->name)
@section('page-title','Booking Lapangan')
@section('content')

<div class="page-header fade-in">
    <div>
        <div class="page-title">Booking {{ $field->name }}</div>
        <div class="page-sub"><span class="badge-type">{{ $field->fieldType->name }}</span></div>
    </div>
    <a href="{{ route('user.fields.index') }}" class="btn-ghost"><i class="fas fa-arrow-left"></i>Kembali</a>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card-sb fade-in-1">
            <div class="card-sb-header">
                <div class="card-sb-title"><div class="dot"></div>Pilih Tanggal & Slot</div>
            </div>
            <div class="card-sb-body">

                {{-- Step 1: Tanggal --}}
                <div style="margin-bottom:24px">
                    <div class="form-label" style="margin-bottom:6px;font-size:.8rem">
                        <i class="fas fa-calendar" style="color:#00d4aa;margin-right:6px"></i>PILIH TANGGAL
                    </div>
                    <input type="date" id="bookingDate" class="form-control" style="max-width:200px"
                        value="{{ $date }}" min="{{ now()->format('Y-m-d') }}"
                        onchange="window.location.href='{{ route('user.booking.create',$field) }}?date='+this.value">
                    @php $isWeekend = in_array(\Carbon\Carbon::parse($date)->dayOfWeek,[0,6]); @endphp
                    @if($isWeekend)
                    <div style="display:inline-flex;align-items:center;gap:6px;margin-top:8px;background:rgba(245,158,11,.08);border:1px solid rgba(245,158,11,.25);border-radius:8px;padding:5px 12px;font-size:.75rem;color:#f59e0b">
                        <i class="fas fa-star"></i>Hari Weekend — tarif +20% dari harga normal
                    </div>
                    @endif
                </div>

                {{-- Keterangan Harga --}}
                <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px">
                    <div style="display:flex;align-items:center;gap:8px;background:#1a2234;border:1px solid #1e2d45;border-radius:10px;padding:8px 14px">
                        <div style="width:10px;height:10px;border-radius:3px;background:#00d4aa"></div>
                        <div>
                            <div style="font-size:.68rem;color:#64748b;font-weight:700;letter-spacing:.06em">OFF-PEAK</div>
                            <div style="font-size:.82rem;font-weight:700;color:#e2e8f0">08:00–17:00</div>
                            <div style="font-size:.72rem;color:#00d4aa">Rp {{ number_format($field->price_offpeak,0,',','.') }}{{ $isWeekend ? ' → Rp '.number_format($field->price_offpeak*1.2,0,',','.') : '' }}/jam</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;background:#1a2234;border:1px solid #1e2d45;border-radius:10px;padding:8px 14px">
                        <div style="width:10px;height:10px;border-radius:3px;background:#f59e0b"></div>
                        <div>
                            <div style="font-size:.68rem;color:#64748b;font-weight:700;letter-spacing:.06em">PEAK HOUR</div>
                            <div style="font-size:.82rem;font-weight:700;color:#e2e8f0">17:00–22:00</div>
                            <div style="font-size:.72rem;color:#f59e0b">Rp {{ number_format($field->price_peak,0,',','.') }}{{ $isWeekend ? ' → Rp '.number_format($field->price_peak*1.2,0,',','.') : '' }}/jam</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;background:#1a2234;border:1px solid #1e2d45;border-radius:10px;padding:8px 14px">
                        <div style="width:10px;height:10px;border-radius:3px;background:#ef4444"></div>
                        <div>
                            <div style="font-size:.68rem;color:#64748b;font-weight:700;letter-spacing:.06em">PENUH</div>
                            <div style="font-size:.82rem;font-weight:700;color:#64748b">Tidak tersedia</div>
                        </div>
                    </div>
                </div>

                {{-- Step 2: Slot Grid --}}
                <div class="form-label" style="margin-bottom:10px;font-size:.8rem">
                    <i class="fas fa-clock" style="color:#0ea5e9;margin-right:6px"></i>PILIH SLOT JAM
                    <span style="font-weight:400;color:#64748b;margin-left:6px">(klik untuk memilih, harus berurutan)</span>
                </div>

                @error('hours')
                <div class="alert-sb alert-sb-danger" style="margin-bottom:14px">
                    <i class="fas fa-exclamation-circle" style="flex-shrink:0"></i>
                    <div>{{ $message }}</div>
                </div>
                @enderror

                <form action="{{ route('user.booking.store',$field) }}" method="POST" id="bookingForm">
                    @csrf
                    <input type="hidden" name="booking_date" value="{{ $date }}">

                    <div class="slot-grid" style="margin-bottom:24px">
                        @for($h=8;$h<=21;$h++)
                            @php
                                $isBooked = in_array($h,$bookedSlots);
                                $isPeak   = $h >= 17;
                                $price    = $isPeak ? $field->price_peak : $field->price_offpeak;
                                if($isWeekend) $price *= 1.2;
                                $priceK   = number_format($price/1000,0).'rb';
                            @endphp
                            @if($isBooked)
                                <div class="slot-btn booked">
                                    <span class="sh">{{ sprintf('%02d',$h) }}:00</span>
                                    <span class="sp">Penuh</span>
                                </div>
                            @else
                                <input type="checkbox" name="hours[]" value="{{ $h }}"
                                    id="slot_{{ $h }}" class="d-none slot-checkbox"
                                    onchange="updateSummary()">
                                <label for="slot_{{ $h }}"
                                    class="slot-btn {{ $isPeak ? 'peak' : 'available' }}"
                                    title="Rp {{ number_format($price,0,',','.') }}">
                                    <span class="sh">{{ sprintf('%02d',$h) }}:00</span>
                                    <span class="sp">{{ $priceK }}</span>
                                </label>
                            @endif
                        @endfor
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Metode Pembayaran</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_type" id="full" value="full" checked onchange="updateSummary()">
                            <label class="form-check-label" for="full">
                                Lunas (100%) - <span class="text-success" id="text-price-full">Rp 0</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_type" id="dp" value="dp" onchange="updateSummary()">
                            <label class="form-check-label" for="dp">
                                DP (50%) - <span class="text-primary" id="text-price-dp">Rp 0</span>
                            </label>
                        </div>
                    </div>

                    <div class="card-sb" style="background:#1a2234; border:1px solid #1e2d45; margin-bottom:20px; padding:16px">
                        <div class="form-label" style="margin-bottom:12px; font-size:.8rem">
                            <i class="fas fa-wallet" style="color:#f59e0b; margin-right:6px"></i>METODE PEMBAYARAN
                        </div>
                        <div style="display:flex; gap:15px">
                            <label style="flex:1; cursor:pointer">
                                <input type="radio" name="payment_type" value="full" class="d-none payment-radio" checked onchange="updateSummary()">
                                <div class="payment-box">
                                    <div style="font-weight:700; font-size:.85rem">Lunas (100%)</div>
                                    <div style="font-size:.75rem; color:#64748b">Bayar penuh sekarang</div>
                                </div>
                            </label>
                            <label style="flex:1; cursor:pointer">
                                <input type="radio" name="payment_type" value="dp" class="d-none payment-radio" onchange="updateSummary()">
                                <div class="payment-box">
                                    <div style="font-weight:700; font-size:.85rem">DP (50%)</div>
                                    <div style="font-size:.75rem; color:#64748b">Sisa bayar di lokasi</div>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    {{-- Summary Box --}}
                    <div id="summaryBox" style="display:none;background:#0d1526;border:1px solid rgba(0,212,170,.25);border-radius:14px;padding:18px;margin-bottom:20px">
                        <div style="font-size:.8rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.08em;margin-bottom:12px">Ringkasan Booking</div>
                        <div id="summarySlots"></div>
                        <div id="contiguousWarn" style="display:none;background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.25);border-radius:8px;padding:8px 12px;font-size:.75rem;color:#ef4444;margin-top:10px">
                            <i class="fas fa-exclamation-triangle" style="margin-right:6px"></i>Slot harus berurutan! Contoh: 09:00, 10:00, 11:00 — tidak boleh ada jeda.
                        </div>
                        <div style="border-top:1px solid #1e2d45;margin-top:12px;padding-top:12px;display:flex;justify-content:space-between;align-items:center">
                            <span style="font-size:.82rem;color:#94a3b8">Total Pembayaran</span>
                            <span id="summaryTotal" style="font-size:1.1rem;font-weight:800;color:#00d4aa">Rp 0</span>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary-sb" id="submitBtn" disabled style="width:100%;justify-content:center;padding:12px;font-size:.9rem">
                        <i class="fas fa-calendar-check"></i>Buat Booking
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Sidebar Info --}}
    <div class="col-lg-4">
        <div class="card-sb mb-3 fade-in-2">
            <div class="card-sb-header"><div class="card-sb-title"><div class="dot"></div>Detail Lapangan</div></div>
            <div class="card-sb-body">
                @if($field->photo)
                <img src="{{ asset('storage/'.$field->photo) }}" style="width:100%;height:130px;object-fit:cover;border-radius:10px;margin-bottom:12px;border:1px solid #1e2d45">
                @endif
                <div style="font-weight:700;color:#fff;margin-bottom:4px">{{ $field->name }}</div>
                <span class="badge-type" style="margin-bottom:10px;display:inline-flex">{{ $field->fieldType->name }}</span>
                <div style="font-size:.78rem;color:#64748b;line-height:1.6">{{ $field->description ?: 'Lapangan '.$field->fieldType->name.' berkualitas tinggi dengan fasilitas lengkap.' }}</div>
            </div>
        </div>

        <div class="card-sb fade-in-3" style="border-color:rgba(245,158,11,.2)">
            <div class="card-sb-header" style="background:rgba(245,158,11,.05)">
                <div class="card-sb-title"><div class="dot" style="background:#f59e0b"></div>Kebijakan Refund</div>
            </div>
            <div class="card-sb-body" style="display:flex;flex-direction:column;gap:8px">
                <div style="display:flex;align-items:center;gap:10px;padding:10px;background:rgba(0,212,170,.06);border:1px solid rgba(0,212,170,.15);border-radius:10px">
                    <div style="width:32px;height:32px;border-radius:8px;background:rgba(0,212,170,.12);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="fas fa-check" style="color:#00d4aa;font-size:12px"></i>
                    </div>
                    <div><div style="font-weight:700;color:#00d4aa;font-size:.8rem">Refund 100%</div><div style="font-size:.72rem;color:#64748b">Batal ≥ 24 jam sebelum main</div></div>
                </div>
                <div style="display:flex;align-items:center;gap:10px;padding:10px;background:rgba(245,158,11,.06);border:1px solid rgba(245,158,11,.15);border-radius:10px">
                    <div style="width:32px;height:32px;border-radius:8px;background:rgba(245,158,11,.12);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="fas fa-minus" style="color:#f59e0b;font-size:12px"></i>
                    </div>
                    <div><div style="font-weight:700;color:#f59e0b;font-size:.8rem">Refund 50%</div><div style="font-size:.72rem;color:#64748b">Batal 12–24 jam sebelumnya</div></div>
                </div>
                <div style="display:flex;align-items:center;gap:10px;padding:10px;background:rgba(239,68,68,.06);border:1px solid rgba(239,68,68,.15);border-radius:10px">
                    <div style="width:32px;height:32px;border-radius:8px;background:rgba(239,68,68,.12);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="fas fa-times" style="color:#ef4444;font-size:12px"></i>
                    </div>
                    <div><div style="font-weight:700;color:#ef4444;font-size:.8rem">Tidak Ada Refund</div><div style="font-size:.72rem;color:#64748b">Batal &lt; 12 jam sebelumnya</div></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const slotPrices = {
    @for($h=8;$h<=21;$h++)
        @php $p=$h>=17?$field->price_peak:$field->price_offpeak; if($isWeekend) $p*=1.2; @endphp
        {{ $h }}:{{ $p }},
    @endfor
};

function updateSummary() {
    const checks = [...document.querySelectorAll('.slot-checkbox:checked')];
    const hours  = checks.map(c=>parseInt(c.value)).sort((a,b)=>a-b);

    // Check contiguous
    let ok = true;
    for(let i=1;i<hours.length;i++) { if(hours[i]-hours[i-1]!==1){ok=false;break;} }

    const box    = document.getElementById('summaryBox');
    const warn   = document.getElementById('contiguousWarn');
    const btn    = document.getElementById('submitBtn');
    const slotsDiv = document.getElementById('summarySlots');
    const totalEl  = document.getElementById('summaryTotal');

    if(!hours.length){ box.style.display='none'; btn.disabled=true; btn.innerHTML='<i class="fas fa-calendar-check"></i>Buat Booking'; return; }

    let total=0, html='';
    hours.forEach(h=>{
        const p=slotPrices[h]; total+=p;
        const type=h>=17
            ?'<span style="background:rgba(245,158,11,.12);color:#f59e0b;padding:1px 7px;border-radius:4px;font-size:.65rem">Peak</span>'
            :'<span style="background:rgba(0,212,170,.12);color:#00d4aa;padding:1px 7px;border-radius:4px;font-size:.65rem">Off-Peak</span>';
        html+=`<div style="display:flex;justify-content:space-between;align-items:center;padding:5px 0;border-bottom:1px solid #1a2234;font-size:.8rem">
            <div style="display:flex;align-items:center;gap:7px;color:#94a3b8">
                <span style="font-family:'JetBrains Mono',monospace">${String(h).padStart(2,'0')}:00–${String(h+1).padStart(2,'0')}:00</span>
                ${type}
            </div>
            <span style="font-weight:600;color:#e2e8f0">Rp ${p.toLocaleString('id-ID')}</span>
        </div>`;
    });

    slotsDiv.innerHTML = html;
    totalEl.textContent = 'Rp '+total.toLocaleString('id-ID');
    box.style.display = 'block';
    warn.style.display = ok ? 'none' : 'block';
    btn.disabled = !ok;

    if(ok && hours.length>0){
        btn.innerHTML=`<i class="fas fa-calendar-check"></i>Booking ${hours.length} Slot — Rp ${total.toLocaleString('id-ID')}`;
    } else if(!ok){
        btn.innerHTML='<i class="fas fa-exclamation-triangle"></i>Slot harus berurutan!';
    }
}

document.querySelectorAll('.slot-checkbox').forEach(cb=>{
    cb.addEventListener('change',function(){
        const lbl = document.querySelector(`label[for="${this.id}"]`);
        const isPeak = parseInt(this.value)>=17;
        if(this.checked){
            lbl.className='slot-btn selected';
        } else {
            lbl.className='slot-btn '+(isPeak?'peak':'available');
        }
    });
});
</script>
@endpush
