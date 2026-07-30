<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'organizer_id', // Menambahkan organizer_id untuk Multi-Tenant
        'title',
        'description',
        'date',
        'location',
        'price',
        'stock',
        'poster_path'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * Relasi ke tabel Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke tabel Organizer (HIMA/Panitia)
     */
    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    /**
     * Relasi ke tabel Review
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Helper untuk menghitung rata-rata rating (1-5)
     */
    public function averageRating()
    {
        return round($this->reviews()->avg('rating'), 1) ?: 0;
    }
}