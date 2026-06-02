<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = DB::table('users')
            ->select('id', 'fullname', 'username', 'email', 'phone', 'role', 'status')
            ->where('status', 1)
            ->orderBy('fullname')
            ->get();
        return view('admin.users.index', ['list' => $list]);
    }

    /**
     * Show the form for creating a new resource.
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
