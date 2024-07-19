<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandarPengelolaan extends Model
{
    use HasFactory;
    protected $fillable = [
        'judul',
        'deskripsi',
        'file_path',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
