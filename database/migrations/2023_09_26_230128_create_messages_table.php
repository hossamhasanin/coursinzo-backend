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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("chat_id");
            $table->foreignId("sender_id");
            $table->foreign("sender_id")->on("users")->references("id")->cascadeOnDelete();
            $table->foreignId("receiver_id");
            $table->foreign("receiver_id")->on("users")->references("id")->cascadeOnDelete();
            $table->string("message")->nullable();
            $table->text("image_url")->nullable();
            $table->text("audio_url")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
