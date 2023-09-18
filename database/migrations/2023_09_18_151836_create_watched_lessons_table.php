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
        Schema::create('watched_lessons', function (Blueprint $table) {
            $table->foreignId("user_id")->index();
            $table->foreign("user_id")->on("users")->references("id")->cascadeOnDelete();
            $table->foreignId("lesson_id")->index();
            $table->foreign("lesson_id")->on("lessons")->references("id")->cascadeOnDelete();
            $table->primary(["user_id", "lesson_id"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('watched_lessons');
    }
};
