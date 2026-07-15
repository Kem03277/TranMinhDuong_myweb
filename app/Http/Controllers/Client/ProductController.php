<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->where('status', 1)
            ->select(
                'cateid',
                'catename',
                'slug'
            )
            ->firstOrFail();

        $products = Product::where('cateid', $category->cateid)
            ->select(
                'id',
                'productname',
                'price',
                'pricediscount',
                'image',
                'status',
                'slug'
            )
            ->where('status', 1)
            ->orderByDesc('created_at')
            ->paginate(8);

        return view('client.product.category', compact('category', 'products'));
    }

    public function brand($slug)
    {
        $brand = Brand::where('slug', $slug)->where('status', 1)
            ->select(
                'id',
                'brandname',
                'slug'
            )
            ->firstOrFail();

        $products = Product::where('brandid', $brand->id)
            ->select(
                'id',
                'productname',
                'price',
                'pricediscount',
                'image',
                'status',
                'slug'
            )
            ->where('status', 1)
            ->orderByDesc('created_at')
            ->paginate(8);

        return view('client.product.brand', compact('brand', 'products'));
    }


    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 1)
            ->with(['category', 'brand'])
            ->first();

        if (!$product) {
            abort(404);
        }

        $relatedProducts = Product::where('status', 1)
            ->where(function ($query) use ($product) {
                $query->where('cateid', $product->cateid)
                    ->orWhere('brandid', $product->brandid);
            })
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        return view('client.product.show', compact('product', 'relatedProducts'));
    }
    public function search(Request $request)
    {
        $keyword = trim((string) $request->input('q', ''));
        $priceMin = trim((string) $request->input('price_min', ''));
        $priceMax = trim((string) $request->input('price_max', ''));

        $query = Product::where('status', 1)
            ->select(
                'id',
                'productname',
                'price',
                'pricediscount',
                'image',
                'status',
                'slug'
            );

        if ($keyword !== '') {
            $query->where('productname', 'like', "%{$keyword}%");
        }

        if ($priceMin !== '' && $priceMax !== '') {
            $query->whereBetween('price', [(int) $priceMin, (int) $priceMax]);
        } elseif ($priceMin !== '') {
            $query->where('price', '>=', (int) $priceMin);
        } elseif ($priceMax !== '') {
            $query->where('price', '<=', (int) $priceMax);
        }

        $products = $query->orderByDesc('created_at')
            ->paginate(8)
            ->appends(array_filter([
                'q' => $keyword ?: null,
                'price_min' => $priceMin !== '' ? $priceMin : null,
                'price_max' => $priceMax !== '' ? $priceMax : null,
            ]));

        return view('client.product.search', compact('keyword', 'priceMin', 'priceMax', 'products'));
    }
}
