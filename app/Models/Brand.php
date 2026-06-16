<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    // Chỉ định tên bảng trong database
    protected $table = 'brands';

    // Chỉ định khóa chính
    protected $primaryKey = 'id';

    // Các cột cho phép thêm/sửa dữ liệu hàng loạt
    protected $fillable = [
        'brandname',
        'slug',
        'image',
        'status',
        'sort_order',
        'description'
    ];
}
