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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('general_settings')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('account_head_id')->nullable()->constrained('account_heads')->onDelete('cascade');
            $table->unsignedTinyInteger('from')->nullable();
            $table->string('title')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('merchant_id')->nullable()->constrained('merchants')->onDelete('cascade');
            $table->foreignId('delivery_man_id')->nullable()->constrained('delivery_man')->onDelete('cascade');
            $table->foreignId('parcel_id')->nullable()->constrained('parcels')->onDelete('cascade');
            $table->foreignId('account_id')->nullable()->constrained('accounts')->onDelete('cascade');
            $table->foreignId('hub_id')->nullable()->constrained('hubs')->onDelete('cascade');
            $table->foreignId('hub_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('hub_user_account_id')->nullable()->constrained('accounts')->onDelete('cascade');
            $table->decimal('amount',16,2)->nullable();
            $table->date('date')->nullable();
            $table->foreignId('receipt')->nullable()->constrained('uploads')->onDelete('cascade');
            $table->text('note')->nullable();
            $table->timestamps();
            $table->index(['company_id', 'account_head_id', 'from', 'title', 'user_id', 'merchant_id', 'delivery_man_id', 'parcel_id', 'account_id', 'hub_id', 'hub_user_id', 'hub_user_account_id', 'receipt'], 'incomes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incomes');
    }
};
