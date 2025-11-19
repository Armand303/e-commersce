<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created product.
     */
    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'variants' => 'nullable|array',
            'variants.*' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_.-]/', '_', $file->getClientOriginalName());
            $file->move(public_path('images'), $filename);
            $data['image'] = $filename;
        }

        if (!empty($data['variants'])) {
            $data['variants'] = array_values(array_filter($data['variants']));
        }

        Product::create($data);

        return redirect()->route('home.admin')->with('status', 'Product added.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'variants' => 'nullable|array',
            'variants.*' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('image')) {
            // delete old image if exists
            if ($product->image && file_exists(public_path('images/' . $product->image))) {
                @unlink(public_path('images/' . $product->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_.-]/', '_', $file->getClientOriginalName());
            $file->move(public_path('images'), $filename);
            $data['image'] = $filename;
        }

        if (!empty($data['variants'])) {
            $data['variants'] = array_values(array_filter($data['variants']));
        }

        $product->update($data);

        return redirect()->route('home.admin')->with('status', 'Product updated.');
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Admin index for products (separate page)
     */
    public function adminIndex()
    {
        $products = Product::orderBy('created_at', 'desc')->get()->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'image' => rawurlencode($p->image),
                'price' => $p->price,
                'description' => $p->description,
                'variants' => $p->variants ?? [],
            ];
        })->toArray();

        return view('products.admin', compact('products'));
    }

    /**
     * Show product details for admin (no buy/cart, with edit button)
     */
    public function adminShow($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product_show', compact('product'));
    }
}
