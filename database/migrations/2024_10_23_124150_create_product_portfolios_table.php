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
        Schema::create('product_portfolios', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();
            $table->bigInteger("mobile")->nullable(); // Changed to bigInteger
            $table->integer('views')->default(0);
            $table->text('video_path1')->nullable(); // Change to text if storing long paths
            $table->text('image_path1')->nullable();
            $table->text('video_path2')->nullable();
            $table->text('image_path2')->nullable();
            $table->text('video_path3')->nullable();
            $table->text('image_path3')->nullable();
            $table->text('video_path4')->nullable();
            $table->text('image_path4')->nullable();
            $table->text('video_path5')->nullable();
            $table->text('image_path5')->nullable();
            $table->text('video_path6')->nullable();
            $table->text('image_path6')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_portfolios', function (Blueprint $table) {
            $table->dropColumn('views');
        });
    }
};
