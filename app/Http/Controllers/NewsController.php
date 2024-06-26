<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('category')->get(); // Include category relationships
        $categories = Category::all();
        return view('home', compact('news', 'categories'));
    }

    public function show($id)
    {
        $news = News::with('comments.user')->findOrFail($id);
        return view('user.news.show', compact('news'));
    }

    public function adminIndex()
    {
        $news = News::all();
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Maksimal 2MB
        'content' => 'required',
        'author' => 'required',
        'category_id' => 'required|exists:categories,id',
    ]);        

    $news = new News();
    $news->title = $request->title;
    $news->content = $request->content;
    $news->author = $request->author;
    $news->category_id = $request->category_id;

    if ($request->hasFile('image')) {
        // Delete the old image
        if ($news->image) {
            Storage::delete('public/images/' . $news->image);
        }
        $path = $request->file('image')->store('public/images');
        $news->image = basename($path);
    }

    $news->save();
    
    return redirect('/admin/news')->with('success', 'News created successfully.');
}

    public function edit($id)
    {
        $news = News::findOrFail($id);
        $categories = Category::all();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required',
        'content' => 'required',
        'author' => 'required',
        'category_id' => 'required|exists:categories,id',
    ]);

    $news = News::findOrFail($id);
    $news->title = $request->title;
    $news->content = $request->content;
    $news->author = $request->author;
    $news->category_id = $request->category_id;

    if ($request->hasFile('image')) {
        // Delete the old image
        if ($news->image) {
            Storage::delete('public/images/' . $news->image);
        }
        $path = $request->file('image')->store('public/images');
        $news->image = basename($path);
    }

    $news->save();

    return redirect('/admin/news')->with('success', 'News updated successfully.');
}
    public function destroy($id)
    {
        $news = News::findOrFail($id);

        if ($news->image) {
            Storage::delete('public/images/' . $news->image);
        }

        $news->delete();

        return redirect('/admin/news')->with('success', 'News deleted successfully.');
    }

    public function filter(Request $request)
    {
        $category_id = $request->get('category');

        $news = News::when($category_id != 'all', function (Builder $query) use ($category_id) {
            $query->where('category_id', $category_id);
        })->with('category')->get();

        if ($news->isEmpty()) {
            return view('partials.no_result');
        }

        return view('partials.news_list', compact('news'));
    }
}
