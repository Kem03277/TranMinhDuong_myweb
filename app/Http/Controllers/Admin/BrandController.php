<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
        // Query Builder
        // $list = DB::table('brands')
        //     ->select('id', 'brandname', 'slug', 'image', 'status', 'sort_order')
        //     ->where('status', 1)
        //     ->orderBy('brandname')
        //     ->get();
        // return view('admin.brands.index', compact('list'));

        // Eloquent ORM
        $list = Brand::select('id', 'brandname', 'slug', 'image', 'status', 'sort_order')
            ->where('status', 1)
            ->orderBy('brandname')
            ->paginate($limit);
        return view('admin.brands.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return "Form tao thuong hieu moi";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return "Hien thi chi tiet thuong hieu";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return "Form chinh sua thuong hieu";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return "Cap nhat thuong hieu";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return "Xoa thuong hieu";
    }
}
