<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('keranjang_item', function (Blueprint $table) {
            $table->id();

            
            $table->foreignId('keranjang_id')
                  ->constrained('keranjang')
                  ->onDelete('cascade');

            
            $table->uuid('produk_id');

            $table->integer('qty');
            $table->timestamps();

            
            $table->foreign('produk_id')
                  ->references('id')
                  ->on('produk')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keranjang_item');
    }
};