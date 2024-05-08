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
        Schema::create('tb_menus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('menu_code')->nullable();
            $table->string('menu_slug')->nullable();
            $table->string('menu_name')->nullable();
            $table->string('menu_desc')->nullable();
            
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
        Schema::dropIfExists('tb_menus');
    }
};
