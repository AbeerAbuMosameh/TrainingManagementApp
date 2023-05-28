<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('trainee_programs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trainee_id');
            $table->unsignedBigInteger('program_id');
            $table->enum('payment_status', ['unpaid', 'paid', 'rejected'])->default('unpaid');
            $table->enum('status', ['accepted', 'rejected'])->default('rejected');
            $table->text('reason')->nullable();
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('trainee_id')->references('id')->on('trainees')->onDelete('cascade');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainee_programs');
    }
};
