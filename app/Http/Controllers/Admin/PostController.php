<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
        // Query Builder (với JOIN)
        // $list = DB::table('posts')
        //     ->join('users', 'posts.user_id', '=', 'users.id')
        //     ->select(
        //         'posts.id',
        //         'posts.title',
        //         'posts.slug',
        //         'posts.image',
        //         'posts.status',
        //         'users.fullname'
        //     )
        //     ->orderBy('posts.title')
        //     ->get();
        // return view('admin.posts.index', compact('list'));

        // Eloquent ORM 
        $list = Post::select('id', 'title', 'slug', 'image', 'status', 'user_id')
            ->with('user:id,fullname')
            ->orderBy('title')
            ->paginate($limit);
        return view('admin.posts.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return "Form tao bai viet moi";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return "Luu bai viet moi";
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
        return "Form chinh sua bai viet";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return "Cap nhat bai viet";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return "Xoa bai viet";
    }
}
