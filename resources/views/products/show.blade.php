@extends('layouts.app')

@section('content')
    <style>
        .product-page{ padding:12px; max-width:360px; margin:12px auto; position:relative; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial }
        .back-btn{ display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px; border-radius:8px; border:1px solid #ccc; color:#6b3be6; text-decoration:none; margin-bottom:12px }
        .product-image{ width:100%; background:#fff; border-radius:10px; padding:8px; display:flex; justify-content:center; align-items:center; box-shadow: 0 6px 18px rgba(0,0,0,0.06); border:1px solid #e6e6e6 }
        .product-image img{ max-width:100%; height:auto; border-radius:8px; display:block }
        .variants{ margin-top:12px; display:flex; gap:8px; flex-wrap:wrap }
        .variant-chip{ background:#ededed; padding:6px 10px; border-radius:8px; font-weight:700; font-size:12px; text-transform:uppercase; color:#333 }
        .title{ font-weight:800; font-size:18px; margin-top:12px }
        .price{ color:#0a58ca; font-weight:800; margin-top:6px }
        .desc{ margin-top:10px; font-size:14px; color:#333; white-space:pre-wrap }
        .specs{ margin-top:8px; font-size:13px; color:#444 }
        /* edit button removed from public view; admin controls live in admin page */
            /* purchase bar */
            .purchase-bar{ position:fixed; left:50%; transform:translateX(-50%); bottom:12px; width:360px; max-width:96%; display:flex; gap:12px; align-items:center; padding:8px; box-sizing:border-box }
            .purchase-bar .cart-btn{ display:inline-flex; align-items:center; justify-content:center; width:56px; height:48px; background:#11a3f0; border-radius:8px; color:#fff; text-decoration:none }
            .purchase-bar .buy-btn{ flex:1; display:inline-flex; align-items:center; justify-content:center; height:48px; background:#007bff; color:#fff; border-radius:8px; text-decoration:none; font-weight:800 }
    </style>

    <div class="product-page">
        <a class="back-btn" href="{{ url()->previous() }}">&larr;</a>

        {{-- edit removed from public page; admin can edit from admin dashboard --}}

        <div class="product-image">
            <img src="{{ $product->image ? asset('images/' . $product->image) : '' }}" alt="{{ $product->name }}">
        </div>

        <div class="variants" id="variant-list">
            @if(!empty($product->variants) && is_array($product->variants))
                @foreach($product->variants as $i => $v)
                    <button type="button" class="variant-chip" data-variant="{{ $v }}" aria-pressed="false">{{ $v }}</button>
                @endforeach
            @endif
        </div>

        <div class="title">{{ $product->name }}</div>
        <div class="price">{{ $product->price }}</div>

        <div class="desc">{!! nl2br(e($product->description)) !!}</div>

        @if(!empty($product->description))
            <div class="specs">
                {{-- If description contains lines with parentheses like the sample, they will show here as-is --}}
                {!! nl2br(e($product->description)) !!}
            </div>
        @endif

            <!-- Purchase bar (mobile) -->
            <div class="purchase-bar" role="region" aria-label="Purchase">
                <a class="cart-btn" href="/cart?product_id={{ $product->id }}" title="Tambah ke keranjang">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 4h-2l-1 2v2h2l3.6 7.59-1.35 2.45A1 1 0 0 0 9 19h10v-2H9.42a.25.25 0 0 1-.23-.15L9.1 16h7.45a1 1 0 0 0 .92-.62l2.38-5.64A1 1 0 0 0 19.85 8H6.21" stroke="#fff" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                <a id="buy-now-btn" class="buy-btn" href="/checkout?product_id={{ $product->id }}">Pesan sekarang</a>
            </div>
    </div>

    <script>
        (function(){
            const chips = document.querySelectorAll('#variant-list .variant-chip');
            const buyBtn = document.getElementById('buy-now-btn');
            let selected = null;

            if(chips.length){
                // default select first
                selected = chips[0].dataset.variant;
                chips[0].setAttribute('aria-pressed','true');
                chips[0].style.background = '#dbeafe';

                chips.forEach(ch => ch.addEventListener('click', function(e){
                    chips.forEach(c => { c.setAttribute('aria-pressed','false'); c.style.background = ''; });
                    this.setAttribute('aria-pressed','true');
                    this.style.background = '#dbeafe';
                    selected = this.dataset.variant;
                    // update buy link to include variant
                    const url = new URL(buyBtn.href, window.location.origin);
                    url.searchParams.set('variant', selected);
                    buyBtn.href = url.toString();
                }));

                // ensure buy button includes variant initially
                const initUrl = new URL(buyBtn.href, window.location.origin);
                initUrl.searchParams.set('variant', selected);
                buyBtn.href = initUrl.toString();
            }
        })();
    </script>

@endsection
