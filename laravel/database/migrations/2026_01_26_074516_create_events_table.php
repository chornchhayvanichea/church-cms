<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();

            $table->longText('description')->nullable();
            $table->date('event_date');
            $table->time('event_time')->nullable();
            $table->date('end_date')->nullable();
            $table->time('end_time')->nullable();

            $table->string('location')->nullable();
            $table->string('image')->nullable();
            $table->string('resgister_link')->nullable();
            $table->enum('status', ['upcoming', 'past', 'cancelled'])->default('upcoming');

            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
