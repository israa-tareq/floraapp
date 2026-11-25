<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackagingOption extends Model
{
    protected $fillable = [
        'type',
        'name',
        'color',
        'price',
        'stock_quantity',
        'image_path',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock_quantity' => 'integer',
        ];
    }
}