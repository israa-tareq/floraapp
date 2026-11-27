<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Flower extends Model
{
    protected $fillable = [
        'name',
        'color',
        'price_per_stem',
        'stock_quantity',
        'image_path',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'price_per_stem' => 'decimal:2',
            'stock_quantity' => 'integer',
            'is_available' => 'boolean',
        ];
    }

    /**
     * Sale line items referencing this flower.
     */
    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }
}