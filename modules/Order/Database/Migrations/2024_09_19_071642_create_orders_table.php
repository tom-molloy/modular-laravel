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
        Schema::create('orders', function (Blueprint $blueprint): void {
            $blueprint->uuid('id');
            $blueprint->foreignId('user_id');
            $blueprint->unsignedInteger('total_in_cents');
            $blueprint->string('status');
            $blueprint->string('payment_gateway');
            $blueprint->foreignUuid('payment_id');
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
