<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('tbl_news')) {
            return;
        }
        Schema::create('tbl_news', function (Blueprint $table) {
            $table->increments('news_id');
            $table->string('news_title');
            $table->string('news_slug');
            $table->string('news_category')->nullable();
            $table->text('news_summary')->nullable();
            $table->longText('news_content')->nullable();
            $table->string('news_image')->nullable();
            $table->tinyInteger('news_status')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_news');
    }
};
