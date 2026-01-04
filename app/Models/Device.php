<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'token', 'widgets'];

    // INI WAJIB ADA BIAR TIDAK HILANG SAAT REFRESH
    protected $casts = [
        'widgets' => 'array',
    ];

    public function datastreams()
    {
        return $this->hasMany(Datastream::class);
    }
}