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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('sender')->nullable();
            $table->string('receiver')->nullable();
            $table->string('referenceID')->nullable();
            $table->string('transferID')->nullable();
            $table->string('amount')->nullable();
            $table->string('wallet')->nullable();
            $table->string('status')->nullable();
            $table->string('errorMessage')->nullable();
            $table->string('errorCode')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('compane_id')->constrained()->onDelete('cascade');
            $table->foreignId('header_compane_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
