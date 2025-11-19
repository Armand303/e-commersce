@extends('layouts.app')

@section('content')
    <style>
        /* page wrapper */
        .brands-page { min-height:100vh; background:#13b1db; padding:8px 12px; box-sizing:border-box }

        /* top header and search area */
        .top-row{ display:flex; align-items:center; justify-content:space-between; gap:8px; margin-bottom:8px }
        .brand-header{    display:flex; align-items:center; gap:8px }
        .app-logo{ width:34px; height:34px }
        .app-name{ font-weight:700; font-size:15px; color:#111 }

        .search-area{ display:flex; gap:8px; align-items:center }
        .search-input{ width:190px; padding:8px 10px; border-radius:8px; border:1px solid rgba(0,0,0,0.08); background:#fff }
        .icon-btn{ width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; border-radius:6px; background:#fff; box-shadow:0 2px 6px rgba(0,0,0,0.06) }

        /* grid */
        .grid{ display:grid; grid-template-columns: repeat(2, 1fr); gap:14px; max-width:460px; margin:0 auto }

        /* card exactly like reference: taller, subtle border radius, subtle border and strong soft shadow */
        .brand-card{
            background:#fff;
            border-radius:10px;
            padding:14px 12px 12px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
            text-align:left;
            display:flex;
            flex-direction:column;
            align-items:flex-start;
            min-height:170px;
            position:relative;
        }

        .brand-inner{ width:100%; display:flex; flex-direction:column; align-items:flex-start; }

        /* center-aligned logo inside a rounded square to match screenshot */
        .logo-holder{
            width:84px; height:84px; border-radius:8px; background:#fff; display:flex; align-items:center; justify-content:center; margin:0 auto; box-shadow:none; border:1px solid rgba(0,0,0,0.03); overflow:hidden;
        }

        .logo-holder img{ width:80%; height:80%; object-fit:contain; display:block }

        /* label left-aligned and small uppercase under the card */
        .brand-name{ margin-top:10px; font-size:11px; color:#333; font-weight:700; text-transform:uppercase; margin-left:6px }

        /* the card's label area placed near the bottom left to mimic spacing */
        .brand-footer{ width:100%; display:flex; align-items:center; justify-content:flex-start }

        @media (max-width:420px){
            .grid{ max-width:360px }
            .brand-card{ min-height:150px }
            .logo-holder{ width:78px; height:78px }
            .search-input{ width:140px }
        }
    </style>

    <div class="brands-page">
        <div class="top-row">
            <div class="brand-header">
                <img class="app-logo" src="{{ asset('images/logo.jpg') }}" alt="logo">
                <div class="app-name">ANP SHOP</div>
            </div>

            <div class="search-area">
                <input class="search-input" placeholder="" id="brand-search">
                <div class="icon-btn">⚲</div>
                <div class="icon-btn">≡</div>
            </div>
        </div>

        <div class="grid" id="brands-grid">
            @foreach($brands as $brand)
                <div class="brand-card">
                    <div class="brand-inner">
                        <div style="width:100%;display:flex;justify-content:center">
                            <div class="logo-holder">
                                <img src="{{ asset('images') . '/' . $brand['file'] }}" alt="{{ $brand['name'] }}">
                            </div>
                        </div>
                        <div class="brand-footer">
                            <div class="brand-name">{{ $brand['name'] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
