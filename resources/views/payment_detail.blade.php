@extends('layouts.app')

@section('content')
    <style>
        .pay-page{ max-width:360px; margin:18px auto; padding:12px; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial }
        .card{ background:#fff;padding:12px;border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,0.08) }
        .user-card{ display:flex;gap:10px;align-items:center;background:#f8fafc;padding:10px;border-radius:8px;margin-bottom:12px }
        .avatar{ width:44px;height:44px;border-radius:50%;background:#eee }
        .items-table{ width:100%; border-collapse:collapse;margin-top:8px }
        .items-table td{ padding:6px 0 }
        .divider{ height:1px;background:#eee;margin:8px 0 }
        .pm{ display:flex;align-items:center;gap:8px;margin-top:10px }
        .next-btn{ display:inline-block;margin-top:12px;padding:10px 14px;background:#4b5563;color:#fff;border-radius:8px;text-decoration:none }
    </style>

    <div class="pay-page">
        <div class="card">
            <div class="user-card">
                <div class="avatar"></div>
                <div>
                    <div style="font-weight:800">{{ $order->user_id ? ($order->user->name ?? 'Customer') : (auth()->user()->name ?? 'John Doe') }}</div>
                    <div style="font-size:12px;color:#666">Your order summary</div>
                </div>
            </div>

            <div style="font-weight:700;margin-bottom:6px">Alamat:</div>
            <div style="background:#fff;border-radius:8px;padding:10px;margin-bottom:12px">{{ $order->address }}</div>

            <table class="items-table">
                @foreach($order->items as $item)
                <tr>
                    <td style="font-weight:700">{{ $item->name }}</td>
                    <td style="text-align:right">Rp {{ number_format($item->price,0,',','.') }}</td>
                </tr>
                <tr>
                    <td style="font-size:12px;color:#666">varian: {{ $item->variant ?? '-' }}</td>
                    <td></td>
                </tr>
                @endforeach
            </table>

            <div class="divider"></div>
            <div style="display:flex;justify-content:space-between"><div>ongkir</div><div>Rp {{ number_format(10000,0,',','.') }}</div></div>
            <div style="display:flex;justify-content:space-between"><div>pajak</div><div>Rp 0</div></div>
            <div style="display:flex;justify-content:space-between;font-weight:800;margin-top:6px">Total <div>Rp {{ number_format($order->total,0,',','.') }}</div></div>

            <div style="font-weight:700;margin-top:10px">Pembayaran yang digunakan :</div>
            <div class="pm">
                <label style="display:flex;align-items:center;gap:8px"><input type="radio" checked disabled> {{ strtoupper($order->payment_method) }}</label>
            </div>

            <a class="next-btn" href="{{ url('/orders/' . $order->id . '/success/complete') }}">Next</a>
        </div>
    </div>

@endsection
