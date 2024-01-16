<?php

// app/Models/Visit.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = ['ip_address', 'user_agent', 'referrer','user_id'];

    public function shortUrl()
    {
        return $this->belongsTo(ShortUrl::class, 'short_url_id');
    }

    public function maskedUrl()
    {
        return $this->belongsTo(MaskedUrl::class, 'masked_url_id');
    }

    public function genQr()
    {
        return $this->belongsTo(GenQr::class, 'qr_code_id');
    }
    public function url()
    {
        return $this->belongsTo(Url::class, 'url_id');
    }
}
