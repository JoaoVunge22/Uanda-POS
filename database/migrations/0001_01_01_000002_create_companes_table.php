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
        Schema::create('companes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->integer('contact')->nullable();
            $table->string('pais')->nullable();
            $table->string('provincia')->nullable();
            $table->string('cidade')->nullable();
            $table->string('postal')->nullable();
            $table->string('endereco')->nullable();
            $table->json('wallet')->nullable();
            $table->foreignId('header_compane_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companes');
    }
};
