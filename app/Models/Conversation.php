<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conversation extends Model
{
    use HasFactory;
    protected $fillable = [
         'title','is_group'
    ];

    // 多対多: conversation ↔ users
    public function users()
    {
        return $this->belongsToMany(User::class, 'conversation_user');
    }

    // 1対多: conversation ↔ messages
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}

