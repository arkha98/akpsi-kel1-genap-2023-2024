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
        Schema::create('tb_roles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('role_slug')->nullable()->unique();
            $table->string('role_name')->nullable();
            $table->string('role_desc')->nullable();
            
            $table->boolean('is_active')->nullable();

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
        Schema::dropIfExists('tb_roles');
    }
};