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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_id')->nullable()->constrained();
            $table->string('image')->nullable();
            $table->string('title', 20);
            $table->string('story', 800);
            $table->boolean('break')->default(0)->comment('中断保存フラグ');
            $table->datetime('created_at');
            $table->datetime('updated_at');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
