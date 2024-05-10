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
        Schema::create('post_rankings', function (Blueprint $table) {
            $table->integer('rank')->comment('ランキング順位')->unique()->primary();
            $table->string('page')->comment('ページURL');
            $table->integer('page_view_count')->comment('GoogleAnalyticsから取った、一週間のページビュー数');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_rankings');
    }
};
