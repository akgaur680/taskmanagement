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
        Schema::create('subtask', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->references('id')->on('task')->onDelete('cascade');
            $table->text('title');
            $table->text('description')->nullable();
            $table->enum('task_type', ['One-time', 'Recurring'])->nullable();
            $table->date('deadline')->format('d/m/Y')->nullable();
            $table->date('day')->format('l')->nullable();
            $table->foreignId('status_id')->references('id')->on('status')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subtask');
    }
};
