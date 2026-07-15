<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
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
