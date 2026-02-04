<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('video_id')->unique();
            $table->text('url');
            $table->text('title');
            $table->text('channel_name')->nullable();
            $table->text('thumbnail_url')->nullable();
            $table->text('description')->nullable();
            $table->longText('transcript')->nullable();
            $table->text('summary_short')->nullable();
            $table->longText('summary_long')->nullable();
            $table->string('category')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
