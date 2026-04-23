<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password — SportBook</title>

    <!-- Font & Icon (samakan dengan login) -->
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{
            font-family:'Sora',sans-serif;
            background:#0a0f1a;
            color:#e2e8f0;
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .auth-card{
            width:100%;
            max-width:400px;
            background:#0d1526;
            border:1px solid #1e2d45;
            border-radius:16px;
            padding:32px;
            box-shadow:0 20px 60px rgba(0,0,0,.4);
        }

        h5{
            font-size:1.3rem;
            font-weight:800;
            color:#fff;
            margin-bottom:6px;
        }

        .sub{
            font-size:.82rem;
            color:#64748b;
            margin-bottom:24px;
        }

        .form-group{
            margin-bottom:16px;
        }

        label{
            font-size:.75rem;
            font-weight:600;
            color:#94a3b8;
            display:block;
            margin-bottom:6px;
        }

        .input-wrap{
            position:relative;
        }

        .input-wrap i{
            position:absolute;
            left:12px;
            top:50%;
            transform:translateY(-50%);
            color:#64748b;
            font-size:13px;
        }

        input{
            width:100%;
            background:#1a2234;
            border:1px solid #1e2d45;
            border-radius:10px;
            color:#e2e8f0;
            font-size:.82rem;
            padding:10px 12px 10px 36px;
            outline:none;
            transition:.2s;
        }

        input:focus{
            border-color:#00d4aa;
            box-shadow:0 0 0 3px rgba(0,212,170,.12);
        }

        .input-err{
            border-color:#ef4444!important;
        }

        .err-msg{
            font-size:.72rem;
            color:#ef4444;
            margin-top:4px;
        }

        .btn-primary{
            width:100%;
            background:linear-gradient(135deg,#00d4aa,#0ea5e9);
            color:#000;
            border:none;
            border-radius:10px;
            padding:11px;
            font-weight:700;
            font-size:.85rem;
            cursor:pointer;
            transition:.2s;
            margin-top:8px;
        }

        .btn-primary:hover{
            opacity:.9;
            transform:translateY(-1px);
            box-shadow:0 8px 24px rgba(0,212,170,.35);
        }

        .btn-secondary{
            width:100%;
            margin-top:10px;
            background:#1a2234;
            border:1px solid #1e2d45;
            color:#94a3b8;
            border-radius:10px;
            padding:10px;
            font-size:.8rem;
            text-align:center;
            text-decoration:none;
            display:block;
        }

        .btn-secondary:hover{
            border-color:#00d4aa;
            color:#00d4aa;
        }

        .alert-success{
            background:rgba(0,212,170,.12);
            border:1px solid rgba(0,212,170,.3);
            color:#00d4aa;
            padding:10px;
            border-radius:8px;
            font-size:.75rem;
            margin-bottom:16px;
        }
    </style>
</head>
<body>

<div class="auth-card">
    <h5>Lupa Password</h5>
    <p class="sub">Masukkan email dan kami akan kirimkan link reset password.</p>

    @if(session('status'))
        <div class="alert-success">
            <i class="fas fa-check-circle me-1"></i> {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group">
            <label>Email</label>
            <div class="input-wrap">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       class="{{ $errors->has('email') ? 'input-err' : '' }}"
                       placeholder="email@example.com"
                       required>
            </div>
            @error('email')
                <div class="err-msg">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-primary">
            <i class="fas fa-paper-plane" style="margin-right:6px"></i>
            Kirim Link Reset
        </button>

        <a href="{{ route('login') }}" class="btn-secondary">
            ← Kembali ke Login
        </a>
    </form>
</div>

</body>
</html>