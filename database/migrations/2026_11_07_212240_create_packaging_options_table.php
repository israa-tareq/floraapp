<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packaging_options', function (Blueprint $table) {
            $table->id();

            $table->enum('type', [
                'wrap',
                'ribbon',
                'box',
            ]);

            $table->string('name');

            $table->string('color');

            $table->decimal('price', 10, 2);

            $table->unsignedInteger('stock_quantity')->default(0);

            $table->string('image_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packaging_options');
    }
};