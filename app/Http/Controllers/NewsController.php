<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\News;
use App\Models\Category;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $category_id = $request->input('category', 'all');
        $sort = $request->input('sort', 'latest');

        // Query news based on category if not 'all'
        $query = News::query();
        if ($category_id != 'all') {
            $query->where('category_id', $category_id);
        }

        // Apply sorting
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'a-z':
                $query->orderBy('title');
                break;
            case 'z-a':
                $query->orderByDesc('title');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        // Paginate the results with 3 items per page
        $news = $query->paginate(3)->appends(request()->except('page'));

        // Load all categories for filter dropdown
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

    public function search(Request $request)
    {
        $search = $request->input('search');

        $news = News::where('title', 'like', "%$search%")
                    ->orWhere('content', 'like', "%$search%")
                    ->orderBy('created_at', 'desc')
                    ->paginate(3)->appends(request()->except('page'));

        return view('search-results', compact('news', 'search'));
    }

    public function newsByCategory($category)
    {
        // Retrieve the category based on the slug or ID
        $category = Category::where('slug', $category)->orWhere('id', $category)->first();

        // If category not found, return to index or handle accordingly
        if (!$category) {
            // Handle error or redirect
            return redirect()->route('news.index')->with('error', 'Category not found.');
        }

        // Query news based on the selected category
        $news = News::where('category_id', $category->id)
                    ->paginate(3)->appends(request()->except('page'));

        // Pass the category and news to the view
        return view('home', compact('news', 'category'));
    }

    public function filter(Request $request)
    {
        $category_id = $request->get('category');
        $sort = $request->get('sort');

        $query = News::query();

        if ($category_id != 'all') {
            $query->where('category_id', $category_id);
        }

        if ($sort == 'latest') {
            $query->latest();
        } elseif ($sort == 'oldest') {
            $query->oldest();
        } elseif ($sort == 'a-z') {
            $query->orderBy('title');
        } elseif ($sort == 'z-a') {
            $query->orderByDesc('title');
        }

        $news = $query->paginate(3)->appends(request()->except('page'));

        // Load all categories for filter dropdown
        $categories = Category::all();

        return view('home', compact('news', 'categories'));
    }

    public function addToFavorite($id)
    {
        $news = News::findOrFail($id);

        // Attach news to authenticated user's favorites
        auth()->user()->favorites()->attach($news);

        return back()->with('success', 'News added to favorites.');
    }

    public function favorites()
    {
        $user = auth()->user();
        $favorites = $user->favorites()->paginate(10); // Sesuaikan dengan pagination yang Anda inginkan

        return view('favorites', compact('favorites'));
    }

    public function favorite(Request $request, $id)
    {
        $news = News::findOrFail($id);
    
        if ($request->isMethod('POST')) {
            // Tambahkan ke favorit (jika belum ada)
            auth()->user()->favorites()->syncWithoutDetaching([$news->id]);
            return back()->with('success', 'News added to favorites.');
        } elseif ($request->isMethod('DELETE')) {
            // Hapus dari favorit
            auth()->user()->favorites()->detach([$news->id]);
            return back()->with('success', 'News removed from favorites.');
        }
    }

    public function unfavorite(Request $request, $id)
    {
        $news = News::findOrFail($id);

        // Hapus berita dari daftar favorit pengguna
        auth()->user()->favorites()->detach([$news->id]);

        return back()->with('success', 'News removed from favorites.');
    }

}

