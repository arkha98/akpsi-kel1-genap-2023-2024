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
        Schema::create('tb_role_menu_mappings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('menu_id');
            $table->uuid('role_id');

            $table->boolean('IS_ACTIVE')->default(true);

            $table->boolean('IS_READ')->default(true);
            $table->boolean('IS_READ_RESTRICT_USER')->default(false);
            
            $table->boolean('IS_CREATE')->default(true);
            $table->boolean('IS_CREATE_RESTRICT_USER')->default(false);

            $table->boolean('IS_UPDATE')->default(true);
            $table->boolean('IS_UPDATE_RESTRICT_USER')->default(false);

            $table->boolean('IS_DELETE')->default(true);
            $table->boolean('IS_DELETE_RESTRICT_USER')->default(false);

            $table->boolean('IS_DETAIL')->default(true);
            $table->boolean('IS_DETAIL_RESTRICT_USER')->default(false);

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
        Schema::dropIfExists('tb_role_menu_mappings');
    }
};
