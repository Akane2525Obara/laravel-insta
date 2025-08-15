<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    const ADMIN_ROLE_ID = 1;

    const USER_ROLE_ID = 2;

    
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar', 
      'introduction',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    #To get all the postss of a user
    public function posts() {
        return $this->hasMany(Post::class)->latest(); 
    }

    // #To get all the followers of a user
    public function followers() {
       return $this->hasMany(Follow::class,'following_id');
}

// #TO get all the users that the user is following
    public function following() {
       return $this->hasMany(Follow::class,'follower_id');
}

// #Returns TRUE if the logged in user already followed another user
 public function isFollowed() {
    return $this->followers()->where('follower_id', Auth::user()->id)->exists();

}

// activity
public function followerUser()
{
    return $this->belongsTo(User::class, 'follower_id');
}

public function isFollowing($userId)
{
    return $this->following()->where('following_id', $userId)->exists();
}


}