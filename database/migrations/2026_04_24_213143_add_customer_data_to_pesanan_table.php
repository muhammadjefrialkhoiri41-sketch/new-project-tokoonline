<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {

            $table->unsignedBigInteger('customer_id')->nullable()->after('id');

            $table->string('nama_pembeli')->nullable();
            $table->string('email')->nullable();
            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {

            $table->dropColumn([
                'customer_id',
                'nama_pembeli',
                'email',
                'no_hp',
                'alamat'
            ]);

        });
    }
};