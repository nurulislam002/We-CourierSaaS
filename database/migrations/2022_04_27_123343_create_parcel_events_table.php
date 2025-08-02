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
        Schema::create('parcel_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('general_settings')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('parcel_id')->nullable()->constrained('parcels')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('cancel_parcel_id')->nullable()->constrained('parcels')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('delivery_man_id')->nullable()->constrained('delivery_man')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('pickup_man_id')->nullable()->constrained('delivery_man')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('hub_id')->nullable()->constrained('hubs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('transfer_delivery_man_id')->nullable()->constrained('delivery_man')->onUpdate('cascade')->onDelete('cascade');
            $table->text('note')->nullable();
            $table->tinyInteger('parcel_status')->nullable();
            $table->string('delivery_lat')->nullable();
            $table->string('delivery_long')->nullable();
            $table->longText('signature_image')->nullable();
            $table->longText('delivered_image')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->index(['company_id', 'parcel_id', 'cancel_parcel_id', 'delivery_man_id', 'pickup_man_id', 'hub_id', 'transfer_delivery_man_id', 'parcel_status', 'created_by'], 'parcel_events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parcel_events');
    }
};
