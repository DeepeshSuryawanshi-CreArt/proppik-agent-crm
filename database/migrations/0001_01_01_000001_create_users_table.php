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
            $table->id();
            
            // Personal details
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('password');
            
            // Mobile information
            $table->string('mobile')->unique();
            $table->string('base_mobile')->nullable();
            $table->string('country_code')->nullable();
            $table->string('dial_code')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            
            // Mobile verification
            $table->timestamp('mobile_verify_at')->nullable();
            $table->string('otp')->nullable();
            $table->timestamp('otp_verify_at')->nullable();
            $table->timestamp('otp_expire_at')->nullable();
            
            // details
            $table->text('address')->nullable();
            
            // Core fields
            $table->boolean('is_active')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
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
