<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    private $user;
    public function __construct(User $user) {
        $this->user = $user;

    }

    public function show($id) {
        $user = $this->user->findOrFail($id);
        return view("users.profile.show")->with('user', $user);
}

public function edit() {
    $user = $this->user->findOrFail(Auth::user()->id);
    return view('users.profile.edit')->with('user', $user);
 }


 public function update(Request $request, $id) {
    $request->validate([
        'name'=> 'required|string|max:255',
        'email'=> 'required|email|max:255',
        'avatar'=> 'mimes:jpg,png,jpeg,gif|max:1048',
        'introduction'=> 'nullable',
        ]);

        $user = $this->user->findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->introduction = $request->introduction;

       if( $request->hasFile('avatar') ) {
        $file = $request->file('avatar');
         $base64Image = 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file));
        $user->avatar = $base64Image;
       }

        $user->save();
        return redirect()->route('profile.show' ,Auth::id())->with('success', 'Profile updated successfully.');
 }

// App\Models\User.php

public function followers($id)
{
    $user = $this->user->findOrFail($id);
    $followers = $user->followers()->with('follower')->get()->pluck('follower');

    return view('users.profile.followers', compact('user', 'followers'));
}

public function following(User $user)
{
    $following = $user->following; 

    return view('users.profile.following', compact('user', 'following'));
}


}