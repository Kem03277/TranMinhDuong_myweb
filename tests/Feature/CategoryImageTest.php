<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CategoryImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_category_with_image(): void
    {
        Storage::fake('public');

        $response = $this->post(route('admin.categories.store'), [
            'catename' => 'Danh mục test',
            'slug' => 'danh-muc-test',
            'status' => 1,
            'img' => UploadedFile::fake()->image('category.jpg', 300, 300),
        ]);

        $response->assertRedirect(route('admin.categories.index'));

        $category = Category::where('slug', 'danh-muc-test')->first();
        $this->assertNotNull($category);
        $this->assertNotNull($category->image);
        Storage::disk('public')->assertExists('categories/' . $category->image);
    }

    public function test_admin_can_update_category_image(): void
    {
        Storage::fake('public');

        Storage::disk('public')->put('categories/old-image.jpg', 'old');

        $category = Category::create([
            'catename' => 'Danh mục cũ',
            'slug' => 'danh-muc-cu',
            'status' => 1,
            'image' => 'old-image.jpg',
        ]);

        $response = $this->put(route('admin.categories.update', $category->cateid), [
            'catename' => 'Danh mục mới',
            'slug' => 'danh-muc-moi',
            'status' => 1,
            'img' => UploadedFile::fake()->image('new-category.jpg', 300, 300),
        ]);

        $response->assertRedirect(route('admin.categories.index'));

        $category->refresh();

        $this->assertSame('Danh mục mới', $category->catename);
        $this->assertNotSame('old-image.jpg', $category->image);
        Storage::disk('public')->assertMissing('categories/old-image.jpg');
        Storage::disk('public')->assertExists('categories/' . $category->image);
    }
}
