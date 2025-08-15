<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes; 

    protected $fillable = [
        'user_id',
        'category_id',
        'body',
        'image'

    ];
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    // To get the categories under post
    public function categoryPost()
    {
        return $this->hasMany(CategoryPost::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);

    }

    // #To get the likes of a post
    public function likes(){
        return $this->hasMany(Like::class); 
            
    }

    // #returns TRUE if the logged in user allready liked the post
    public function isLiked(){
        return $this->likes()->where("user_id", Auth::user()->id)->exists();
    }

   public function categories()
{
    return $this->belongsToMany(Category::class, 'category_post');
}



}