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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('username')->nullable()->unique();
            $table->string('slug_name')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            
            $table->uuid('default_role_id')->nullable();
            $table->boolean('is_active')->default(true);

            $table->string('profile_picture')->nullable();

            $table->dateTime('last_login_date')->nullable();
            $table->dateTime('last_access_date')->nullable();
            $table->dateTime('last_logout_date')->nullable();

            $table->dateTime('last_login_date_sql')->nullable();
            $table->dateTime('last_access_date_sql')->nullable();
            $table->dateTime('last_logout_date_sql')->nullable();

            $table->rememberToken();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->uuid('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
