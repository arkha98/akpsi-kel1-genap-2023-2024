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
        Schema::create('tb_training_plans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('training_name')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->dateTime('post_date')->nullable();
            $table->string('training_status')->nullable();
            $table->bigInteger('total_budget')->nullable();
            $table->uuid('pic_user_id')->nullable();

            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_training_plans');
    }
};
