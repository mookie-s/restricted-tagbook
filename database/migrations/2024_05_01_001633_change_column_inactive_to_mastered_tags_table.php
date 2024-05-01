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
        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn('inactive');
            $table->boolean('mastered')->default(0)->comment('達人フラグ')->after('abbreviation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->boolean('inactive')->default(0)->comment('非アクティブフラグ')->after('abbreviation');
            $table->dropColumn('mastered');
        });
    }
};
