<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\model\PostCategory;
use Illuminate\Support\Str;

class PostCategoryController extends Controller
{
    public function index()
    {
        $categories = PostCategory::latest()->paginate(10);
        return view('gift.admin.post_category.index', compact('categories'));
    }

    public function create()
    {
        return view('gift.admin.post_category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:post_categories,name',
            'description' => 'nullable|string',
        ]);

        PostCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->route('post-categories.index')->with('success', 'Category created successfully!');
    }

    public function edit(PostCategory $postCategory)
    {
        return view('gift.admin.post_category.edit', compact('postCategory'));
    }

    public function update(Request $request, PostCategory $postCategory)
    {
        $request->validate([
            'name' => 'required|unique:post_categories,name,' . $postCategory->id,
            'description' => 'nullable|string',
        ]);

        $postCategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->route('post-categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(PostCategory $postCategory)
    {
        $postCategory->delete();
        return redirect()->route('post-categories.index')->with('success', 'Category deleted successfully!');
    }
}
