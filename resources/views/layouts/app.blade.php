<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SportBook') — GOR Satria</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --c-bg:        #0a0f1a;
            --c-surface:   #111827;
            --c-surface2:  #1a2234;
            --c-border:    #1e2d45;
            --c-border2:   #253553;
            --c-accent:    #00d4aa;
            --c-accent2:   #0ea5e9;
            --c-accent3:   #f59e0b;
            --c-danger:    #ef4444;
            --c-text:      #e2e8f0;
            --c-muted:     #64748b;
            --c-muted2:    #94a3b8;
            --c-white:     #ffffff;
            --sidebar-w:   260px;
            --topbar-h:    60px;
            --radius:      12px;
            --radius-lg:   18px;
            --shadow:      0 4px 24px rgba(0,0,0,.4);
            --font:        'Sora', sans-serif;
            --font-mono:   'JetBrains Mono', monospace;
            --transition:  all .2s cubic-bezier(.4,0,.2,1);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: var(--font); background: var(--c-bg); color: var(--c-text); font-size: 14px; line-height: 1.6; min-height: 100vh; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--c-surface); }
        ::-webkit-scrollbar-thumb { background: var(--c-border2); border-radius: 4px; }
        a { color: var(--c-accent2); text-decoration: none; transition: var(--transition); }
        a:hover { color: var(--c-accent); }

        /* SIDEBAR */
        .sidebar { position:fixed; top:0; left:0; width:var(--sidebar-w); height:100vh; background:var(--c-surface); border-right:1px solid var(--c-border); display:flex; flex-direction:column; z-index:200; overflow-y:auto; }
        .sidebar-logo { padding:20px 18px 16px; border-bottom:1px solid var(--c-border); display:flex; align-items:center; gap:12px; }
        .logo-icon { width:36px; height:36px; background:linear-gradient(135deg,var(--c-accent),var(--c-accent2)); border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:16px; color:#000; font-weight:900; flex-shrink:0; box-shadow:0 0 18px rgba(0,212,170,.25); }
        .logo-name { font-size:.95rem; font-weight:800; color:var(--c-white); }
        .logo-sub  { font-size:.65rem; color:var(--c-muted); letter-spacing:.04em; }
        .sidebar-section { padding:14px 18px 4px; font-size:.62rem; font-weight:700; letter-spacing:.12em; text-transform:uppercase; color:var(--c-muted); }
        .nav-item-sb { margin:2px 8px; }
        .nav-link-sb { display:flex; align-items:center; gap:10px; padding:8px 10px; border-radius:var(--radius); color:var(--c-muted2); font-size:.82rem; font-weight:500; transition:var(--transition); border:1px solid transparent; }
        .nav-link-sb:hover { background:var(--c-surface2); color:var(--c-text); }
        .nav-link-sb.active { background:linear-gradient(135deg,rgba(0,212,170,.12),rgba(14,165,233,.08)); color:var(--c-accent); border-color:rgba(0,212,170,.2); }
        .nav-link-sb .icon { width:30px; height:30px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:12px; background:var(--c-surface2); flex-shrink:0; transition:var(--transition); }
        .nav-link-sb.active .icon { background:linear-gradient(135deg,var(--c-accent),var(--c-accent2)); color:#000; }
        .sidebar-footer { margin-top:auto; padding:14px 10px; border-top:1px solid var(--c-border); }
        .user-card { display:flex; align-items:center; gap:10px; padding:10px; background:var(--c-surface2); border-radius:var(--radius); border:1px solid var(--c-border); }
        .user-avatar { width:32px; height:32px; border-radius:8px; background:linear-gradient(135deg,var(--c-accent2),#7c3aed); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:.8rem; color:#fff; flex-shrink:0; }
        .user-name { font-size:.78rem; font-weight:600; color:var(--c-text); }
        .user-role { font-size:.65rem; color:var(--c-muted); }
        .btn-logout { margin-top:8px; width:100%; background:transparent; border:1px solid var(--c-border); color:var(--c-muted2); border-radius:var(--radius); padding:7px; font-size:.75rem; font-family:var(--font); cursor:pointer; transition:var(--transition); display:flex; align-items:center; justify-content:center; gap:6px; }
        .btn-logout:hover { border-color:var(--c-danger); color:var(--c-danger); background:rgba(239,68,68,.08); }

        /* MAIN */
        .main-wrap { margin-left:var(--sidebar-w); min-height:100vh; display:flex; flex-direction:column; }
        .topbar { height:var(--topbar-h); background:var(--c-surface); border-bottom:1px solid var(--c-border); display:flex; align-items:center; justify-content:space-between; padding:0 24px; position:sticky; top:0; z-index:100; }
        .topbar-title { font-size:.9rem; font-weight:700; color:var(--c-white); }
        .topbar-date { font-size:.72rem; color:var(--c-muted); font-family:var(--font-mono); }
        .hamburger { display:none; background:var(--c-surface2); border:1px solid var(--c-border); color:var(--c-muted2); width:34px; height:34px; border-radius:8px; align-items:center; justify-content:center; cursor:pointer; font-size:13px; }
        .content-area { padding:24px; flex:1; }

        /* CARDS */
        .card-sb { background:var(--c-surface); border:1px solid var(--c-border); border-radius:var(--radius-lg); overflow:hidden; }
        .card-sb-header { padding:14px 18px; border-bottom:1px solid var(--c-border); display:flex; align-items:center; justify-content:space-between; gap:12px; }
        .card-sb-title { font-size:.85rem; font-weight:700; color:var(--c-white); display:flex; align-items:center; gap:8px; }
        .card-sb-title .dot { width:6px; height:6px; border-radius:50%; background:var(--c-accent); flex-shrink:0; }
        .card-sb-body { padding:18px; }

        /* STAT CARDS */
        .stat-card { background:var(--c-surface); border:1px solid var(--c-border); border-radius:var(--radius-lg); padding:18px; transition:var(--transition); position:relative; overflow:hidden; }
        .stat-card::before { content:''; position:absolute; top:0; left:0; right:0; height:2px; }
        .stat-card.green::before  { background:linear-gradient(90deg,var(--c-accent),transparent); }
        .stat-card.blue::before   { background:linear-gradient(90deg,var(--c-accent2),transparent); }
        .stat-card.yellow::before { background:linear-gradient(90deg,var(--c-accent3),transparent); }
        .stat-card.red::before    { background:linear-gradient(90deg,var(--c-danger),transparent); }
        .stat-card:hover { border-color:var(--c-border2); transform:translateY(-2px); box-shadow:var(--shadow); }
        .stat-label { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:var(--c-muted); margin-bottom:8px; }
        .stat-value { font-size:1.65rem; font-weight:800; color:var(--c-white); line-height:1; }
        .stat-sub   { font-size:.72rem; color:var(--c-muted); margin-top:5px; }
        .stat-icon  { position:absolute; top:14px; right:14px; width:38px; height:38px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:15px; }
        .stat-icon.green  { background:rgba(0,212,170,.12);  color:var(--c-accent); }
        .stat-icon.blue   { background:rgba(14,165,233,.12); color:var(--c-accent2); }
        .stat-icon.yellow { background:rgba(245,158,11,.12); color:var(--c-accent3); }
        .stat-icon.red    { background:rgba(239,68,68,.12);  color:var(--c-danger); }

        /* TABLES */
        .table-sb { width:100%; border-collapse:collapse; }
        .table-sb thead tr { background:var(--c-surface2); border-bottom:1px solid var(--c-border); }
        .table-sb th { padding:9px 14px; font-size:.67rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:var(--c-muted); white-space:nowrap; }
        .table-sb td { padding:11px 14px; border-bottom:1px solid var(--c-border); font-size:.82rem; color:var(--c-text); vertical-align:middle; }
        .table-sb tbody tr { transition:var(--transition); }
        .table-sb tbody tr:hover { background:var(--c-surface2); }
        .table-sb tbody tr:last-child td { border-bottom:none; }

        /* FORMS */
        .form-label { font-size:.75rem; font-weight:600; color:var(--c-muted2); margin-bottom:5px; letter-spacing:.02em; display:block; }
        .form-control,.form-select { background:var(--c-surface2); border:1px solid var(--c-border); border-radius:10px; color:var(--c-text); font-family:var(--font); font-size:.82rem; padding:9px 13px; transition:var(--transition); width:100%; }
        .form-control:focus,.form-select:focus { background:var(--c-surface2); border-color:var(--c-accent); color:var(--c-text); box-shadow:0 0 0 3px rgba(0,212,170,.12); outline:none; }
        .form-control::placeholder { color:var(--c-muted); }
        .form-control.is-invalid,.form-select.is-invalid { border-color:var(--c-danger); }
        .invalid-feedback { font-size:.72rem; color:var(--c-danger); margin-top:4px; display:block; }
        .form-text { font-size:.7rem; color:var(--c-muted); margin-top:4px; }
        .input-group-text { background:var(--c-surface2); border:1px solid var(--c-border); color:var(--c-muted2); font-family:var(--font); font-size:.82rem; padding:9px 13px; }
        .form-check-input { background-color:var(--c-surface2); border-color:var(--c-border2); }
        .form-check-input:checked { background-color:var(--c-accent); border-color:var(--c-accent); }
        .form-select option { background:var(--c-surface2); color:var(--c-text); }
        textarea.form-control { resize:vertical; }

        /* BUTTONS */
        .btn-primary-sb { background:linear-gradient(135deg,var(--c-accent),var(--c-accent2)); color:#000; border:none; padding:9px 18px; border-radius:10px; font-weight:700; font-size:.82rem; font-family:var(--font); cursor:pointer; transition:var(--transition); display:inline-flex; align-items:center; gap:6px; }
        .btn-primary-sb:hover { opacity:.9; transform:translateY(-1px); box-shadow:0 6px 20px rgba(0,212,170,.3); color:#000; }
        .btn-ghost { background:transparent; border:1px solid var(--c-border); color:var(--c-muted2); padding:8px 14px; border-radius:10px; font-size:.82rem; font-family:var(--font); font-weight:500; cursor:pointer; transition:var(--transition); display:inline-flex; align-items:center; gap:6px; }
        .btn-ghost:hover { border-color:var(--c-border2); color:var(--c-text); background:var(--c-surface2); }
        .btn-danger-sb { background:rgba(239,68,68,.1); border:1px solid rgba(239,68,68,.25); color:var(--c-danger); padding:7px 13px; border-radius:10px; font-size:.78rem; font-family:var(--font); font-weight:600; cursor:pointer; transition:var(--transition); display:inline-flex; align-items:center; gap:5px; }
        .btn-danger-sb:hover { background:rgba(239,68,68,.18); }
        .btn-warning-sb { background:rgba(245,158,11,.1); border:1px solid rgba(245,158,11,.25); color:var(--c-accent3); padding:7px 13px; border-radius:10px; font-size:.78rem; font-family:var(--font); font-weight:600; cursor:pointer; transition:var(--transition); display:inline-flex; align-items:center; gap:5px; }
        .btn-warning-sb:hover { background:rgba(245,158,11,.18); }
        .btn-icon { width:30px; height:30px; display:inline-flex; align-items:center; justify-content:center; border-radius:8px; font-size:11px; transition:var(--transition); border:1px solid var(--c-border); background:var(--c-surface2); color:var(--c-muted2); cursor:pointer; }
        .btn-icon:hover { border-color:var(--c-accent); color:var(--c-accent); }
        .btn-icon.danger:hover { border-color:var(--c-danger); color:var(--c-danger); }

        /* BADGES */
        .badge-sb { display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:20px; font-size:.68rem; font-weight:600; }
        .badge-sb::before { content:''; width:5px; height:5px; border-radius:50%; background:currentColor; flex-shrink:0; }
        .badge-green  { background:rgba(0,212,170,.1);  color:var(--c-accent);  border:1px solid rgba(0,212,170,.2); }
        .badge-blue   { background:rgba(14,165,233,.1); color:var(--c-accent2); border:1px solid rgba(14,165,233,.2); }
        .badge-yellow { background:rgba(245,158,11,.1); color:var(--c-accent3); border:1px solid rgba(245,158,11,.2); }
        .badge-red    { background:rgba(239,68,68,.1);  color:var(--c-danger);  border:1px solid rgba(239,68,68,.2); }
        .badge-gray   { background:rgba(100,116,139,.1);color:var(--c-muted2);  border:1px solid rgba(100,116,139,.2); }
        .badge-type   { background:rgba(14,165,233,.08); color:var(--c-accent2); border:1px solid rgba(14,165,233,.2); padding:2px 9px; border-radius:6px; font-size:.68rem; font-weight:600; }

        /* ALERTS */
        .alert-sb { padding:11px 15px; border-radius:var(--radius); font-size:.82rem; display:flex; align-items:flex-start; gap:9px; margin-bottom:18px; }
        .alert-sb-success { background:rgba(0,212,170,.08); border:1px solid rgba(0,212,170,.2); color:var(--c-accent); }
        .alert-sb-danger  { background:rgba(239,68,68,.08); border:1px solid rgba(239,68,68,.2); color:var(--c-danger); }
        .alert-sb-warning { background:rgba(245,158,11,.08); border:1px solid rgba(245,158,11,.2); color:var(--c-accent3); }
        .alert-sb-info    { background:rgba(14,165,233,.08); border:1px solid rgba(14,165,233,.2); color:var(--c-accent2); }
        .alert-sb .close-btn { margin-left:auto; background:none; border:none; color:inherit; cursor:pointer; font-size:13px; opacity:.7; flex-shrink:0; }
        .alert-sb .close-btn:hover { opacity:1; }

        /* PAGE HEADER */
        .page-header { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:22px; flex-wrap:wrap; gap:10px; }
        .page-title { font-size:1.25rem; font-weight:800; color:var(--c-white); }
        .page-sub   { font-size:.75rem; color:var(--c-muted); margin-top:2px; }

        /* SLOT PICKER */
        .slot-grid { display:flex; flex-wrap:wrap; gap:7px; }
        .slot-btn { width:82px; height:56px; border-radius:10px; font-size:.7rem; font-weight:700; font-family:var(--font); cursor:pointer; border:1px solid transparent; transition:var(--transition); display:flex; flex-direction:column; align-items:center; justify-content:center; gap:2px; }
        .slot-btn .sh { font-size:.82rem; font-family:var(--font-mono); }
        .slot-btn .sp { font-size:.62rem; opacity:.8; }
        .slot-btn.available { background:rgba(0,212,170,.08); border-color:rgba(0,212,170,.2); color:var(--c-accent); }
        .slot-btn.available:hover { background:rgba(0,212,170,.15); border-color:rgba(0,212,170,.5); transform:translateY(-1px); }
        .slot-btn.peak { background:rgba(245,158,11,.08); border-color:rgba(245,158,11,.25); color:var(--c-accent3); }
        .slot-btn.peak:hover { background:rgba(245,158,11,.14); border-color:rgba(245,158,11,.5); transform:translateY(-1px); }
        .slot-btn.booked { background:rgba(239,68,68,.05); border-color:rgba(239,68,68,.15); color:rgba(239,68,68,.4); cursor:not-allowed; }
        .slot-btn.selected { background:linear-gradient(135deg,rgba(0,212,170,.22),rgba(14,165,233,.18)); border-color:var(--c-accent); color:var(--c-accent); box-shadow:0 0 12px rgba(0,212,170,.2); }

        /* PAGINATION */
        .pagination { gap:4px; }
        .page-link { background:var(--c-surface2); border:1px solid var(--c-border); color:var(--c-muted2); border-radius:8px !important; padding:6px 11px; font-size:.75rem; font-family:var(--font); transition:var(--transition); }
        .page-link:hover { background:var(--c-surface); border-color:var(--c-accent); color:var(--c-accent); }
        .page-item.active .page-link { background:var(--c-accent); border-color:var(--c-accent); color:#000; font-weight:700; }
        .page-item.disabled .page-link { opacity:.4; }

        /* UTILS */
        .divider { border:none; border-top:1px solid var(--c-border); margin:18px 0; }
        .text-accent { color:var(--c-accent) !important; }
        .text-accent2 { color:var(--c-accent2) !important; }
        .text-muted-sb { color:var(--c-muted) !important; }
        .mono { font-family:var(--font-mono); }
        .pill { display:inline-flex; align-items:center; background:var(--c-surface2); border:1px solid var(--c-border); border-radius:20px; padding:3px 10px; font-size:.7rem; color:var(--c-muted2); gap:4px; }

        /* RESPONSIVE */
        @media(max-width:768px) {
            .sidebar { transform:translateX(-100%); transition:transform .3s cubic-bezier(.4,0,.2,1); }
            .sidebar.open { transform:translateX(0); box-shadow:0 12px 40px rgba(0,0,0,.6); }
            .main-wrap { margin-left:0; }
            .hamburger { display:flex; }
            .content-area { padding:14px; }
            .overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.65); z-index:199; }
            .overlay.show { display:block; }
        }

        /* ANIMATIONS */
        @keyframes fadeUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
        .fade-in   { animation:fadeUp .35s ease forwards; }
        .fade-in-1 { animation:fadeUp .35s .05s ease both; }
        .fade-in-2 { animation:fadeUp .35s .1s  ease both; }
        .fade-in-3 { animation:fadeUp .35s .15s ease both; }
        .fade-in-4 { animation:fadeUp .35s .2s  ease both; }
        .fade-in-5 { animation:fadeUp .35s .25s ease both; }
    </style>
    @stack('styles')
</head>
<body>
<div class="overlay" id="overlay" onclick="closeSidebar()"></div>

@auth
<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">⚡</div>
        <div>
            <div class="logo-name">SportBook</div>
            <div class="logo-sub">GOR Satria Purwokerto</div>
        </div>
    </div>
    <nav style="flex:1;padding:6px 0">
        @if(auth()->user()->isAdmin())
            <div class="sidebar-section">Main</div>
            <div class="nav-item-sb"><a href="{{ route('admin.dashboard') }}" class="nav-link-sb {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><div class="icon"><i class="fas fa-chart-pie"></i></div>Dashboard</a></div>
            <div class="sidebar-section">Manajemen</div>
            <div class="nav-item-sb"><a href="{{ route('admin.field-types.index') }}" class="nav-link-sb {{ request()->routeIs('admin.field-types.*') ? 'active' : '' }}"><div class="icon"><i class="fas fa-tags"></i></div>Jenis Lapangan</a></div>
            <div class="nav-item-sb"><a href="{{ route('admin.fields.index') }}" class="nav-link-sb {{ request()->routeIs('admin.fields.*') ? 'active' : '' }}"><div class="icon"><i class="fas fa-map-marker-alt"></i></div>Lapangan</a></div>
            <div class="nav-item-sb"><a href="{{ route('admin.bookings.index') }}" class="nav-link-sb {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}"><div class="icon"><i class="fas fa-calendar-check"></i></div>Booking</a></div>
            <div class="sidebar-section">Laporan</div>
            <div class="nav-item-sb"><a href="{{ route('admin.reports.index') }}" class="nav-link-sb {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"><div class="icon"><i class="fas fa-chart-bar"></i></div>Laporan Pendapatan</a></div>
        @else
            <div class="sidebar-section">Menu</div>
            <div class="nav-item-sb"><a href="{{ route('user.dashboard') }}" class="nav-link-sb {{ request()->routeIs('user.dashboard') ? 'active' : '' }}"><div class="icon"><i class="fas fa-home"></i></div>Dashboard</a></div>
            <div class="nav-item-sb"><a href="{{ route('user.fields.index') }}" class="nav-link-sb {{ request()->routeIs('user.fields.*') ? 'active' : '' }}"><div class="icon"><i class="fas fa-search"></i></div>Cari Lapangan</a></div>
            <div class="nav-item-sb"><a href="{{ route('user.bookings.index') }}" class="nav-link-sb {{ request()->routeIs('user.bookings.*') ? 'active' : '' }}"><div class="icon"><i class="fas fa-list-ul"></i></div>Booking Saya</a></div>
            <div class="sidebar-section">Lainnya</div>
            <div class="nav-item-sb"><a href="{{ route('landing') }}" class="nav-link-sb"><div class="icon"><i class="fas fa-globe"></i></div>Katalog Publik</a></div>
        @endif
    </nav>
    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
            <div style="flex:1;min-width:0">
                <div class="user-name text-truncate">{{ auth()->user()->name }}</div>
                <div class="user-role">{{ auth()->user()->isAdmin() ? 'Administrator' : 'Member' }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </form>
    </div>
</aside>
@endauth

<div class="{{ auth()->check() ? 'main-wrap' : '' }}">
    @auth
    <header class="topbar">
        <div style="display:flex;align-items:center;gap:10px">
            <button class="hamburger" onclick="openSidebar()"><i class="fas fa-bars"></i></button>
            <span class="topbar-title">@yield('page-title','SportBook')</span>
        </div>
        <div style="display:flex;align-items:center;gap:10px">
            <span class="topbar-date d-none d-md-block">{{ now()->format('D, d M Y') }}</span>
            <a href="{{ route('landing') }}" class="btn-ghost" style="padding:6px 11px;font-size:.75rem"><i class="fas fa-globe"></i><span class="d-none d-md-inline">Katalog</span></a>
        </div>
    </header>
    @endauth

    <div class="{{ auth()->check() ? 'content-area' : '' }}">
        @if(session('success'))
        <div class="alert-sb alert-sb-success fade-in">
            <i class="fas fa-check-circle" style="margin-top:2px;flex-shrink:0"></i>
            <div>{{ session('success') }}</div>
            <button class="close-btn" onclick="this.closest('.alert-sb').remove()"><i class="fas fa-times"></i></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert-sb alert-sb-danger fade-in">
            <i class="fas fa-exclamation-circle" style="margin-top:2px;flex-shrink:0"></i>
            <div>{{ session('error') }}</div>
            <button class="close-btn" onclick="this.closest('.alert-sb').remove()"><i class="fas fa-times"></i></button>
        </div>
        @endif
        @if($errors->any())
        <div class="alert-sb alert-sb-danger fade-in">
            <i class="fas fa-times-circle" style="margin-top:2px;flex-shrink:0"></i>
            <div><strong>Terjadi kesalahan:</strong><ul style="margin:4px 0 0;padding-left:16px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            <button class="close-btn" onclick="this.closest('.alert-sb').remove()"><i class="fas fa-times"></i></button>
        </div>
        @endif
        @yield('content')
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function openSidebar()  { document.getElementById('sidebar').classList.add('open');  document.getElementById('overlay').classList.add('show'); }
function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('overlay').classList.remove('show'); }
</script>
@stack('scripts')
</body>
</html>
