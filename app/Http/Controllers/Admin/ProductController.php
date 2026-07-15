<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Http\Requests\Admin\ProductRequest;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
        $list = Product::with([
            'category:cateid,catename',
            'brand:id,brandname'
        ])
            ->select(
                'id',
                'productname',
                'price',
                'image',
                'status',
                'cateid',
                'brandid'
            )
            ->orderBy('productname')
            ->paginate($limit);
        $trashCount = Product::onlyTrashed()->count();

        return view('admin.products.index', compact('list', 'trashCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select('cateid', 'catename')->get();
        $brands = Brand::select('id', 'brandname')->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {

            // Upload hình ảnh chính
            $fileName = null;
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $fileName = Str::slug($request->productname)
                    . '-' . time()
                    . '.' . $file->extension();
                $file->storeAs('products', $fileName, 'public');
            }

            $product = Product::create([
                'productname' => $request->productname,
                'slug' => $request->slug,
                'cateid' => $request->cateid,
                'brandid' => $request->brandid,
                'price' => $request->price,
                'pricediscount' => $request->pricediscount ?? 0,
                'description' => $request->description,
                'status' => $request->status,
                'image' => $fileName
            ]);

            // Upload hình ảnh phụ
            if ($request->hasFile('imgs')) {
                $i = 1;
                $time = time(); // cùng timestamp
                foreach ($request->file('imgs') as $file) {
                    // 15_1751363000_1.jpg
                    $fileName = $product->id
                        . '_' . $time . '_' . $i . '.' . $file->extension();
                    $file->storeAs('products', $fileName, 'public');
                    // Lưu vào bảng product_images
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $fileName,
                    ]);
                    $i++;
                }
            }
            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Thêm thành công');
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
        return "Hien thi chi tiet san pham";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::select('cateid', 'catename')->get();
        $brands = Brand::select('id', 'brandname')->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        try {

            // Upload hình ảnh chính
            $fileName = null;
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $fileName = Str::slug($request->productname)
                    . '-' . time()
                    . '.' . $file->extension();
                $file->storeAs('products', $fileName, 'public');
            }

            $product = Product::find($id);

            if (!$product) {
                return redirect()
                    ->route('admin.products.index')
                    ->with('error', 'Sản phẩm không tồn tại');
            }
            // Thực hiện cập nhật sản phẩm
            $product->update([
                'productname' => $request->productname,
                'cateid' => $request->cateid,
                'brandid' => $request->brandid,
                'price' => $request->price,
                'pricediscount' => $request->pricediscount,
                'status' => $request->status,
                'description' => $request->description,
                'image' => $fileName,
            ]);

            // Upload hình ảnh phụ
            if ($request->hasFile('imgs')) {
                $i = 1;
                $time = time(); // cùng timestamp
                foreach ($request->file('imgs') as $file) {
                    // 15_1751363000_1.jpg
                    $fileName = $product->id
                        . '_' . $time . '_' . $i . '.' . $file->extension();
                    $file->storeAs('products', $fileName, 'public');
                    // Lưu vào bảng product_images
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $fileName,
                    ]);
                    $i++;
                }
            }
            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Cập nhật thành công');
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
        try {
            Product::findOrFail($id)->delete();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Xóa sản phẩm thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Thực hiện thất bại.');
        }
    }

    public function trash($limit = 10)
    {
        $list = Product::onlyTrashed()
            ->select('id', 'productname', 'price', 'image', 'status', 'cateid', 'brandid', 'deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->paginate($limit);
        $trashCount = Product::onlyTrashed()->count();

        return view('admin.products.trash', compact('list', 'trashCount'));
    }

    public function restore($id)
    {
        try {
            Product::onlyTrashed()->findOrFail($id)->restore();

            return redirect()
                ->route('admin.products.trash')
                ->with('success', 'Khôi phục thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Khôi phục thất bại.');
        }
    }

    public function forceDelete($id)
    {
        try {
            Product::onlyTrashed()->findOrFail($id)->forceDelete();

            return redirect()
                ->route('admin.products.trash')
                ->with('success', 'Xóa vĩnh viễn thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Xóa thất bại.');
        }
    }

    public function restoreAll()
    {
        Product::onlyTrashed()->restore();

        return redirect()
            ->route('admin.products.trash')
            ->with('success', 'Khôi phục tất cả thành công.');
    }

    public function forceDeleteAll()
    {
        Product::onlyTrashed()->forceDelete();

        return redirect()
            ->route('admin.products.trash')
            ->with('success', 'Xóa vĩnh viễn tất cả thành công.');
    }

    public function deleteImage(Request $request, $productId, $imageId)
    {
        $image = ProductImage::where('product_id', $productId)
            ->find($imageId);

        if (!$image) {
            return response()->json([
                'success' => false,
                'message' => 'Ảnh không tồn tại'
            ], 404);
        }

        $path = 'products/' . $image->image;
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa ảnh phụ thành công'
        ]);
    }

    public function test1()
    {
        return redirect()->route('admin.home');
    }
    public function test2()
    {
        return redirect('/admin/dashboard');
    }
}
