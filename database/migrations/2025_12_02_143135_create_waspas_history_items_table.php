<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waspas_history_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('waspas_history_id')
                  ->constrained('waspas_histories')
                  ->cascadeOnDelete();
            $table->foreignId('influencer_id')
                  ->constrained('influencers')
                  ->cascadeOnDelete();
            $table->decimal('final_score', 16, 8);   // nilai akhir Qi
            $table->unsignedInteger('rank');         // peringkat
            $table->json('raw_scores')->nullable();  // simpan nilai input & normalisasi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waspas_history_items');
    }
};
