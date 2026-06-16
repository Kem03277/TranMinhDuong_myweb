<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
        // Query Builder
        // $list = DB::table('users')
        //     ->select('id', 'fullname', 'username', 'email', 'phone', 'role', 'status')
        //     ->where('status', 1)
        //     ->orderBy('fullname')
        //     ->get();
        // return view('admin.users.index', compact('list'));

        // Eloquent ORM
        $list = User::select('id', 'fullname', 'username', 'email', 'phone', 'role', 'status')
            ->where('status', 1)
            ->orderBy('fullname')
            ->paginate($limit);
        return view('admin.users.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.j
     */
    public function create()
    {
        return "Form tao nguoi dung moi";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return "Luu nguoi dung moi";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return "Hien thi chi tiet nguoi dung";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return "Form chinh sua nguoi dung";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return "Cap nhat nguoi dung";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return "Xoa nguoi dung";
    }
}
