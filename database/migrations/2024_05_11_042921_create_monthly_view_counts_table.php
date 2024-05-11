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
        Schema::create('monthly_view_counts', function (Blueprint $table) {
            $table->id();
            $table->string('page_path');
            $table->integer('view_count');
            $table->unsignedInteger('year')->default(date('Y')); // year フィールドにデフォルト値を設定
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_view_counts');
    }
};
