<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')
                ->constrained('sales')
                ->cascadeOnDelete();
            $table->foreignId('flower_id')
                ->nullable()
                ->constrained('flowers')
                ->nullOnDelete();
            $table->foreignId('pre_made_bouquet_id')
                ->nullable()
                ->constrained('pre_made_bouquets')
                ->nullOnDelete();
            $table->enum('item_type', ['flower', 'bouquet']);
            $table->string('item_name');
            $table->unsignedInteger('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();

            $table->index(['item_type', 'flower_id']);
            $table->index(['item_type', 'pre_made_bouquet_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
