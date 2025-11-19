@extends('layouts.app')

@section('content')
    <style>
        .checkout-page{ max-width:360px; margin:10px auto; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; padding:8px; }
        .header{ display:flex; align-items:center; gap:8px; margin-bottom:8px }
        .back{ width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; border-radius:8px; border:1px solid #ddd; color:#444; text-decoration:none }
        .page-title{ font-weight:700; margin-left:6px }

        .user-card{ display:flex; gap:10px; align-items:center; background:#fff; padding:10px; border-radius:8px; box-shadow:0 6px 18px rgba(0,0,0,0.04); margin-bottom:10px }
        .avatar{ width:44px; height:44px; border-radius:50%; background:#eee; display:inline-block }
        .user-name{ font-weight:700 }
        .address-input{ margin-top:8px }
        .address-input input{ width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; box-sizing:border-box }

        .cart-items{ margin-top:10px; background:#fff; padding:10px; border-radius:8px }
        .cart-row{ display:flex; gap:10px; align-items:flex-start }
        .thumb{ width:80px; height:60px; background:#f6f6f6; border-radius:6px; overflow:hidden; display:flex; align-items:center; justify-content:center }
        .thumb img{ max-width:100%; max-height:100%; display:block }
        .cart-meta{ flex:1 }
        .cart-meta .name{ font-weight:800; font-size:14px }
        .cart-meta .variant{ font-size:12px; color:#666; margin-top:6px }

        .price-box{ margin-top:12px; background:#fff; padding:10px; border-radius:8px }
        .price-row{ display:flex; justify-content:space-between; padding:6px 0; font-size:14px }
        .total{ font-weight:800; font-size:16px }

        .payments{ margin-top:12px; background:#fff; padding:10px; border-radius:8px }
        .payment-methods{ display:flex; gap:8px; align-items:center; flex-wrap:wrap }
        .pm{ width:60px; height:36px; background:#f3f3f3; border-radius:6px; display:flex; align-items:center; justify-content:center; font-size:12px }

        .bottom-bar{ position:fixed; left:50%; transform:translateX(-50%); bottom:12px; width:360px; max-width:96%; display:flex; gap:12px; padding:8px; box-sizing:border-box }
        .cancel-btn{ flex:0 0 34%; background:#fff; border-radius:8px; border:1px solid #ccc; display:inline-flex; align-items:center; justify-content:center; height:48px; text-decoration:none; color:#333 }
        .place-btn{ flex:1; background:#007bff; color:#fff; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; height:48px; text-decoration:none; font-weight:800 }
    </style>

    <form method="POST" action="{{ url('/checkout/order') }}">
        @csrf
        <div class="checkout-page">
            <div class="header">
                <a class="back" href="{{ url()->previous() }}">&larr;</a>
                <div class="page-title">Checkout</div>
            </div>

            <div class="user-card">
                <div class="avatar"></div>
                <div>
                    <div class="user-name">{{ auth()->user()->name ?? 'John Doe' }}</div>
                    <div style="font-size:12px;color:#666">your order summary</div>
                </div>
            </div>

            <div class="address-input">
                <input type="text" name="address" placeholder="Masukan alamat:" required />
            </div>

            <div class="cart-items">
            <div style="font-size:13px;font-weight:700;margin-bottom:8px">Items in your cart</div>
            @php
                $p = null;
                if(request()->has('product_id')){
                    try{ $p = \App\Models\Product::find(request()->get('product_id')); }catch(\Throwable $e){ $p = null; }
                }
            @endphp

                @if($p)
                    @php
                        // normalize numeric price from stored value (allow strings like "Rp 1.999.000")
                        $raw = preg_replace('/[^0-9]/', '', (string)$p->price);
                        $price = $raw !== '' ? intval($raw) : 0;
                        $ongkir = 10000;
                        $total = $price + $ongkir;
                        $selectedVariant = request('variant') ?: (is_array($p->variants) && count($p->variants) ? $p->variants[0] : null);
                    @endphp
                    <div class="cart-row">
                        <div class="thumb"><img src="{{ $p->image ? asset('images/' . $p->image) : asset('images/placeholder.png') }}" alt=""></div>
                        <div class="cart-meta">
                            <div class="name">{{ $p->name }}</div>
                            @if(!empty($p->variants) && is_array($p->variants))
                                <div style="margin-top:6px">
                                    <label style="font-size:12px;color:#666;display:block;margin-bottom:6px">Pilih varian</label>
                                    <select name="variant" style="width:100%;padding:8px;border-radius:8px;border:1px solid #e5e7eb">
                                        @foreach($p->variants as $v)
                                            <option value="{{ $v }}" {{ $v == $selectedVariant ? 'selected' : '' }}>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="variant">varian: -</div>
                            @endif
                        </div>
                        <div style="text-align:right">Rp {{ number_format($price,0,',','.') }}</div>
                    </div>
                @else
                    <div style="color:#666">No product selected.</div>
                @endif
        </div>

            <div class="price-box">
                @if($p)
                    <div class="price-row"><div>{{ $p->name }}</div><div>Rp {{ number_format($price,0,',','.') }}</div></div>
                    <div class="price-row"><div>Ongkir</div><div>Rp {{ number_format($ongkir,0,',','.') }}</div></div>
                    <div class="price-row total"><div>Total</div><div>Rp {{ number_format($total,0,',','.') }}</div></div>
                @else
                    <div class="price-row total"><div>Total</div><div>Rp 0</div></div>
                @endif
                <input type="hidden" name="product_id" value="{{ request()->get('product_id') }}">
                @if($p)
                    {{-- keep selected variant in the submitted form if present --}}
                    <input type="hidden" name="variant" value="{{ request('variant') ?: (is_array($p->variants) && count($p->variants) ? $p->variants[0] : '') }}">
                @endif
            </div>

            <div class="payments">
                <div style="font-weight:700;margin-bottom:8px">Metode pembayaran</div>
                <div class="payment-methods">
                    <label class="pm"><input type="radio" name="payment_method" value="DANA" checked style="margin-right:6px">DANA</label>
                    <label class="pm"><input type="radio" name="payment_method" value="gopay" style="margin-right:6px">gopay</label>
                    <label class="pm"><input type="radio" name="payment_method" value="OVO" style="margin-right:6px">OVO</label>
                    <label class="pm"><input type="radio" name="payment_method" value="QRIS" style="margin-right:6px">QRIS</label>
                </div>
            </div>

        </div>

        <div class="bottom-bar">
            <a class="cancel-btn" href="{{ url()->previous() }}">Cancel</a>
            <button class="place-btn" type="submit">Place Order</button>
        </div>
    </form>

@endsection
