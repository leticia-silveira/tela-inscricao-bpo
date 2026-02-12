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
        Schema::table('docprojetobpo', function (Blueprint $table) {
            
            $table->string('curso')->nullable()->after('faculdade');
            $table->char('temParente', 1)->nullable()->after('funcao');
            $table->string('grauParente')->nullable()->after('temParente');
            
        });
    }

    public function down(): void
    {
        Schema::table('docprojetobpo', function (Blueprint $table) {
            $table->dropColumn(['curso', 'temParente', 'grauParente']);
        });
    }
};
