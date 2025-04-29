<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Si no existe 'option_text', créala
        if (!Schema::hasColumn('options', 'option_text')) {
            Schema::table('options', function (Blueprint $table) {
                $table->string('option_text')->nullable()->after('votation_id');
            });
        }

        // Copia datos de 'name' a 'option_text'
        DB::statement("UPDATE options SET option_text = name WHERE name IS NOT NULL");

        // Elimina la columna antigua 'name'
        if (Schema::hasColumn('options', 'name')) {
            Schema::table('options', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Vuelve a crear 'name'
        if (!Schema::hasColumn('options', 'name')) {
            Schema::table('options', function (Blueprint $table) {
                $table->string('name')->nullable()->after('votation_id');
            });
        }

        // Copia los datos de vuelta desde 'option_text' a 'name'
        DB::statement("UPDATE options SET name = option_text WHERE option_text IS NOT NULL");

        // Elimina 'option_text'
        if (Schema::hasColumn('options', 'option_text')) {
            Schema::table('options', function (Blueprint $table) {
                $table->dropColumn('option_text');
            });
        }
    }
};