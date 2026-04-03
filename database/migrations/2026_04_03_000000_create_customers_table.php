<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile_no')->unique();
            $table->string('base_mobile')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            $table->string('dial_code')->nullable();
            $table->string('email')->unique();
            $table->string('otp_code')->nullable();
            // Subscription and payment details
            $table->string('company_name');
            $table->string('package');
            $table->decimal('amount', 10, 2);
            $table->string('payment_type');
            $table->timestamp('payed_at')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('gst_no')->nullable();
            $table->string('payment_screenshort')->nullable();
            // OTP verification fields
            $table->timestamp('otp_verifed_at')->nullable();
            $table->timestamp('otp_expired_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            // Audit fields
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            // Core fields
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
