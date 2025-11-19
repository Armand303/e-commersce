<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use App\Models\Product;

// Show products on the site root
Route::get('/', [HomeController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin home (shows products + add form)
Route::get('/home/admin', [HomeController::class, 'admin'])->name('home.admin');

// Store product (admin)
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// Show create product form
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

// Checkout page (simple)
Route::get('/checkout', function(Request $request){
	return view('checkout');
})->name('checkout');

// Place order (persist to DB)
Route::post('/checkout/order', function(Request $request){
	$data = $request->validate([
		'product_id' => 'nullable|integer',
		'variant' => 'nullable|string',
		'address' => 'required|string',
		'payment_method' => 'required|string',
	]);

	$product = null;
	if(!empty($data['product_id'])){
		try{ $product = Product::find($data['product_id']); }catch(\Throwable $e){ $product = null; }
	}

	// compute price (same logic as view)
	$price = 0;
	if($product){
		$raw = preg_replace('/[^0-9]/', '', (string)$product->price);
		$price = $raw !== '' ? intval($raw) : 0;
	}
	$ongkir = 10000;
	$total = $price + $ongkir;

	// persist order
	$order = App\Models\Order::create([
		'user_id' => auth()->check() ? auth()->id() : null,
		'address' => $data['address'],
		'payment_method' => $data['payment_method'],
		'total' => $total,
	]);

	if($product){
		App\Models\OrderItem::create([
			'order_id' => $order->id,
			'product_id' => $product->id,
			'name' => $product->name,
			'variant' => $data['variant'] ?? null,
			'price' => $price,
			'quantity' => 1,
		]);
	}

	// Redirect to a success screen
	return redirect(url('/orders/' . $order->id . '/success'));
});

// Show order confirmation
Route::get('/orders/{order}', function(App\Models\Order $order){
	return view('order_confirmation', ['order' => $order]);
})->name('orders.show');

// Success screen after placing order
Route::get('/orders/{order}/success', function(App\Models\Order $order){
	// show payment detail first, user will click Next to complete
	return view('payment_detail', ['order' => $order]);
})->name('orders.success');

// Final success/complete screen after payment detail
Route::get('/orders/{order}/success/complete', function(App\Models\Order $order){
	return view('checkout_success', ['order' => $order]);
})->name('orders.success.complete');


// Cart page: if product_id provided in query, add to session cart then show cart
Route::get('/cart', function(Request $request){
	$cart = session()->get('cart', []);

	if($request->has('product_id')){
		try{ $product = Product::find($request->get('product_id')); }catch(\Throwable $e){ $product = null; }

		if($product){
			$variant = $request->get('variant') ?: (is_array($product->variants) && count($product->variants) ? $product->variants[0] : null);
			$priceRaw = preg_replace('/[^0-9]/', '', (string)$product->price);
			$price = $priceRaw !== '' ? intval($priceRaw) : 0;

			// try to merge with existing item (same product + variant)
			$found = false;
			foreach($cart as $i => $item){
				if($item['product_id'] == $product->id && ($item['variant'] ?? null) == $variant){
					$cart[$i]['quantity'] = ($cart[$i]['quantity'] ?? 0) + 1;
					$found = true;
					break;
				}
			}

			if(!$found){
				$cart[] = [
					'product_id' => $product->id,
					'name' => $product->name,
					'variant' => $variant,
					'price' => $price,
					'quantity' => 1,
					'image' => $product->image,
				];
			}

			session(['cart' => $cart]);
		}
	}

	return view('cart', ['cart' => session()->get('cart', [])]);
});

// Update cart item quantity
Route::post('/cart/update', function(Request $request){
	$data = $request->validate([
		'index' => 'required|integer',
		'quantity' => 'required|integer|min:1',
	]);
	$cart = session()->get('cart', []);
	if(isset($cart[$data['index']])){
		$cart[$data['index']]['quantity'] = $data['quantity'];
		session(['cart' => $cart]);
	}
	return redirect('/cart');
});

// Remove item from cart
Route::post('/cart/remove', function(Request $request){
	$data = $request->validate(['index' => 'required|integer']);
	$cart = session()->get('cart', []);
	if(isset($cart[$data['index']])){
		array_splice($cart, $data['index'], 1);
		session(['cart' => $cart]);
	}
	return redirect('/cart');
});

// Edit product
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
// Update product
Route::match(['put','patch'], '/products/{product}', [ProductController::class, 'update'])->name('products.update');

// Show product detail
// Admin products list (separate from public products)
Route::get('/admin/product', [App\Http\Controllers\ProductController::class, 'adminIndex'])->name('admin.product');

// Admin product detail
Route::get('/admin/product/{product}', [App\Http\Controllers\ProductController::class, 'adminShow'])->name('admin.product.show');

// Show product detail
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
