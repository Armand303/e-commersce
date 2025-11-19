<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Confirmation</title>
    <style>
        body{ font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; padding:20px; }
        .card{ border:1px solid #e5e7eb; padding:16px; border-radius:8px; max-width:640px; margin:18px auto }
        .row{ display:flex; justify-content:space-between; padding:8px 0 }
        .muted{ color:#6b7280 }
        .items{ margin-top:12px }
    </style>
</head>
<body>
    <div class="card">
        <h2>Order #{{ $order->id }}</h2>
        <div class="muted">Placed at {{ $order->created_at->format('Y-m-d H:i') }}</div>

        <div style="margin-top:12px">
            <strong>Customer</strong>
            <div class="muted">{{ optional($order->user)->name ?? 'John Doe' }}</div>
        </div>

        <div style="margin-top:12px">
            <strong>Shipping address</strong>
            <div class="muted">{{ $order->address }}</div>
        </div>

        <div style="margin-top:12px">
            <strong>Payment method</strong>
            <div class="muted">{{ $order->payment_method }}</div>
        </div>

        <div class="items">
            <strong>Items</strong>
            @if($order->items->count())
                @foreach($order->items as $item)
                    <div class="row">
                        <div>
                            <div>{{ $item->name }} <span class="muted">x{{ $item->quantity }}</span></div>
                            @if($item->variant)
                                <div class="muted" style="font-size:13px">{{ $item->variant }}</div>
                            @endif
                        </div>
                        <div>Rp {{ number_format($item->price,0,',','.') }}</div>
                    </div>
                @endforeach
            @else
                <div class="muted">No items recorded.</div>
            @endif
        </div>

        <div style="margin-top:12px" class="row">
            <div class="muted">Shipping</div>
            <div>Rp 10.000</div>
        </div>

        <div style="margin-top:12px; font-size:18px; font-weight:600" class="row">
            <div>Total</div>
            <div>Rp {{ number_format($order->total,0,',','.') }}</div>
        </div>

        <div style="margin-top:18px; text-align:right">
            <a href="/" style="text-decoration:none; background:#111827; color:#fff; padding:8px 12px; border-radius:8px">Back to shop</a>
        </div>
    </div>
</body>
</html>
