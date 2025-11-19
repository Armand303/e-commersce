<!-- Admin home view: show products and add form -->
@extends('layouts.app')

@section('content')
    <style>
        body{ background:#ffffff }
        .topbar{ display:flex; align-items:center; gap:12px; max-width:640px; margin:8px auto; padding:8px 12px }
        .logo{ display:flex; align-items:center; gap:8px }
        .logo img{ width:34px; height:34px; object-fit:contain }
        .logo .title{ font-weight:800; letter-spacing:1px }
        .search-wrap{ flex:1 }
        .search-input{ width:100%; padding:8px 12px; border-radius:8px; border:1px solid #e5e7eb }

        .products-page{ min-height:100vh; padding:6px 12px 120px; box-sizing:border-box }
        .grid{ display:grid; grid-template-columns: repeat(2, 1fr); gap:14px; max-width:460px; margin:0 auto }
        .product-card{ background:#fff; border-radius:10px; padding:12px; box-shadow:0 10px 20px rgba(0,0,0,0.08); text-align:left; display:flex; flex-direction:column; align-items:flex-start; transition: transform .18s ease, box-shadow .18s ease }
        .img-wrap{ width:100%; display:flex; justify-content:center; align-items:center; padding:6px 0 }
        .img-wrap img{ width:86px; height:86px; object-fit:contain }
        .product-name{ font-weight:700; font-size:12px; margin-top:8px }
        .product-price{ color:#2b3fb8; font-weight:700; margin-top:6px }
        .buy-btn{ margin-top:10px; width:100%; background:linear-gradient(#3b57d3,#2b3fb8); color:#fff; border:none; padding:8px 10px; border-radius:6px; font-weight:700 }
        .add-form{ max-width:460px; margin:18px auto; background:#fff; padding:12px; border-radius:8px }
        .add-form input, .add-form button{ width:100%; padding:8px; margin-top:8px; box-sizing:border-box }
    </style>

    <div class="topbar">
        <div class="logo" style="justify-content:center;">
            <img id="admin-header-logo-img" src="{{ asset('images/logo.svg') }}" alt="ANP SHOP" onload="document.getElementById('admin-header-logo-svg').style.display='none'" onerror="this.style.display='none'">
            <svg id="admin-header-logo-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="display:block;">
                <rect width="24" height="24" rx="4" fill="#0f172a"/>
                <path d="M5 12l4 4L19 6" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            </svg>
            <div class="title">ANP SHOP</div>
        </div>

        <div class="search-row">
            <div class="search-wrap">
                <form method="GET" action="{{ url()->current() }}">
                    <input class="search-input" type="search" name="q" placeholder="Cari produk..." value="{{ request('q') }}">
                </form>
            </div>
            <div style="width:36px;height:36px;display:flex;align-items:center;justify-content:center"> 
            </div>
        </div>
    </div>

    <div class="products-page">
        <div class="grid">

            @foreach($products as $product)
                    <a href="{{ route('admin.product.show', $product['id'] ?? 0) }}" style="text-decoration:none;color:inherit">
                        <div class="product-card" style="cursor:pointer">
                        <div class="img-wrap">
                            <img src="{{ asset('images') . '/' . ($product['image'] ?? '') }}" alt="{{ $product['name'] }}">
                        </div>
                        <div class="product-name">{{ $product['name'] }}</div>
                        <div class="product-price">{{ $product['price'] }}</div>
                        @if(!empty($product['variants']))
                            <div style="margin-top:6px;font-size:12px;color:#333">
                                Varian: {{ implode(', ', $product['variants']) }}
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach

        <style>
            /* Hover effect to indicate clickability */
            .product-card:hover{ transform: translateY(-6px); box-shadow:0 18px 30px rgba(0,0,0,0.16) }
            .product-card:active{ transform: translateY(-2px) }
        </style>
        </div>
        
        {{-- fixed add product button at bottom center --}}
        <div style="position:fixed;left:0;right:0;bottom:18px;display:flex;justify-content:center;pointer-events:none">
            <a href="{{ route('products.create') }}" style="pointer-events:auto;text-decoration:none">
                <div style="width:68px;height:68px;border-radius:50%;background:#fff;display:flex;align-items:center;justify-content:center;font-size:36px;color:#2b3fb8;box-shadow:0 8px 20px rgba(0,0,0,0.15)">
                    +
                </div>
            </a>
        </div>
    </div>

@endsection
