<?php

// NewsController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Category;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $category_id = $request->get('category', 'all');
        $sort = $request->get('sort', 'latest');

        $news = News::when($category_id != 'all', function ($query) use ($category_id) {
            $query->where('category_id', $category_id);
        })
        ->when($sort, function ($query) use ($sort) {
            if ($sort == 'latest') {
                $query->orderBy('created_at', 'desc');
            } elseif ($sort == 'oldest') {
                $query->orderBy('created_at', 'asc');
            } elseif ($sort == 'a-z') {
                $query->orderBy('title', 'asc');
            } elseif ($sort == 'z-a') {
                $query->orderBy('title', 'desc');
            }
        })
        ->with('category')
        ->get();

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            $path = $request->file('image')->store('public/images');
            $news->image = basename($path);
        }

        $news->save();
        
        return redirect()->route('admin.news.index')->with('success', 'News created successfully.');
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
            Storage::delete('public/images/' . $news->image);
            $path = $request->file('image')->store('public/images');
            $news->image = basename($path);
        }

        $news->save();

        return redirect()->route('admin.news.index')->with('success', 'News updated successfully.');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);

        if ($news->image) {
            Storage::delete('public/images/' . $news->image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'News deleted successfully.');
    }

    public function filter(Request $request)
    {
        $category_id = $request->get('category');
        $sort = $request->get('sort');

        $news = News::when($category_id != 'all', function ($query) use ($category_id) {
            $query->where('category_id', $category_id);
        })
        ->when($sort, function ($query) use ($sort) {
            if ($sort == 'latest') {
                $query->orderBy('created_at', 'desc');
            } elseif ($sort == 'oldest') {
                $query->orderBy('created_at', 'asc');
            } elseif ($sort == 'a-z') {
                $query->orderBy('title', 'asc');
            } elseif ($sort == 'z-a') {
                $query->orderBy('title', 'desc');
            }
        })
        ->with('category')
        ->get();

        if ($news->isEmpty()) {
            return view('partials.no_result');
        }

        return view('partials.news_list', compact('news'));
    }

    public function newsByCategory($category)
    {
        $news = News::where('category_id', $category)->get();
        return view('home', compact('news'));
    }
}
