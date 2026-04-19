<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        foreach (['admin', 'editor'] as $role) {
            DB::table('roles')->insertOrIgnore([
                'name' => $role,
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $adminRole = DB::table('roles')->where('name', 'admin')->where('guard_name', 'web')->first();
        $editorRole = DB::table('roles')->where('name', 'editor')->where('guard_name', 'web')->first();

        DB::table('users')->get()->each(function ($user) use ($adminRole, $editorRole) {
            $role = $user->role === 'admin' ? $adminRole : $editorRole;
            if ($role) {
                DB::table('model_has_roles')->insertOrIgnore([
                    'role_id' => $role->id,
                    'model_type' => 'App\Models\User',
                    'model_id' => $user->id,
                ]);
            }
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'editor'])->default('editor');
        });

        DB::table('model_has_roles')
            ->where('model_type', 'App\Models\User')
            ->delete();
    }
};
