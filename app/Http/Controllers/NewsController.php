<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;



class NewsController extends Controller
{
    public function index()
    {
        $news = News::all();
        return view('user.news.index', compact('news'));
    }

    public function show($id)
    {
        $news = News::findOrFail($id);
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
            'content' => 'required',
            'author' => 'required',
        ]);

        News::create($request->all());
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
        $news->update($request->all());
        return redirect('/admin/news')->with('success', 'News updated successfully.');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();
        return redirect('/admin/news')->with('success', 'News deleted successfully.');
    }
}
