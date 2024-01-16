<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GenQr extends Model
{
    protected $table = 'gen_qr';

    protected $fillable = [
        'qr_code',
        'long_url_id',
        'visit_count',
        'user_id',
    ];
    public function longUrl()
    {
        return $this->belongsTo(Url::class, 'long_url_id');
    }
    public function visits()
{
    return $this->hasMany(Visit::class); // Assuming your Visit model is named Visit
}
    // Define relationships or additional methods as needed
}
