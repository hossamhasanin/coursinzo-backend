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
        Schema::create('orders', function (Blueprint $table) {
            $table->foreignId("user_id")->index();
            $table->foreign("user_id")->on("users")->references("id")->cascadeOnDelete();
            $table->foreignId("course_id")->index();
            $table->foreign("course_id")->on("courses")->references("id")->cascadeOnDelete();
            $table->string("status");
            $table->primary(["user_id", "course_id"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};