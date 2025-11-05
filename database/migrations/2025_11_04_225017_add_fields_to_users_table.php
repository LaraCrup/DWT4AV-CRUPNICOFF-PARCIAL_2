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
        Schema::table('users', function (Blueprint $table) {
            // Verificar si las columnas no existen antes de agregarlas
            if (!Schema::hasColumn('users', 'fecha_nacimiento')) {
                $table->date('fecha_nacimiento')->nullable()->after('password');
            }
            if (!Schema::hasColumn('users', 'fecha_registro')) {
                $table->timestamp('fecha_registro')->nullable()->after('fecha_nacimiento');
            }
            if (!Schema::hasColumn('users', 'rol_id')) {
                $table->foreignId('rol_id')->nullable()->constrained('roles')->onDelete('set null')->after('fecha_registro');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'rol_id')) {
                $table->dropForeign(['rol_id']);
                $table->dropColumn('rol_id');
            }
            if (Schema::hasColumn('users', 'fecha_registro')) {
                $table->dropColumn('fecha_registro');
            }
            if (Schema::hasColumn('users', 'fecha_nacimiento')) {
                $table->dropColumn('fecha_nacimiento');
            }
        });
    }
};
