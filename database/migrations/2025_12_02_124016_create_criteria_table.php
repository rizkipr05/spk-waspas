<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('criteria', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();            // C1, C2, dll
            $table->string('name');                          // Nama kriteria
            $table->enum('type', ['benefit', 'cost']);       // Jenis kriteria
            $table->decimal('weight', 8, 4)->default(0);     // Bobot (0 - 1)
            $table->text('description')->nullable();         // Deskripsi / catatan
            $table->boolean('is_active')->default(true);     // Dipakai atau tidak
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('criteria');
    }
};
