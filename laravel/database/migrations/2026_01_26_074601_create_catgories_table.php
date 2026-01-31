<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catgories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('type', ['sermon_topic', 'event_topic', 'etc.'])->default('sermon_topic');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catgories');
    }
};
