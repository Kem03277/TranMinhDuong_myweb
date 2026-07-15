<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    // Chỉ định tên bảng trong database
    protected $table = 'posts';

    // Chỉ định khóa chính
    protected $primaryKey = 'id';

    // Các cột cho phép thêm/sửa dữ liệu hàng loạt
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'status',
        'user_id'
    ];

    /**
     * Relationship: Post belongsTo User
     * Một bài viết thuộc về một người dùng
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
