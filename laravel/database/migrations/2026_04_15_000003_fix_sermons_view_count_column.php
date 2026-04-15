<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('sermons', 'views_count')) {
            Schema::table('sermons', function (Blueprint $table) {
                $table->renameColumn('views_count', 'view_count');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('sermons', 'view_count')) {
            Schema::table('sermons', function (Blueprint $table) {
                $table->renameColumn('view_count', 'views_count');
            });
        }
    }
};
