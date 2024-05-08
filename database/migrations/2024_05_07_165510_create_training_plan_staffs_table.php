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
        Schema::create('tb_training_plan_staffs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('training_plan_id')->nullable();
            $table->uuid('user_id')->nullable();
            $table->dateTime('start_join_date')->nullable();
            $table->datetime('end_join_date')->nullable();
            $table->dateTime('post_date')->nullable();
            $table->string('staff_status')->nullable();
            $table->bigInteger('staff_point')->nullable();
            

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
        Schema::dropIfExists('tb_training_plan_staffs');
    }
};
