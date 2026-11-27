<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends Model
{
    protected $fillable = [
        'sale_id',
        'flower_id',
        'pre_made_bouquet_id',
        'item_type',
        'item_name',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'unit_price' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    /**
     * Parent sale record.
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Linked flower when item_type is 'flower'.
     */
    public function flower(): BelongsTo
    {
        return $this->belongsTo(Flower::class);
    }

    /**
     * Linked pre-made bouquet when item_type is 'bouquet'.
     */
    public function preMadeBouquet(): BelongsTo
    {
        return $this->belongsTo(PreMadeBouquet::class);
    }
}
