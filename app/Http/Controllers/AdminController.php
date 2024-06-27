<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Import the User model if you need to manage users
use App\Models\News; // Import the News model or any other model as per your requirements
use App\Models\Feedback;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.index');
    }

    // Example methods for managing users

    /**
     * Display a listing of users.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function users()
    {
        $users = User::all(); // Get all users

        return view('admin.users', compact('users'));
    }




    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeUser(Request $request)
    {
        // Validation and store logic for user creation
        // Example:
        // User::create($request->all());

        return redirect()->route('admin.users')->with('success', 'User created successfully.');
    }

    public function feedback()
    {
        $feedbacks = Feedback::where('status', 'pending')->get();
        return view('admin.feedback.index', compact('feedbacks'));
    }


    /**
     * Approve the specified feedback.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveFeedback(Feedback $feedback)
    {
        $feedback->update(['status' => 'approved']);
        return redirect()->route('admin.feedback')->with('success', 'Feedback approved successfully.');
    }

    /**
     * Reject the specified feedback.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectFeedback(Feedback $feedback)
    {
        $feedback->update(['status' => 'rejected']);
        return redirect()->route('admin.feedback')->with('success', 'Feedback rejected successfully.');
    }
}
