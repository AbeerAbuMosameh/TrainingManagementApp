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
        Schema::create('trainees', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('education');
            $table->string('gpa')->nullable();
            $table->string('address');
            $table->string('city')->nullable();
            $table->string('payment')->nullable();
            $table->enum('language', ['English', 'Arabic', 'French'])->default('English')->nullable();
            $table->string('cv')->nullable();
            $table->string('certification')->nullable();
            $table->json('otherFile')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->string('password');
            $table->unsignedBigInteger('notification_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainees');
    }
}; 