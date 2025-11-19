@extends('layouts.app')

@section('content')
    <style>
        body { background: #ffffff; }
        .product-page{ padding:16px; max-width:420px; margin:8px auto; position:relative; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial }
        .top-controls{ display:flex; justify-content:space-between; align-items:center }
        .back-btn{ display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px; border-radius:8px; border:1px solid #e5e7eb; color:#111827; text-decoration:none }
        .edit-btn{ display:inline-flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:8px; background:#fff; border:1px solid #e5e7eb; color:#6b7280; text-decoration:none }

        .product-image{ width:100%; background:#fff; border-radius:12px; padding:8px; display:flex; justify-content:center; align-items:center; box-shadow: 0 8px 18px rgba(2,6,23,0.08); border:1px solid #e6e6e6; overflow:hidden }
        .product-image img{ width:100%; height:auto; border-radius:8px; display:block }

        .variant-label{ margin-top:12px; font-size:12px; color:#6b7280 }
        .variants{ margin-top:8px; display:flex; gap:8px; flex-wrap:wrap }
        .variant-chip{ background:#f3f4f6; padding:6px 10px; border-radius:8px; font-weight:700; font-size:12px; text-transform:uppercase; color:#111827; box-shadow:0 1px 0 rgba(0,0,0,0.02) }

        .title{ font-weight:800; font-size:20px; margin-top:12px; color:#111827 }
        .price{ color:#0b61ff; font-weight:800; margin-top:6px; font-size:16px }
        .desc-title{ margin-top:12px; font-weight:700; color:#111827 }
        .desc{ margin-top:6px; font-size:14px; color:#374151; white-space:pre-wrap }
    </style>

    <div class="product-page">
        <div class="top-controls">
            <a class="back-btn" href="{{ url()->previous() }}">&larr;</a>
            <a class="edit-btn" href="{{ route('products.edit', $product->id) }}" title="Edit produk">✎</a>
        </div>

        <div class="product-image" role="img" aria-label="{{ $product->name }}">
            <img src="{{ $product->image ? asset('images/' . $product->image) : asset('images/placeholder.png') }}" alt="{{ $product->name }}">
        </div>

        <div class="variant-label">varian</div>
        <div class="variants">
            @if(!empty($product->variants) && is_array($product->variants))
                @foreach($product->variants as $v)
                    <div class="variant-chip">{{ $v }}</div>
                @endforeach
            @endif
        </div>

        <div class="title">{{ $product->name }}</div>
        <div class="price">{{ $product->price }}</div>

        <div class="desc-title">Deskripsi</div>
        <div class="desc">{!! nl2br(e($product->description)) !!}</div>
    </div>

@endsection
