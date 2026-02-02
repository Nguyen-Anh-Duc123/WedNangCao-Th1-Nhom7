<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('tbl_product_gallery')) {
            return;
        }
        Schema::create('tbl_product_gallery', function (Blueprint $table) {
            $table->increments('gallery_id');
            $table->unsignedInteger('product_id');
            $table->string('gallery_image');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_product_gallery');
    }
};
