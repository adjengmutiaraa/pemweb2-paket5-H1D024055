<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportBook — Reservasi Lapangan Olahraga GOR Satria Purwokerto</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --c-bg:      #050d1a;
            --c-s1:      #0a1428;
            --c-s2:      #111f36;
            --c-border:  #1a2d47;
            --c-accent:  #00d4aa;
            --c-blue:    #0ea5e9;
            --c-gold:    #f59e0b;
            --c-text:    #e2e8f0;
            --c-muted:   #64748b;
            --font:      'Sora', sans-serif;
            --mono:      'JetBrains Mono', monospace;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: var(--font); background: var(--c-bg); color: var(--c-text); overflow-x: hidden; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--c-s1); }
        ::-webkit-scrollbar-thumb { background: var(--c-border); border-radius: 4px; }
        a { text-decoration: none; transition: all .2s; }

        /* ── NAV ── */
        nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            padding: 14px 0;
            background: rgba(5,13,26,.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,.04);
            transition: all .3s;
        }
        .nav-inner { max-width: 1200px; margin: 0 auto; padding: 0 24px; display: flex; align-items: center; justify-content: space-between; }
        .brand { display: flex; align-items: center; gap: 10px; }
        .brand-icon { width: 36px; height: 36px; background: linear-gradient(135deg,var(--c-accent),var(--c-blue)); border-radius: 9px; display: flex; align-items: center; justify-content: center; font-weight: 900; color: #000; font-size: 16px; box-shadow: 0 0 18px rgba(0,212,170,.3); }
        .brand-name { font-weight: 800; font-size: .95rem; color: #fff; }
        .nav-actions { display: flex; align-items: center; gap: 8px; }
        .btn-nav-ghost { background: transparent; border: 1px solid var(--c-border); color: var(--c-muted); padding: 7px 16px; border-radius: 8px; font-size: .78rem; font-family: var(--font); font-weight: 600; cursor: pointer; transition: all .2s; }
        .btn-nav-ghost:hover { border-color: var(--c-accent); color: var(--c-accent); }
        .btn-nav-primary { background: linear-gradient(135deg,var(--c-accent),var(--c-blue)); color: #000; padding: 7px 16px; border-radius: 8px; font-size: .78rem; font-family: var(--font); font-weight: 700; cursor: pointer; transition: all .2s; border: none; display: inline-flex; align-items: center; gap: 6px; }
        .btn-nav-primary:hover { opacity: .9; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(0,212,170,.3); color: #000; }

        /* ── HERO ── */
        .hero {
            min-height: 100vh;
            display: flex; align-items: center;
            padding: 100px 0 60px;
            position: relative;
            overflow: hidden;
        }
        .hero-bg {
            position: absolute; inset: 0; z-index: 0;
            background:
                radial-gradient(ellipse 80% 60% at 50% 0%, rgba(0,212,170,.07) 0%, transparent 70%),
                radial-gradient(ellipse 60% 40% at 80% 50%, rgba(14,165,233,.05) 0%, transparent 60%),
                radial-gradient(ellipse 40% 40% at 20% 80%, rgba(124,58,237,.04) 0%, transparent 60%);
        }
        .hero-grid {
            position: absolute; inset: 0; z-index: 0;
            background-image: linear-gradient(rgba(255,255,255,.015) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.015) 1px, transparent 1px);
            background-size: 50px 50px;
            mask-image: radial-gradient(ellipse 80% 80% at 50% 0%, black 30%, transparent 80%);
        }
        .hero-inner { position: relative; z-index: 1; max-width: 1200px; margin: 0 auto; padding: 0 24px; }
        .hero-eyebrow {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(0,212,170,.08); border: 1px solid rgba(0,212,170,.2);
            border-radius: 20px; padding: 5px 14px;
            font-size: .75rem; font-weight: 600; color: var(--c-accent);
            margin-bottom: 22px;
        }
        .hero-eyebrow .dot { width: 6px; height: 6px; border-radius: 50%; background: var(--c-accent); animation: pulse 2s infinite; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }
        .hero h1 {
            font-size: clamp(2.2rem, 5vw, 4rem);
            font-weight: 900;
            color: #fff;
            line-height: 1.1;
            margin-bottom: 20px;
            letter-spacing: -.02em;
        }
        .hero h1 .grad { background: linear-gradient(135deg,var(--c-accent),var(--c-blue)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .hero-lead { font-size: 1rem; color: var(--c-muted); line-height: 1.7; max-width: 520px; margin-bottom: 32px; }
        .hero-actions { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 48px; }
        .btn-hero-primary {
            display: inline-flex; align-items: center; gap: 8px;
            background: linear-gradient(135deg,var(--c-accent),var(--c-blue));
            color: #000; border: none; border-radius: 12px; padding: 13px 24px;
            font-weight: 700; font-size: .9rem; font-family: var(--font); cursor: pointer;
            transition: all .2s;
        }
        .btn-hero-primary:hover { opacity: .9; transform: translateY(-2px); box-shadow: 0 10px 30px rgba(0,212,170,.35); color: #000; }
        .btn-hero-ghost {
            display: inline-flex; align-items: center; gap: 8px;
            background: transparent; border: 1px solid var(--c-border);
            color: var(--c-muted); border-radius: 12px; padding: 12px 22px;
            font-weight: 600; font-size: .9rem; font-family: var(--font); cursor: pointer;
            transition: all .2s;
        }
        .btn-hero-ghost:hover { border-color: var(--c-accent); color: var(--c-accent); }

        /* Hero Stats */
        .hero-stats { display: flex; gap: 24px; flex-wrap: wrap; }
        .hero-stat { }
        .hero-stat .num { font-size: 1.6rem; font-weight: 900; color: #fff; line-height: 1; }
        .hero-stat .lbl { font-size: .72rem; color: var(--c-muted); margin-top: 2px; }
        .hero-divider { width: 1px; background: var(--c-border); align-self: stretch; }

        /* Hero Visual */
        .hero-visual { position: relative; }
        .booking-card-mock {
            background: var(--c-s1);
            border: 1px solid var(--c-border);
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 24px 60px rgba(0,0,0,.6);
        }
        .booking-card-mock .mock-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
        .mock-field-name { font-weight: 700; color: #fff; font-size: .9rem; }
        .mock-status { background: rgba(0,212,170,.12); border: 1px solid rgba(0,212,170,.25); color: var(--c-accent); padding: 3px 10px; border-radius: 20px; font-size: .7rem; font-weight: 600; }
        .slot-row { display: flex; gap: 5px; flex-wrap: wrap; margin-bottom: 12px; }
        .mock-slot { background: rgba(0,212,170,.08); border: 1px solid rgba(0,212,170,.2); color: var(--c-accent); padding: 5px 8px; border-radius: 6px; font-size: .68rem; font-family: var(--mono); font-weight: 500; }
        .mock-slot.peak { background: rgba(245,158,11,.08); border-color: rgba(245,158,11,.2); color: var(--c-gold); }
        .mock-slot.booked { background: rgba(239,68,68,.06); border-color: rgba(239,68,68,.15); color: rgba(239,68,68,.5); }
        .mock-total { display: flex; justify-content: space-between; align-items: center; padding: 10px; background: rgba(0,212,170,.05); border: 1px solid rgba(0,212,170,.15); border-radius: 10px; }
        .mock-total .label { font-size: .75rem; color: var(--c-muted); }
        .mock-total .amount { font-size: 1rem; font-weight: 800; color: var(--c-accent); font-family: var(--mono); }
        .float-badge {
            position: absolute;
            background: var(--c-s1);
            border: 1px solid var(--c-border);
            border-radius: 12px;
            padding: 10px 14px;
            box-shadow: 0 8px 24px rgba(0,0,0,.4);
            font-size: .78rem;
        }
        .float-badge.top-left { top: -16px; left: -20px; }
        .float-badge.bot-right { bottom: -16px; right: -14px; }

        /* ── SECTIONS ── */
        .section { max-width: 1200px; margin: 0 auto; padding: 80px 24px; }
        .section-label { font-size: .7rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: var(--c-accent); margin-bottom: 10px; }
        .section-title { font-size: clamp(1.5rem,3vw,2.2rem); font-weight: 800; color: #fff; line-height: 1.2; margin-bottom: 14px; }
        .section-sub { font-size: .9rem; color: var(--c-muted); line-height: 1.7; max-width: 480px; }

        /* ── JENIS CHIPS ── */
        .type-chip-wrap { display: flex; flex-wrap: wrap; gap: 8px; }
        .type-chip {
            display: flex; align-items: center; gap: 10px;
            background: var(--c-s1); border: 1px solid var(--c-border);
            border-radius: 12px; padding: 10px 16px;
            cursor: pointer; transition: all .2s; color: var(--c-muted);
            font-size: .82rem; font-weight: 600;
        }
        .type-chip:hover, .type-chip.active { border-color: rgba(0,212,170,.4); background: rgba(0,212,170,.06); color: var(--c-accent); }
        .type-chip .icon { width: 30px; height: 30px; border-radius: 8px; background: rgba(255,255,255,.05); display: flex; align-items: center; justify-content: center; font-size: 13px; }
        .type-chip:hover .icon, .type-chip.active .icon { background: rgba(0,212,170,.12); color: var(--c-accent); }
        .type-chip .cnt { background: rgba(255,255,255,.06); border: 1px solid var(--c-border); padding: 1px 8px; border-radius: 12px; font-size: .7rem; }
        .type-chip:hover .cnt, .type-chip.active .cnt { background: rgba(0,212,170,.12); border-color: rgba(0,212,170,.25); color: var(--c-accent); }

        /* ── FILTER BAR ── */
        .filter-bar { background: var(--c-s1); border: 1px solid var(--c-border); border-radius: 14px; padding: 16px 18px; }
        .filter-bar input, .filter-bar select {
            background: var(--c-s2); border: 1px solid var(--c-border); border-radius: 9px;
            color: var(--c-text); font-family: var(--font); font-size: .82rem; padding: 9px 13px;
            width: 100%; transition: all .2s; outline: none;
        }
        .filter-bar input:focus, .filter-bar select:focus { border-color: var(--c-accent); box-shadow: 0 0 0 3px rgba(0,212,170,.1); }
        .filter-bar input::placeholder { color: var(--c-muted); }
        .filter-bar select option { background: var(--c-s2); }
        .filter-label { font-size: .7rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: var(--c-muted); margin-bottom: 5px; display: block; }

        /* ── FIELD CARDS ── */
        .field-card {
            background: var(--c-s1); border: 1px solid var(--c-border); border-radius: 16px;
            overflow: hidden; height: 100%; display: flex; flex-direction: column;
            transition: all .25s;
        }
        .field-card:hover { border-color: rgba(0,212,170,.3); transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,0,0,.5); }
        .field-card .img-wrap { height: 160px; overflow: hidden; position: relative; }
        .field-card .img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
        .field-card:hover .img-wrap img { transform: scale(1.05); }
        .field-card .type-badge { position: absolute; top: 10px; left: 10px; background: rgba(14,165,233,.85); color: #fff; padding: 3px 10px; border-radius: 20px; font-size: .68rem; font-weight: 700; backdrop-filter: blur(4px); }
        .field-card .body { padding: 16px; flex: 1; }
        .field-card .name { font-weight: 700; color: #fff; font-size: .9rem; margin-bottom: 5px; }
        .field-card .desc { font-size: .76rem; color: var(--c-muted); line-height: 1.6; margin-bottom: 12px; }
        .price-tags { display: flex; gap: 6px; flex-wrap: wrap; }
        .ptag { display: flex; align-items: center; gap: 4px; padding: 4px 9px; border-radius: 7px; font-size: .72rem; font-weight: 600; }
        .ptag.off { background: rgba(0,212,170,.08); border: 1px solid rgba(0,212,170,.2); color: var(--c-accent); }
        .ptag.peak { background: rgba(245,158,11,.08); border: 1px solid rgba(245,158,11,.2); color: var(--c-gold); }
        .field-card .footer { padding: 0 16px 16px; }
        .btn-book-card {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            background: linear-gradient(135deg,var(--c-accent),var(--c-blue));
            color: #000; border: none; border-radius: 10px; padding: 10px;
            font-weight: 700; font-size: .82rem; font-family: var(--font); width: 100%;
            transition: all .2s; cursor: pointer;
        }
        .btn-book-card:hover { opacity: .9; color: #000; }
        .btn-book-ghost {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            background: transparent; border: 1px solid var(--c-border);
            color: var(--c-muted); border-radius: 10px; padding: 9px;
            font-weight: 600; font-size: .82rem; font-family: var(--font); width: 100%;
            transition: all .2s;
        }
        .btn-book-ghost:hover { border-color: var(--c-accent); color: var(--c-accent); }

        /* ── INFO CARDS ── */
        .info-card { background: var(--c-s1); border: 1px solid var(--c-border); border-radius: 14px; padding: 20px; }

        /* ── FOOTER ── */
        footer { background: var(--c-s1); border-top: 1px solid var(--c-border); margin-top: 60px; }
        .footer-inner { max-width: 1200px; margin: 0 auto; padding: 40px 24px 20px; }
        footer a { color: var(--c-muted); font-size: .8rem; }
        footer a:hover { color: var(--c-accent); }

        /* ── PAGINATION ── */
        .pagination { gap: 4px; }
        .page-link { background: var(--c-s1); border: 1px solid var(--c-border); color: var(--c-muted); border-radius: 8px !important; padding: 6px 12px; font-size: .78rem; font-family: var(--font); transition: all .2s; }
        .page-link:hover { background: var(--c-s2); border-color: var(--c-accent); color: var(--c-accent); }
        .page-item.active .page-link { background: var(--c-accent); border-color: var(--c-accent); color: #000; font-weight: 700; }
        .page-item.disabled .page-link { opacity: .4; }

        /* DIVIDER */
        .sep { border: none; border-top: 1px solid var(--c-border); }

        /* ALERTS */
        .alert-ok { background: rgba(0,212,170,.06); border: 1px solid rgba(0,212,170,.2); color: var(--c-accent); padding: 10px 14px; border-radius: 10px; font-size: .8rem; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }

        @media(max-width:768px) {
            .hero-visual { display: none; }
            .hero h1 { font-size: 2rem; }
        }
    </style>
</head>
<body>

{{-- NAV --}}
<nav>
    <div class="nav-inner">
        <div class="brand">
            <div class="brand-icon">⚡</div>
            <div>
                <div class="brand-name">SportBook</div>
                <div style="font-size:.6rem;color:var(--c-muted);line-height:1">GOR Satria Purwokerto</div>
            </div>
        </div>
        <div class="nav-actions">
            @auth
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard') }}" class="btn-nav-ghost">
                    <i class="fas fa-tachometer-alt" style="margin-right:6px"></i>Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-nav-ghost">Masuk</a>
                <a href="{{ route('register') }}" class="btn-nav-primary">
                    <i class="fas fa-user-plus"></i>Daftar Gratis
                </a>
            @endauth
        </div>
    </div>
</nav>

{{-- HERO --}}
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-grid"></div>
    <div class="hero-inner w-100">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="hero-eyebrow">
                    <div class="dot"></div>
                    Sistem Booking Online — GOR Satria Purwokerto
                </div>
                <h1>Booking lapangan<br>tanpa ribet, <span class="grad">tanpa antri</span></h1>
                <p class="hero-lead">Pilih lapangan, pilih jam, bayar — selesai dalam 2 menit. Sistem otomatis mencegah double booking dengan database locking real-time.</p>
                <div class="hero-actions">
                    @auth
                        <a href="{{ route('user.fields.index') }}" class="btn-hero-primary"><i class="fas fa-calendar-plus"></i>Booking Sekarang</a>
                        <a href="{{ route(auth()->user()->isAdmin() ? 'admin.dashboard' : 'user.dashboard') }}" class="btn-hero-ghost"><i class="fas fa-home"></i>Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="btn-hero-primary"><i class="fas fa-rocket"></i>Mulai Sekarang — Gratis</a>
                        <a href="{{ route('login') }}" class="btn-hero-ghost"><i class="fas fa-sign-in-alt"></i>Sudah Punya Akun</a>
                    @endauth
                </div>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="num">{{ $totalFields }}</div>
                        <div class="lbl">Lapangan</div>
                    </div>
                    <div class="hero-divider"></div>
                    <div class="hero-stat">
                        <div class="num">{{ $fieldTypes->count() }}</div>
                        <div class="lbl">Jenis Olahraga</div>
                    </div>
                    <div class="hero-divider"></div>
                    <div class="hero-stat">
                        <div class="num">14</div>
                        <div class="lbl">Jam Operasional</div>
                    </div>
                    <div class="hero-divider"></div>
                    <div class="hero-stat">
                        <div class="num">08–22</div>
                        <div class="lbl">Slot Tersedia</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-visual" style="position:relative;padding:20px">
                    <div class="float-badge top-left">
                        <div style="font-size:.68rem;color:var(--c-muted);margin-bottom:2px">STATUS</div>
                        <div style="display:flex;align-items:center;gap:6px;font-size:.8rem;font-weight:700;color:var(--c-accent)">
                            <span style="width:7px;height:7px;border-radius:50%;background:var(--c-accent);animation:pulse 2s infinite"></span>
                            Slot Tersedia
                        </div>
                    </div>
                    <div class="booking-card-mock">
                        <div class="mock-header">
                            <div>
                                <div class="mock-field-name">Futsal A</div>
                                <div style="font-size:.72rem;color:var(--c-muted);font-family:var(--mono)">Sabtu, 26 Apr 2025</div>
                            </div>
                            <div class="mock-status"><i class="fas fa-check-circle" style="margin-right:4px"></i>Terkonfirmasi</div>
                        </div>
                        <div style="font-size:.68rem;font-weight:700;letter-spacing:.08em;color:var(--c-muted);margin-bottom:6px">PILIH SLOT</div>
                        <div class="slot-row">
                            <div class="mock-slot booked">08:00</div>
                            <div class="mock-slot booked">09:00</div>
                            <div class="mock-slot">10:00</div>
                            <div class="mock-slot" style="background:rgba(0,212,170,.2);border-color:var(--c-accent);font-weight:700">11:00</div>
                            <div class="mock-slot" style="background:rgba(0,212,170,.2);border-color:var(--c-accent);font-weight:700">12:00</div>
                            <div class="mock-slot">13:00</div>
                            <div class="mock-slot">14:00</div>
                            <div class="mock-slot">15:00</div>
                            <div class="mock-slot">16:00</div>
                            <div class="mock-slot peak">17:00</div>
                            <div class="mock-slot peak">18:00</div>
                            <div class="mock-slot booked">19:00</div>
                            <div class="mock-slot booked">20:00</div>
                            <div class="mock-slot peak">21:00</div>
                        </div>
                        <div class="mock-total">
                            <div>
                                <div class="label">2 slot dipilih (11:00–13:00)</div>
                                <div style="font-size:.7rem;color:var(--c-muted)">Weekend +20% sudah termasuk</div>
                            </div>
                            <div class="amount">Rp 192.000</div>
                        </div>
                    </div>
                    <div class="float-badge bot-right">
                        <div style="display:flex;align-items:center;gap:8px">
                            <i class="fas fa-shield-alt" style="color:var(--c-accent);font-size:16px"></i>
                            <div>
                                <div style="font-size:.7rem;font-weight:700;color:#fff">Anti Double Booking</div>
                                <div style="font-size:.65rem;color:var(--c-muted)">Database lock aktif</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer>
    <div class="footer-inner">
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="brand" style="margin-bottom:12px">
                    <div class="brand-icon">⚡</div>
                    <div class="brand-name" style="font-size:1rem">SportBook</div>
                </div>
                <p style="font-size:.78rem;color:var(--c-muted);line-height:1.7">Sistem reservasi lapangan olahraga digital untuk GOR Satria Purwokerto. Booking mudah, cepat, anti double booking.</p>
            </div>
            <div class="col-md-3">
                <div style="font-size:.75rem;font-weight:700;color:#fff;margin-bottom:12px;letter-spacing:.06em">LAPANGAN</div>
                @foreach($fieldTypes as $ft)
                <div style="margin-bottom:6px"><a href="{{ route('landing',['field_type_id'=>$ft->id]) }}" style="font-size:.8rem">{{ $ft->name }} <span style="color:var(--c-muted)">({{ $ft->fields_count }})</span></a></div>
                @endforeach
            </div>
            <div class="col-md-3">
                <div style="font-size:.75rem;font-weight:700;color:#fff;margin-bottom:12px;letter-spacing:.06em">JAM OPERASIONAL</div>
                <div style="font-family:var(--mono);font-size:.8rem;color:var(--c-muted)">Setiap hari</div>
                <div style="font-family:var(--mono);font-size:.9rem;color:#fff;font-weight:700;margin-top:2px">08:00 – 22:00</div>
            </div>
            <div class="col-md-2">
                <div style="font-size:.75rem;font-weight:700;color:#fff;margin-bottom:12px;letter-spacing:.06em">AKUN</div>
                @guest
                <div style="margin-bottom:6px"><a href="{{ route('login') }}">Masuk</a></div>
                <div><a href="{{ route('register') }}">Daftar</a></div>
                @else
                <div><a href="{{ auth()->user()->isAdmin()?route('admin.dashboard'):route('user.dashboard') }}">Dashboard</a></div>
                @endguest
            </div>
        </div>
        <hr class="sep">
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;padding-top:16px">
            <div style="font-size:.72rem;color:var(--c-muted)">© {{ date('Y') }} SportBook — GOR Satria Purwokerto</div>
            <div style="font-size:.72rem;color:var(--c-border)">Ujian CPMK-02 Pemrograman Web II · Informatika Unsoed</div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
