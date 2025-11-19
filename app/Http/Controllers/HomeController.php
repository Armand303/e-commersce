<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(\Illuminate\Http\Request $request)
    {
        // If logged in user is admin, redirect to admin home
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('home.admin');
        }
        // If products table exists, load products from DB; otherwise, fallback to images
        $products = [];
        if (Schema::hasTable('products')) {
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
        } else {
            // build products list from public/images files that start with "logo"
            $files = glob(public_path('images/logo*.*')) ?: [];
            foreach ($files as $f) {
                $base = basename($f);
                $filename = pathinfo($base, PATHINFO_FILENAME);
                // skip the main logo file named exactly 'logo' (e.g. logo.jpg)
                if (strtolower($filename) === 'logo') {
                    continue;
                }
                // use filename as product name (remove 'logo ' prefix)
                $name = preg_replace('/^logo\\s*/i', '', $filename);
                $products[] = [
                    'name' => strtoupper($name),
                    'image' => rawurlencode($base),
                    // sample price for demo; replace with real data later
                    'price' => 'Rp ' . number_format(rand(100000, 5000000), 0, ',', '.'),
                ];
            }
        }

        // optional search query
        $q = trim((string)$request->query('q', ''));
        if ($q !== '') {
            $products = array_values(array_filter($products, function ($p) use ($q) {
                return stripos($p['name'] ?? '', $q) !== false || (isset($p['description']) && stripos($p['description'], $q) !== false);
            }));
        }

        return view('products', compact('products'));
    }

    /**
     * Admin home: same product listing but with add product form
     */
    public function admin(\Illuminate\Http\Request $request)
    {
        $products = [];
        if (Schema::hasTable('products')) {
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
        } else {
            $files = glob(public_path('images/logo*.*')) ?: [];
            foreach ($files as $f) {
                $base = basename($f);
                $filename = pathinfo($base, PATHINFO_FILENAME);
                if (strtolower($filename) === 'logo') {
                    continue;
                }
                $name = preg_replace('/^logo\\s*/i', '', $filename);
                $products[] = [
                    'name' => strtoupper($name),
                    'image' => rawurlencode($base),
                    'price' => 'Rp ' . number_format(rand(100000, 5000000), 0, ',', '.'),
                ];
            }
        }

        $q = trim((string)$request->query('q', ''));
        if ($q !== '') {
            $products = array_values(array_filter($products, function ($p) use ($q) {
                return stripos($p['name'] ?? '', $q) !== false || (isset($p['description']) && stripos($p['description'], $q) !== false);
            }));
        }

        return view('home_admin', compact('products'));
    }
}
