<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Like;

class LikeButton extends Component
{
    public Post $post;
    public bool $liked = false;
    public int $count = 0;
    public bool $isLoggedIn = false;

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->isLoggedIn = Auth::check();
        $this->count = Like::where('post_id', $post->id)->count();

        if ($this->isLoggedIn) {
            $this->liked = Like::where('post_id', $post->id)
                               ->where('user_id', Auth::id())
                               ->exists();
        }
    }

    public function toggle()
    {
        // ログインしてない人はログイン画面へ
        if (!Auth::check()) {
            return $this->redirectRoute('login');
        }

        if ($this->liked) {
            // いいね を外す
            Like::where('post_id', $this->post->id)
                ->where('user_id', Auth::id())
                ->delete();

            $this->liked = false;
            $this->count = max(0, $this->count - 1);
        } else {
            // いいね をつける（同じデータが2回入らないように）
            Like::firstOrCreate([
                'post_id' => $this->post->id,
                'user_id' => Auth::id(),
            ]);

            $this->liked = true;
            $this->count = $this->count + 1;
        }
    }

    public function render()
    {
        return view('livewire.like-button');
    }
}
