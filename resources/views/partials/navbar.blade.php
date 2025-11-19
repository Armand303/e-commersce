<div style="background:#ffffff;border-bottom:1px solid #eef2f7">
    <div style="max-width:980px;margin:0 auto;padding:10px 14px;display:flex;align-items:center;gap:12px;justify-content:space-between">
        <div style="display:flex;align-items:center;gap:12px">
            @auth
                <div style="font-weight:700;color:#111827">{{ auth()->user()->name }}</div>
                <a href="#" onclick="event.preventDefault();document.getElementById('nav-logout-form').submit();" style="text-decoration:none;color:#ef4444;padding:6px 8px;border-radius:6px">Logout</a>
                <form id="nav-logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
            @else
                <a href="{{ route('login') }}" style="text-decoration:none;color:inherit;padding:6px 8px">Login</a>
                <a href="{{ route('register') }}" style="text-decoration:none;color:inherit;padding:6px 8px">Register</a>
            @endauth
        </div>

        <!-- search removed as requested -->

        <div style="display:flex;align-items:center;gap:12px">
            <a href="/cart" title="Keranjang" style="text-decoration:none;color:inherit;padding:6px 8px;border-radius:8px;display:flex;align-items:center">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:block">
                    <path d="M6 6h15l-1.5 9h-11L6 6z" stroke="#111827" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    <circle cx="10" cy="20" r="1" fill="#111827"/>
                    <circle cx="18" cy="20" r="1" fill="#111827"/>
                </svg>
            </a>
            <a href="{{ url('/') }}" style="display:flex;align-items:center;text-decoration:none;color:inherit">
                <img id="nav-logo-img" src="{{ asset('images/logo.svg') }}" alt="ANP SHOP" style="width:40px;height:40px;object-fit:contain;margin-left:8px" onload="document.getElementById('nav-logo-svg').style.display='none'" onerror="this.style.display='none'">
                <svg id="nav-logo-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="width:40px;height:40px;margin-left:8px;display:block">
                    <rect width="24" height="24" rx="4" fill="#0f172a"/>
                    <path d="M5 12l4 4L19 6" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                </svg>
            </a>
        </div>
    </div>
</div>
