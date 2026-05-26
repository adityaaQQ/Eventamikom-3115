<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

protected $fillable = [
    'title', 
    'date', 
    'price', 
    'poster',
    'category_id',
    'description',
    'location',
    'stock' // Tambahkan bos terakhir ini
];
    
}