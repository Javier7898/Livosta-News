<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $newsId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->news_id = $newsId;
        $comment->content = $request->content;
        $comment->save();

        return redirect()->back()->with('status', 'Comment added successfully!');
    }

    public function index($newsId)
    {
        $comments = Comment::with('user')->where('news_id', $newsId)->get();
        return response()->json($comments);
    }

    public function edit(Comment $comment)
    {

        $this->authorize('update', $comment);

        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        
        // Authorization check (optional, can be handled via policies)
        $this->authorize('update', $comment);

        $request->validate([
            'content' => 'required|string',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->route('news.show', ['id' => $comment->news_id])->with('status', 'Comment updated successfully.');
    }

    public function destroy(Comment $comment)
    {
        
        // Authorization check (optional, can be handled via policies)
        $this->authorize('delete', $comment);

        $comment->delete();

        return redirect()->back()->with('status', 'Comment deleted successfully.');
    }

    
}
