<?php

use App\Enums\PaymentType;
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
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('general_settings')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->integer('type')->comment(PaymentType::BANK.'='.trans('PaymentType'.PaymentType::BANK), PaymentType::MOBILE.'='.trans('PaymentType'.PaymentType::MOBILE));
            $table->timestamps();
            $table->index(['company_id', 'name'], 'payment_gateways');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};
