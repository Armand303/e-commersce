<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ANP SHOP</title>
    <style>
        html,body{
            height:100%;
            margin:0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
        }
        .splash-wrap{
            background: #13b1db; /* bright blue similar to provided image */
            height:100%;
            display:flex;
            align-items:center;
            justify-content:center;
            text-align:center;
            color:#fff;
            padding:20px;
            box-sizing:border-box;
        }
        .card{
            display:flex;
            flex-direction:column;
            align-items:center;
            gap:20px;
            width:100%;
            max-width:360px;
        }
        .logo-circle{
            width:140px;
            height:140px;
            border-radius:50%;
            background:#fff;
            display:flex;
            align-items:center;
            justify-content:center;
            box-shadow:0 6px 18px rgba(0,0,0,0.25);
            overflow:hidden;
        }
        .logo-circle img{
            max-width:82%;
            max-height:82%;
            display:block;
        }
        .brand{
            font-weight:700;
            letter-spacing:1px;
            font-size:18px;
            text-transform:uppercase;
        }
        .next-btn{
            background: linear-gradient(#f0f0f0,#d9d9d9);
            color:#111;
            padding:10px 28px;
            border-radius:10px;
            box-shadow:0 4px 8px rgba(0,0,0,0.15);
            border:1px solid rgba(0,0,0,0.06);
            cursor:pointer;
            font-weight:600;
        }
        /* make it look nice on very small phones */
        @media (max-width:360px){
            .logo-circle{ width:120px; height:120px }
        }
    </style>
</head>
<body>
    <div class="splash-wrap">
        <div class="card">
            <div class="logo-circle">
                <!-- use asset helper to reference public/images/logo.jpg -->
                <img src="{{ asset('images/logo.jpg') }}" alt="logo">
            </div>
            <div class="brand">ANP SHOP</div>
            <button class="next-btn" onclick="location.href='{{ url('/home') }}'">Next</button>
        </div>
    </div>
</body>
</html>
