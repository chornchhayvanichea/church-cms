<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sermons', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('speaker');
            $table->dateTime('sermon_date');

            $table->text('description')->nullable();
            $table->longText('note')->nullable();

            $table->string('scripture_reference')->nullable();

            $table->string('video_url')->nullable();
            $table->string('pdf_url')->nullable();
            $table->string('thumbnail')->nullable();

            $table->enum('status', ['draft', 'publish', 'archive'])->default('draft');
            $table->unsignedInteger('views_count')->default(0);

            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamp('published_at')->nullable();

            $table->foreignId('series_id')
                ->nullable()
                ->constrained('series')
                ->cascadeOnDelete();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sermons');
    }
};
