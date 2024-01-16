<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;
    protected $fillable = ['long_url','user_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

        public function shortUrl()
        {
            return $this->hasOne(ShortUrl::class, 'long_url_id', 'id');
        }

        public function maskedUrl()
        {
            return $this->hasOne(MaskedUrl::class, 'long_url_id', 'id');
        }

        public function genQr()
        {
            return $this->hasOne(GenQr::class, 'long_url_id', 'id');
        }
    }

