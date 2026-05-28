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
        Schema::create('reservation_products', function (Blueprint $table) {
            $table->id();
            
            // Clé étrangère liée à votre table 'tables' (qui stocke les réservations)
            $table->foreignId('reservation_id')
                  ->constrained('tables')
                  ->onDelete('cascade');
            
            // Clé étrangère liée à votre table 'products'
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');
            
            // Quantité commandée (par exemple : 2 Capucins)
            $table->integer('quantity')->default(1);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_products');
    }
};