<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('model');
            $table->string('serial_number');
            $table->string('processor')->nullable();
            $table->string('memory')->nullable();
            $table->string('disk')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('price_string');
            $table->foreignId('category_id')->constrained('product_categories')->cascadeOnDelete();
            $table->boolean('fl_available')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
