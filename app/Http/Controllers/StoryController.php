<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// class StoryController extends Controller
// {
//     public function store(Request $request)
//     {
//         $data = $request->validate([
//             'image'   => ['required','image','max:4096'],
//             'caption' => ['nullable','string','max:200'],
//         ]);

//         $path = $request->file('image')->store('stories', 'public');

//         Story::create([
//             'user_id'    => $request->user()->id,
//             'image_path' => $path,
//             'caption'    => $data['caption'] ?? null,
//             'expires_at' => now()->addDay(),
//         ]);

//         return back()->with('ok','Story posted');
//     }

//     public function show(Story $story)
//     {
//         abort_unless($story->expires_at->isFuture(), 404);
//         $story->load('user');
//         return view('stories.show', compact('story'));
//     }
// }

