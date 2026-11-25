<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreMadeBouquet extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_quantity',
        'image_path',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock_quantity' => 'integer',
            'is_featured' => 'boolean',
        ];
    }
}