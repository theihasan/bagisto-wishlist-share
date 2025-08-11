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
        Schema::create('wishlist_share_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wishlist_share_id');
            $table->unsignedInteger('product_id');
            $table->json('product_options')->nullable();
            $table->integer('quantity')->default(1);
            $table->timestamps();

            $table->foreign('wishlist_share_id')->references('id')->on('wishlist_shares')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->unique(['wishlist_share_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlist_share_items');
    }
};