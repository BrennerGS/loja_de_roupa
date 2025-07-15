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
        Schema::create('social_media_posts', function (Blueprint $table) {
            $table->id();
            $table->string('platform'); // instagram, facebook, etc.
            $table->string('post_type'); // post, story, reel
            $table->string('status'); // draft, scheduled, published
            $table->datetime('publish_at')->nullable();
            $table->string('image')->nullable();
            $table->text('caption');
            $table->json('metrics')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media_posts');
    }
};
