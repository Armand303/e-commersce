@extends('layouts.app')

@section('content')
    <style>
        /* Hide default navbar for this page and reset main padding */
        .navbar { display: none !important; }
        main.py-4 { padding: 0 !important; }
        html, body { height: 100%; }

        .login-page {
            min-height: 100vh;
            background: #13b1db; /* turquoise/blue from design */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            box-sizing: border-box;
        }

        .login-card {
            width: 320px;
            background: #e6e6e6; /* light grey */
            border-radius: 10px;
            padding: 22px 20px 18px 20px;
            box-shadow: 0 8px 18px rgba(0,0,0,0.18);
            text-align: center;
        }

        .logo-circle {
            width:62px;
            height:62px;
            border-radius:50%;
            background:#fff;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            margin: -42px auto 6px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.12);
            overflow:hidden;
        }

        .logo-circle img { max-width:78%; max-height:78%; display:block }

        .login-title {
            font-weight:700;
            color:#2b2b2b;
            margin-top:6px;
            margin-bottom:6px;
            letter-spacing:1px;
        }

        .login-sub {
            font-size:12px;
            color:#333;
            opacity:0.8;
            margin-bottom:12px;
        }

        .input-field {
            width:100%;
            background:#bfbfbf;
            border-radius:6px;
            border: none;
            padding:10px 12px;
            margin-bottom:12px;
            box-sizing:border-box;
            color:#222;
            outline:none;
        }

        .input-field::placeholder { color: #444 }

        .login-btn {
            width:100%;
            background: linear-gradient(#3b57d3,#2b3fb8);
            color:#fff;
            border:none;
            padding:10px 12px;
            border-radius:6px;
            font-weight:700;
            box-shadow:0 6px 12px rgba(43,63,184,0.25);
            cursor:pointer;
            margin-top:6px;
        }

        .small-link { font-size:13px; margin-top:10px; color:#222 }

        .small-link a { color:#1160d9; font-weight:600; text-decoration:none }

        /* center on very small screens */
        @media (max-width:360px){
            .login-card{ width:280px }
        }
    </style>

    <div class="login-page">
        <div class="login-card">
            <div class="logo-circle">
                <img src="{{ asset('images/logo.jpg') }}" alt="logo">
            </div>

            <div class="login-title">LOGIN</div>
            <div class="login-sub">selamat datang di ANP shop<br/>silahkan login terlebih dahulu</div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Email" class="input-field">
                @error('email')
                    <div style="color:#8b0000;margin-bottom:8px;font-size:13px">{{ $message }}</div>
                @enderror

                <input id="password" type="password" name="password" required placeholder="Password" class="input-field">
                @error('password')
                    <div style="color:#8b0000;margin-bottom:8px;font-size:13px">{{ $message }}</div>
                @enderror

                <button type="submit" class="login-btn">LOGIN</button>
            </form>

            <div class="small-link">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></div>
        </div>
    </div>

@endsection
