<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SportBook</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Sora',sans-serif;background:#0a0f1a;color:#e2e8f0;min-height:100vh;display:flex}
        .auth-left{flex:1;background:linear-gradient(135deg,#0f1e3a 0%,#0a1628 40%,#061020 100%);padding:60px;display:flex;flex-direction:column;justify-content:space-between;position:relative;overflow:hidden}
        .auth-left::before{content:'';position:absolute;top:-100px;left:-100px;width:500px;height:500px;background:radial-gradient(circle,rgba(0,212,170,.08),transparent 60%);pointer-events:none}
        .auth-left::after{content:'';position:absolute;bottom:-80px;right:-60px;width:350px;height:350px;background:radial-gradient(circle,rgba(14,165,233,.06),transparent 60%);pointer-events:none}
        .brand{display:flex;align-items:center;gap:12px}
        .brand-icon{width:40px;height:40px;background:linear-gradient(135deg,#00d4aa,#0ea5e9);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:900;color:#000;box-shadow:0 0 20px rgba(0,212,170,.3)}
        .brand-name{font-size:1.1rem;font-weight:800;color:#fff}
        .auth-hero h1{font-size:clamp(1.8rem,3vw,2.4rem);font-weight:800;color:#fff;line-height:1.2;margin-bottom:16px}
        .auth-hero h1 span{background:linear-gradient(135deg,#00d4aa,#0ea5e9);-webkit-background-clip:text;-webkit-text-fill-color:transparent}
        .auth-hero p{color:#64748b;font-size:.9rem;line-height:1.7}
        .feature-list{display:flex;flex-direction:column;gap:14px}
        .feature-item{display:flex;align-items:center;gap:12px;padding:12px 16px;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.06);border-radius:10px}
        .feature-icon{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0}
        .feature-item p{font-size:.78rem;color:#94a3b8;margin:0}
        .feature-item strong{font-size:.82rem;color:#e2e8f0;display:block}
        .auth-right{width:480px;display:flex;align-items:center;justify-content:center;padding:40px;background:#0d1526;border-left:1px solid #1e2d45}
        .auth-form-wrap{width:100%;max-width:380px}
        .auth-form-wrap h2{font-size:1.4rem;font-weight:800;color:#fff;margin-bottom:6px}
        .auth-form-wrap .sub{font-size:.82rem;color:#64748b;margin-bottom:28px}
        .form-group{margin-bottom:16px}
        label{font-size:.75rem;font-weight:600;color:#94a3b8;display:block;margin-bottom:5px;letter-spacing:.02em}
        .input-wrap{position:relative}
        .input-wrap i{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#64748b;font-size:13px}
        input{width:100%;background:#1a2234;border:1px solid #1e2d45;border-radius:10px;color:#e2e8f0;font-family:'Sora',sans-serif;font-size:.82rem;padding:10px 13px 10px 38px;transition:all .2s;outline:none}
        input:focus{border-color:#00d4aa;box-shadow:0 0 0 3px rgba(0,212,170,.12)}
        input::placeholder{color:#3d5068}
        .input-err{border-color:#ef4444!important}
        .err-msg{font-size:.72rem;color:#ef4444;margin-top:4px}
        .btn-login{width:100%;background:linear-gradient(135deg,#00d4aa,#0ea5e9);color:#000;border:none;border-radius:10px;padding:11px;font-weight:700;font-size:.875rem;font-family:'Sora',sans-serif;cursor:pointer;transition:all .2s;margin-top:8px}
        .btn-login:hover{opacity:.9;transform:translateY(-1px);box-shadow:0 8px 24px rgba(0,212,170,.35)}
        .link-alt{text-align:center;margin-top:16px;font-size:.78rem;color:#64748b}
        .link-alt a{color:#00d4aa;font-weight:600}
        @media(max-width:768px){.auth-left{display:none}.auth-right{width:100%;border-left:none;background:#0a0f1a}}
    </style>
</head>
<body>
<div class="auth-left">
    <div class="brand">
        <div class="brand-icon">⚡</div>
        <div><div class="brand-name">SportBook</div><div style="font-size:.65rem;color:#64748b">GOR Satria Purwokerto</div></div>
    </div>
    <div class="auth-hero">
        <h1>Booking lapangan olahraga <span>lebih cepat</span> dari sebelumnya</h1>
        <p style="margin-bottom:28px">Tidak perlu telepon. Pilih slot, bayar, main. Sistem anti double-booking dengan konfirmasi real-time.</p>
        <div class="feature-list">
            <div class="feature-item">
                <div class="feature-icon" style="background:rgba(0,212,170,.12);color:#00d4aa"><i class="fas fa-bolt"></i></div>
                <div><strong>Booking Instan</strong><p>Pilih slot jam 08:00–22:00, langsung terkonfirmasi</p></div>
            </div>
            <div class="feature-item">
                <div class="feature-icon" style="background:rgba(14,165,233,.12);color:#0ea5e9"><i class="fas fa-shield-alt"></i></div>
                <div><strong>Anti Double Booking</strong><p>Sistem locking database mencegah konflik slot</p></div>
            </div>
            <div class="feature-item">
                <div class="feature-icon" style="background:rgba(245,158,11,.12);color:#f59e0b"><i class="fas fa-undo"></i></div>
                <div><strong>Refund Otomatis</strong><p>Pembatalan ≥24 jam mendapat refund 100%</p></div>
            </div>
        </div>
    </div>
    <div style="font-size:.72rem;color:#334155">© {{ date('Y') }} SportBook — Ujian CPMK-02 Pemrograman Web II</div>
</div>

<div class="auth-right">
    <div class="auth-form-wrap">
        <h2>Selamat datang 👋</h2>
        <p class="sub">Masuk ke akun SportBook Anda. <a href="{{ route('register') }}" style="color:#00d4aa;font-weight:600">Belum punya akun?</a></p>

        @if(session('status'))
            <div class="alert-success"><i class="fas fa-check-circle me-2"></i>{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label>Alamat Email</label>
                <div class="input-wrap">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" class="{{ $errors->has('email') ? 'input-err' : '' }}" autofocus required>
                </div>
                @error('email')<div class="err-msg">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label style="display:flex;justify-content:space-between">
                    Password
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="color:#00d4aa;font-weight:500">Lupa password?</a>
                    @endif
                </label>
                <div class="input-wrap">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="••••••••" class="{{ $errors->has('password') ? 'input-err' : '' }}" required>
                </div>
                @error('password')<div class="err-msg">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn-login"><i class="fas fa-sign-in-alt" style="margin-right:6px"></i>Masuk ke Dashboard</button>
        </form>

    </div>
</div>
</body>
</html>
