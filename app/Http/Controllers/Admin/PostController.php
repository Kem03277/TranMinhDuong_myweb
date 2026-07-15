<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Http\Requests\Admin\PostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
        $list = Post::select('id', 'title', 'slug', 'image', 'status', 'user_id')
            ->with('user:id,fullname')
            ->orderBy('title')
            ->paginate($limit);
        $trashCount = Post::onlyTrashed()->count();

        return view('admin.posts.index', compact('list', 'trashCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::select('id', 'fullname')->get();

        return view('admin.posts.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        try {
            Post::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $request->input('content'),
                'status' => $request->status,
                'user_id' => $request->user_id,
                'image' => null
            ]);
            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Thêm bài viết thành công');
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
        return "Hien thi chi tiet bai viet";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::find($id);
        $users = User::select('id', 'fullname')->get();
        return view('admin.posts.edit', compact('post', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        try {
            $post = Post::find($id);

            if (!$post) {
                return redirect()
                    ->route('admin.posts.index')
                    ->with('error', 'Bài viết không tồn tại');
            }

            $post->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $request->input('content'),
                'status' => $request->status,
                'user_id' => $request->user_id
            ]);

            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Cập nhật bài viết thành công');
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
            Post::findOrFail($id)->delete();

            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Xóa bài viết thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Thực hiện thất bại.');
        }
    }

    public function trash($limit = 10)
    {
        $list = Post::onlyTrashed()
            ->select('id', 'title', 'slug', 'image', 'status', 'user_id', 'deleted_at')
            ->with('user:id,fullname')
            ->orderBy('deleted_at', 'desc')
            ->paginate($limit);
        $trashCount = Post::onlyTrashed()->count();

        return view('admin.posts.trash', compact('list', 'trashCount'));
    }

    public function restore($id)
    {
        try {
            Post::onlyTrashed()->findOrFail($id)->restore();

            return redirect()
                ->route('admin.posts.trash')
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
            Post::onlyTrashed()->findOrFail($id)->forceDelete();

            return redirect()
                ->route('admin.posts.trash')
                ->with('success', 'Xóa vĩnh viễn thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Xóa thất bại.');
        }
    }

    public function restoreAll()
    {
        Post::onlyTrashed()->restore();

        return redirect()
            ->route('admin.posts.trash')
            ->with('success', 'Khôi phục tất cả thành công.');
    }

    public function forceDeleteAll()
    {
        Post::onlyTrashed()->forceDelete();

        return redirect()
            ->route('admin.posts.trash')
            ->with('success', 'Xóa vĩnh viễn tất cả thành công.');
    }
}
