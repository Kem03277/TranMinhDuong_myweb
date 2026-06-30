<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Http\Requests\Admin\BrandRequest;

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
            ->orderBy('brandname')
            ->paginate($limit);
        return view('admin.brands.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::select('id', 'brandname')->get();

        return view('admin.brands.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        try {
            Brand::create([
                'brandname' => $request->brandname,
                'slug' => $request->slug,
                'status' => $request->status,
                'description' => $request->description
            ]);
            return redirect()
                ->route('admin.brands.index')
                ->with('success', 'Thêm thành công');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Thêm thất bại.');
        }
    }


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
        $brand = Brand::find($id);
        $brands = Brand::select('id', 'brandname')->get();

        return view('admin.brands.edit', compact('brand', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, string $id)
    {
        try {
            $brand = Brand::findOrFail($id);

            // Thực hiện cập nhật thương hiệu
            $brand->update([
                'brandname' => $request->brandname,
                'slug' => $request->slug,
                'status' => $request->status,
                'description' => $request->description
            ]);
            return redirect()
                ->route('admin.brands.index')
                ->with('success', 'Cập nhật thành công.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Cập nhật thất bại.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return "Xoa thuong hieu";
    }
}
