<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{

    public function index()
    {
        if (Auth::user()->isAdmin()) {
            // Admin can see all feedback
            $feedbacks = Feedback::all();
        } else {
            // Regular user can see only approved feedback
            $feedbacks = Feedback::where('user_id', Auth::id())->get();
        }

        return view('feedback.index', compact('feedbacks'));
    }

    public function show(Feedback $feedback)
{
    return view('feedback.show', compact('feedback'));
}

public function create()
{
    $categories = Category::all();
    return view('feedback.create', compact('categories'));
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'image' => 'nullable|image|max:2048',
        'content' => 'nullable|string',
        'category_id' => 'required|exists:categories,id',
        'is_highlighted' => 'boolean',
    ]);

    $user = Auth::user();

    $feedback = new Feedback();
    $feedback->user_id = $user->id;
    $feedback->username = $user->name;
    $feedback->status = 'pending';
    $feedback->title = $request->title;
    $feedback->category_id = $request->category_id;
    $feedback->is_highlighted = $request->is_highlighted ?? false;

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('public/images');
        $feedback->image = basename($path);
    }

    $feedback->content = $request->content;
    $feedback->save();

    return redirect()->route('feedback.index')->with('success', 'Feedback submitted successfully.');
}

public function edit(Feedback $feedback)
{
    // Authorization check (optional, can be handled via policies)
    $this->authorize('update', $feedback);
    $categories = Category::all();
    return view('feedback.edit', compact('feedback', 'categories'));
}

public function update(Request $request, Feedback $feedback)
{
    // Authorization check (optional, can be handled via policies)
    $this->authorize('update', $feedback);

    $request->validate([
        'title' => 'required|string|max:255',
        'image' => 'nullable|image|max:2048',
        'content' => 'nullable|string',
        'category_id' => 'required|exists:categories,id',
        'is_highlighted' => 'boolean',
    ]);

    $feedback->title = $request->title;
    $feedback->content = $request->content;
    $feedback->category_id = $request->category_id;
    $feedback->is_highlighted = $request->is_highlighted ?? false;

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('public/images');
        $feedback->image = basename($path);
    }

    $feedback->save();

    return redirect()->route('feedback.index')->with('success', 'Feedback updated successfully.');
}

    public function destroy(Feedback $feedback)
    {
        // Authorization check (optional, can be handled via policies)
        $this->authorize('delete', $feedback);

        $feedback->delete();

        return redirect()->back()->with('success', 'Feedback deleted successfully.');
    }

    public function approve(Request $request, Feedback $feedback)
    {
        $this->authorize('update', $feedback);

        $feedback->status = 'approved';
        $feedback->save();

        // Create News entry
        News::create([
            'title' => $feedback->title,
            'content' => $feedback->content,
            'image' => $feedback->image,
            'author' => $feedback->username,
            'category_id' => $feedback->category_id,
            'feedback_id' => $feedback->id, // Only include feedback_id here
        ]);

        return redirect()->back()->with('success', 'Feedback approved and news created successfully.');
    }

    public function reject(Request $request, Feedback $feedback)
    {
        $this->authorize('delete', $feedback);

        $feedback->delete();

        return redirect()->back()->with('success', 'Feedback rejected and deleted successfully.');
    }
}
