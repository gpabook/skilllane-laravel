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
        Schema::create('listing_images', function (Blueprint $table) {
            // id: unsigned BIGINT, auto-increment, primary key
            $table->id();

            // filename: VARCHAR(255)
            $table->string('filename', 255);

            // listing_id: unsigned BIGINT (indexed)
            $table->unsignedBigInteger('listing_id');
            $table->index('listing_id');

            // created_at & updated_at: nullable TIMESTAMPs
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_images');
    }
};
