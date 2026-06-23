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
    public function store(Request $request)
    {
        try {
            Brand::create([
                'brandname' => $request->brandname,
                'slug' => $request->slug,
                'status' => $request->status,
                'sort_order' => $request->sort_order ?? 0,
                'description' => $request->description
            ]);
            return redirect()
                ->route('admin.brands.index')
                ->with('success', 'Thêm thương hiệu thành công');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
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
    public function update(Request $request, string $id)
    {
        try {
            $brand = Brand::find($id);

            if (!$brand) {
                return redirect()
                    ->route('admin.brands.index')
                    ->with('error', 'Thương hiệu không tồn tại');
            }
            // Thực hiện cập nhật thương hiệu
            $brand->update([
                'brandname' => $request->brandname,
                'slug' => $request->slug,
                'status' => $request->status,
                'sort_order' => $request->sort_order ?? 0,
                'description' => $request->description
            ]);
            return redirect()
                ->route('admin.brands.index')
                ->with('success', 'Cập nhật thương hiệu thành công');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
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
