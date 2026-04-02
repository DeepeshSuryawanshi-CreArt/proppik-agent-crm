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
        Schema::table('reports', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('reports', 'person_name')) {
                $table->string('person_name')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('reports', 'created_by')) {
                $table->foreignId('created_by')->nullable()->constrained('users')->cascadeOnDelete()->after('user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropForeignIdFor('created_by');
            $table->dropColumn(['person_name', 'created_by']);
        });
    }
};
