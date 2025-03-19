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
        Schema::create('notifikasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->nullable()->constrained('pesanans')->onDelete('cascade');
            $table->foreignId('barang_masuk_id')->nullable()->constrained('barang_masuks')->onDelete('cascade');
            $table->string('jenis');
            $table->date('tanggal_dibaca')->nullable();
            $table->boolean('dibaca')->default(false);
            $table->text('pesan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasis');
    }
};
