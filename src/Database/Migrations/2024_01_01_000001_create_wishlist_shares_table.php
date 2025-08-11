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
        Schema::create('wishlist_shares', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('customer_id');
            $table->string('share_token', 64)->unique();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(true);
            $table->timestamp('expires_at')->nullable();
            $table->integer('view_count')->default(0);
            $table->json('shared_platforms')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->index(['share_token', 'is_public']);
            $table->index(['customer_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlist_shares');
    }
};
