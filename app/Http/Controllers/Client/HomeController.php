<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 1)
            ->select('cateid', 'catename', 'slug')
            ->orderBy('sort_order')
            ->get();

        $brands = Brand::where('status', 1)
            ->select('id', 'brandname', 'slug')
            ->orderBy('sort_order')
            ->get();

        // Sản phẩm mới nhất (lấy 8 sản phẩm mới nhất)
        $newProducts = Product::where('status', 1)
            ->select(
                'id',
                'productname',
                'price',
                'pricediscount',
                'image',
                'status',
                'slug'
            )
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        // Sản phẩm giảm giá (lấy 8 sản phẩm mới nhất)
        $saleProducts = Product::where('status', 1)
            ->select(
                'id',
                'productname',
                'price',
                'pricediscount',
                'image',
                'status',
                'slug'
            )
            ->where('pricediscount', '>', 0)
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        return view('client.home', compact(
            'newProducts',
            'saleProducts',
            'categories',
            'brands'
        ));
    }
}
