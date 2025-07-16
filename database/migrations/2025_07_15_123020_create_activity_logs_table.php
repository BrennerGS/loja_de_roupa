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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('model_type'); // Ex: App\Models\Product
            $table->unsignedBigInteger('model_id')->nullable(); // ID do modelo afetado
            $table->string('event'); // created, updated, deleted, etc
            $table->json('old_data')->nullable(); // Dados antes da alteração
            $table->json('new_data')->nullable(); // Dados após alteração
            $table->text('description')->nullable(); // Descrição humana
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
