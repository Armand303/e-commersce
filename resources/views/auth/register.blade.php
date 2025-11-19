@extends('layouts.app')

@section('content')
    <style>
        .navbar { display: none !important; }
        main.py-4 { padding: 0 !important; }
        html, body { height: 100%; }

        .reg-page {
            min-height: 100vh;
            background: #13b1db;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 18px;
            box-sizing: border-box;
        }

        .reg-card {
            width: 320px;
            background: #e0e0e0;
            border-radius: 8px;
            padding: 28px 18px 18px 18px;
            box-shadow: 0 8px 18px rgba(0,0,0,0.14);
            text-align: center;
        }

        .logo-circle { width:62px; height:62px; border-radius:50%; background:#fff; display:inline-flex; align-items:center; justify-content:center; margin:-46px auto 8px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.12) }
        .logo-circle img{ max-width:78%; max-height:78%; display:block }

        .reg-title{ font-weight:700; color:#2b2b2b; margin-bottom:6px }
        .reg-sub{ font-size:12px; color:#333; opacity:0.85; margin-bottom:12px }

        .input-field{ width:100%; background:#bfbfbf; border-radius:6px; border:none; padding:10px 12px; margin-bottom:10px; box-sizing:border-box; color:#222; }
        .select-field{ width:100%; background:#fff; border-radius:6px; border:none; padding:10px 12px; margin-bottom:10px; box-sizing:border-box; color:#222 }

        .reg-btn{ width:100%; background: linear-gradient(#3b57d3,#2b3fb8); color:#fff; border:none; padding:10px 12px; border-radius:6px; font-weight:700; box-shadow:0 6px 12px rgba(43,63,184,0.25); cursor:pointer }

        .small-link{ font-size:13px; margin-top:10px; color:#222 }
        .small-link a{ color:#1160d9; font-weight:600; text-decoration:none }

        @media (max-width:360px){ .reg-card{ width:280px } }
    </style>

    <div class="reg-page">
        <div class="reg-card">
            <div class="logo-circle">
                <img src="{{ asset('images/logo.jpg') }}" alt="logo">
            </div>

            <div class="reg-title">REGISTER</div>
            <div class="reg-sub">selamat datang di ANP shop<br/>silahkan Register terlebih dahulu</div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- optional name left out of UI; backend will fallback to email if missing --}}

                <input id="name" type="text" name="name"  required placeholder="your name" class="input-field">
                @error('name')<div style="color:#8b0000;font-size:13px;margin-bottom:6px">{{ $message }}</div>@enderror

                <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="Email" class="input-field">
                @error('email')<div style="color:#8b0000;font-size:13px;margin-bottom:6px">{{ $message }}</div>@enderror

                <input id="password" type="password" name="password" required placeholder="Password" class="input-field">
                @error('password')<div style="color:#8b0000;font-size:13px;margin-bottom:6px">{{ $message }}</div>@enderror

                <input id="password-confirm" type="password" name="password_confirmation" required placeholder="KonfirmasiPassword" class="input-field">

                <select name="role" class="select-field" required>
                    <option value="">---Pilih Role---</option>
                    <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ old('role')=='user' ? 'selected' : '' }}>User</option>
                </select>
                @error('role')<div style="color:#8b0000;font-size:13px;margin-bottom:6px">{{ $message }}</div>@enderror

                <button type="submit" class="reg-btn">REGISTER</button>
            </form>

            <div class="small-link">Sudah punya akun? <a href="{{ route('login') }}">Login</a></div>
        </div>
    </div>

@endsection
