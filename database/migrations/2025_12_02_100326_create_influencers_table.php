<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('influencers', function (Blueprint $table) {
            $table->id();
            $table->string('name');                 // Nama influencer
            $table->string('username')->nullable(); // Username medsos
            $table->string('platform');             // IG, TikTok, YouTube, dll
            $table->unsignedBigInteger('followers')->default(0);
            $table->decimal('engagement_rate', 5, 2)->nullable(); // misal 4.53 (%)
            $table->string('niche')->nullable();    // fashion, tech, food, dll
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('profile_link')->nullable();
            $table->text('notes')->nullable();      // catatan tambahan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('influencers');
    }
};
