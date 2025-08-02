<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_statements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('general_settings')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('expense_id')->nullable();
            $table->foreignId('parcel_id')->nullable()->constrained('parcels')->onDelete('cascade');
            $table->foreignId('merchant_id')->nullable()->constrained('merchants')->onDelete('cascade');
            $table->foreignId('delivery_man_id')->nullable()->constrained('delivery_man')->onDelete('cascade');
            $table->unsignedTinyInteger('type')->comment('income=1,expense=2')->nullable();
            $table->decimal('amount',16, 2)->nullable();
            $table->date('date')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->index(['company_id', 'expense_id', 'parcel_id', 'merchant_id', 'delivery_man_id'], 'merchant_statements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchant_statements');
    }
};
