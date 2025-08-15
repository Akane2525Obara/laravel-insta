<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function index()
    {
         $categories = Category::withCount(['posts' => function ($query) {
                $query->whereNull('deleted_at'); 
            }])
            ->orderByRaw("CASE WHEN LOWER(name) = 'uncategorized' THEN 1 ELSE 0 END") // uncategorized is last
            ->orderBy('id', 'asc')->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Category::create(['name' => $request->name]);

        return back()->with('success', 'Category added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = Category::findOrFail($id);
        $category->update(['name' => $request->name]);

        return back()->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $category = Category::findOrFail($id);

            // uncategorized 
            $uncategorized = Category::firstOrCreate(['name' => 'Uncategorized']);

            $posts = $category->posts()->get(); // hidden=false しか取得しない
            foreach ($posts as $post) {
                $post->categories()->syncWithoutDetaching([$uncategorized->id]);
                $post->categories()->detach($category->id);
            }

            $category->delete();
        });

        return back()->with('success', 'Category deleted and posts moved to Uncategorized.');
    }
}
