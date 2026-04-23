<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — SportBook</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Sora',sans-serif;background:#0a0f1a;color:#e2e8f0;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px}
        .auth-card{width:100%;max-width:480px;background:#111827;border:1px solid #1e2d45;border-radius:20px;overflow:hidden}
        .auth-header{padding:28px 32px 24px;background:linear-gradient(135deg,#0f1e3a,#0a1628);border-bottom:1px solid #1e2d45;position:relative;overflow:hidden}
        .auth-header::after{content:'';position:absolute;top:-40px;right:-40px;width:180px;height:180px;background:radial-gradient(circle,rgba(0,212,170,.1),transparent 60%);pointer-events:none}
        .brand{display:flex;align-items:center;gap:10px;margin-bottom:16px}
        .brand-icon{width:34px;height:34px;background:linear-gradient(135deg,#00d4aa,#0ea5e9);border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:15px;font-weight:900;color:#000}
        .brand-name{font-size:.9rem;font-weight:800;color:#fff}
        .auth-header h2{font-size:1.3rem;font-weight:800;color:#fff;margin-bottom:4px}
        .auth-header p{font-size:.8rem;color:#64748b}
        .auth-header p a{color:#00d4aa;font-weight:600}
        .auth-body{padding:28px 32px}
        .row-2{display:grid;grid-template-columns:1fr 1fr;gap:14px}
        .form-group{margin-bottom:14px}
        label{font-size:.73rem;font-weight:600;color:#94a3b8;display:block;margin-bottom:5px;letter-spacing:.02em}
        .input-wrap{position:relative}
        .input-wrap i{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#64748b;font-size:12px}
        input{width:100%;background:#1a2234;border:1px solid #1e2d45;border-radius:10px;color:#e2e8f0;font-family:'Sora',sans-serif;font-size:.82rem;padding:9px 12px 9px 36px;transition:all .2s;outline:none}
        input:focus{border-color:#00d4aa;box-shadow:0 0 0 3px rgba(0,212,170,.12)}
        input::placeholder{color:#3d5068}
        .input-err{border-color:#ef4444!important}
        .err-msg{font-size:.7rem;color:#ef4444;margin-top:3px}
        .btn-register{width:100%;background:linear-gradient(135deg,#00d4aa,#0ea5e9);color:#000;border:none;border-radius:10px;padding:11px;font-weight:700;font-size:.875rem;font-family:'Sora',sans-serif;cursor:pointer;transition:all .2s;margin-top:6px}
        .btn-register:hover{opacity:.9;transform:translateY(-1px);box-shadow:0 8px 24px rgba(0,212,170,.3)}
        .auth-footer{padding:16px 32px;background:#0d1526;border-top:1px solid #1e2d45;text-align:center;font-size:.78rem;color:#64748b}
        .auth-footer a{color:#00d4aa;font-weight:600}
    </style>
</head>
<body>
<div class="auth-card">
    <div class="auth-header">
        <div class="brand">
            <div class="brand-icon">⚡</div>
            <div class="brand-name">SportBook</div>
        </div>
        <h2>Buat akun baru</h2>
        <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
    </div>
    <div class="auth-body">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="row-2">
                <div class="form-group" style="grid-column:1/-1">
                    <label>Nama Lengkap</label>
                    <div class="input-wrap">
                        <i class="fas fa-user"></i>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap Anda" class="{{ $errors->has('name') ? 'input-err' : '' }}" autofocus required>
                    </div>
                    @error('name')<div class="err-msg">{{ $message }}</div>@enderror
                </div>
                <div class="form-group" style="grid-column:1/-1">
                    <label>Email</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" class="{{ $errors->has('email') ? 'input-err' : '' }}" required>
                    </div>
                    @error('email')<div class="err-msg">{{ $message }}</div>@enderror
                </div>
                <div class="form-group" style="grid-column:1/-1">
                    <label>No. HP <span style="color:#3d5068">(opsional)</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-phone"></i>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                    </div>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Min. 8 karakter" class="{{ $errors->has('password') ? 'input-err' : '' }}" required>
                    </div>
                    @error('password')<div class="err-msg">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-register"><i class="fas fa-user-plus" style="margin-right:6px"></i>Daftar Sekarang</button>
        </form>
    </div>
    <div class="auth-footer">Dengan mendaftar, kamu setuju dengan ketentuan layanan SportBook</div>
</div>
</body>
</html>
