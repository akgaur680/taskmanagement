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
        Schema::create('subscription', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->bigInteger('stripe_price_id')->unsigned()->nullable();
            $table->text('trial_days');
            $table->bigInteger('amount');
            $table->text('type')->comment('0->Monthly, 1->Yearly, 2->LifeTime');
            $table->text('enabled')->comment('0->disabled, 1->enabled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription');
    }
};
