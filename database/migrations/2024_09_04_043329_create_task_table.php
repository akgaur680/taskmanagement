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
        Schema::create('task', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('decription')->nullable();
            $table->date('deadline')->format('d/m/Y')->nullable();
            $table->date('day')->format('l')->nullable();
            $table->foreignId('status_id')->references('id')->on('status')->onDelete('cascade')->default('1');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task');
    }
};
