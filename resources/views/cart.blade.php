@extends('layouts.app')

@section('content')
    <style>
        .cart-screen{ max-width:380px; margin:0 auto; padding:8px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial }
        .topbar{ display:flex; align-items:center; gap:8px; padding:8px 0 }
        .title{ font-weight:700; font-size:16px }

        .cart-card{ background:#fff; border-radius:10px; padding:10px; box-shadow:0 6px 18px rgba(0,0,0,0.06); display:flex; gap:10px; align-items:center; margin-top:10px }
        .card-thumb{ width:84px; height:72px; border-radius:8px; overflow:hidden; background:#f6f6f6; display:flex; align-items:center; justify-content:center }
        .card-thumb img{ width:100%; height:100%; object-fit:cover; display:block }
        .card-body{ flex:1 }
        .card-title{ font-weight:800; font-size:14px }
        .card-price{ color:#111827; font-weight:800; margin-top:6px }

        .checkout-btn{ background:linear-gradient(180deg,#5eead4,#06b6d4); color:#04263a; padding:8px 14px; border-radius:18px; font-weight:800; box-shadow:0 6px 10px rgba(3,145,155,0.12); text-decoration:none; display:inline-block }

        .card-right{ display:flex; align-items:center; justify-content:center }

        /* small page spacing to mimic mockup */
        body .container { padding-top:6px }
    </style>

    <div class="cart-screen">
        <div class="topbar">
            <a href="{{ url()->previous() }}" style="text-decoration:none">&larr;</a>
            <div class="title">Keranjang</div>
        </div>

        @if(empty($cart) || count($cart) == 0)
            <div style="color:#666;margin-top:12px">Keranjang kosong.</div>
        @else
            @foreach($cart as $i => $item)
                <div class="cart-card">
                    <div class="card-thumb">
                        <img src="{{ $item['image'] ? asset('images/' . $item['image']) : asset('images/placeholder.png') }}" alt="{{ $item['name'] }}">
                    </div>

                    <div class="card-body">
                        <div class="card-title">{{ $item['name'] }}</div>
                        <div class="card-price">Rp {{ number_format(($item['price'] ?? 0),0,',','.') }}</div>
                    </div>

                    <div class="card-right">
                        <a href="{{ url('/checkout?product_id=' . $item['product_id'] . '&variant=' . urlencode($item['variant'] ?? '') ) }}" class="checkout-btn">CHECKOUT</a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

@endsection
