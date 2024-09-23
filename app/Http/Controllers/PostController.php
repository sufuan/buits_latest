<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Auth::user()->posts;
        return view('dashboard', compact('posts'));
    }

    public function storeDefault()
    {
        $user = Auth::user();

        if ($user->posts()->exists()) {
            return redirect()->route('dashboard')->with('error', 'You already have a post.');
        }

        Post::create([
            'post_status' => 'pending',
            'name' => $user->name,
            'email' => $user->email,
            'user_id' => $user->id,
            'phone' => $user->phone,
            'password' => $user->password,
            'session' => $user->session,
            'department' => $user->department,
            'gender' => $user->gender,

            'image' => $user->image,
            'skills' => $user->skills,
            'transaction_id' => $user->transaction_id,
            'custom_form' => $user->custom_form,
        ]);

        return redirect()->route('dashboard')->with('success', 'Volunteer application submitted successfully.');
    }

    public function updateStatus(Request $request, Post $post)
    {
        $request->validate([
            'post_status' => 'required|in:pending,published'
        ]);

        $post->post_status = $request->post_status;
        $post->save();

        return redirect()->route('dashboard')->with('success', 'Post status updated successfully!');
    }
}
