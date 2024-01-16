<?php

// app/Models/ShortUrl.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    protected $fillable = ['user_id', 'long_url_id', 'short_url', 'visit_count'];

    public function longUrl()
    {
        return $this->belongsTo(Url::class, 'long_url_id');
    }
    public function visits()
{
    return $this->hasMany(Visit::class); // Assuming your Visit model is named Visit
}
}
