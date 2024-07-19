<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataGuru extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama', 'nip', 'tanggal_lahir', 'alamat','foto', 'jabatan', 'pendidikan_terakhir', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
