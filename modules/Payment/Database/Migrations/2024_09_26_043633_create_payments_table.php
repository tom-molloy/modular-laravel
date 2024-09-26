<?php

declare(strict_types=1);

namespace Modules\Payment\Database\Migrations;

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
        Schema::create('payments', function (Blueprint $blueprint): void {
            $blueprint->uuid('id')->primary();
            $blueprint->unsignedInteger('total_in_cents');
            $blueprint->string('status');
            $blueprint->string('payment_gateway');
            $blueprint->uuid('payment_id');
            $blueprint->foreignId('user_id');
            $blueprint->foreignUuid('order_id');
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
