<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('sermons')->where('status', 'publish')->update(['status' => 'published']);
        DB::table('sermons')->where('status', 'archive')->update(['status' => 'archived']);

        Schema::table('sermons', function (Blueprint $table) {
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->change();
        });
    }

    public function down(): void
    {
        DB::table('sermons')->where('status', 'published')->update(['status' => 'publish']);
        DB::table('sermons')->where('status', 'archived')->update(['status' => 'archive']);

        Schema::table('sermons', function (Blueprint $table) {
            $table->enum('status', ['draft', 'publish', 'archive'])->default('draft')->change();
        });
    }
};
