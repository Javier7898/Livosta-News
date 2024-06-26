<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News; // Import model News

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $news = News::all(); // Dapatkan semua data berita
        return view('home', compact('news')); // Kirim data berita ke tampilan home
    }
}
