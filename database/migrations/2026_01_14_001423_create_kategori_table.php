<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kategori', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_kategori');
            $table->string('slug')->unique();
            $table->string('foto')->nullable();
            $table->timestamps();
            $table->boolean('status')->default(1     );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori');
    }
};
