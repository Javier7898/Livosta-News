<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Storage;



class NewsController extends Controller
{
    public function index()
    {
        $news = News::all();
        return view('user.news.index', compact('news'));
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
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required',
            'author' => 'required',
        ]);

        $path = $request->file('image')->store('public/images');

        $news = new News();
        $news->title = $request->title;
        $news->content = $request->content;
        $news->author = $request->author;
        $news->image = basename($path); // Get the file name of the stored image
        $news->save();
        
        return redirect('/admin/news')->with('success', 'News created successfully.');
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'author' => 'required',
        ]);

        $news = News::findOrFail($id);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete the old image
            if ($news->image) {
                Storage::delete('public/images/' . $news->image);
            }
            $path = $request->file('image')->store('public/images');
            $data['image'] = basename($path);
        }

        $news->update($data);
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
    
}
