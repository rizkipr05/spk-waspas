<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waspas_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')              // staff yang melakukan perhitungan
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->string('title');                  // nama perhitungan, misal: "Seleksi Endorse Campaign A"
            $table->text('description')->nullable();  // catatan tambahan
            $table->json('criteria_snapshot')->nullable(); // simpan snapshot kriteria & bobot saat itu
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waspas_histories');
    }
};
