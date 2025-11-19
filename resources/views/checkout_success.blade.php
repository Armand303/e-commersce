<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Success</title>
    <style>
        html,body{height:100%;margin:0}
        body{background:#0bb0e6;display:flex;align-items:center;justify-content:center;font-family:system-ui, -apple-system, 'Segoe UI', Roboto, Arial}
        .container{width:100%;max-width:400px;text-align:center;padding:24px}
        .circle{width:160px;height:160px;border-radius:50%;background:#fff;display:flex;align-items:center;justify-content:center;margin:60px auto}
        .check{width:90px;height:90px;border-radius:50%;display:flex;align-items:center;justify-content:center}
        .check svg{width:72px;height:72px}
        .btn{display:inline-block;margin-top:28px;padding:8px 28px;border-radius:8px;background:#d1d5db;color:#111827;text-decoration:none;font-weight:600}
        .next-wrap{position:fixed;left:0;right:0;bottom:28px;display:flex;justify-content:center}
    </style>
</head>
<body>
    <div class="container">
        <div class="circle">
            <div class="check">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="12" fill="#fff"/>
                    <path d="M6 12.5l3 3 9-9" stroke="#10b981" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>

        <div style="color:#fff;font-size:18px;font-weight:700">Pesanan Berhasil!</div>
        <div style="color:rgba(255,255,255,0.9);margin-top:8px">Terima kasih, pesanan Anda telah diterima.</div>

        <div class="next-wrap">
            <a class="btn" href="/">Next</a>
        </div>
    </div>
</body>
</html>
