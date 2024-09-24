<?php

declare(strict_types=1);

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
        Schema::create('order_lines', function (Blueprint $blueprint): void {
            $blueprint->uuid('id');
            $blueprint->foreignUuid('product_id');
            $blueprint->foreignUuid('order_id');
            $blueprint->integer('total_in_cents');
            $blueprint->integer('quantity');
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_lines');
    }
};
