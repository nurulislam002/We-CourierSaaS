<?php

use App\Enums\ApprovalStatus;
use App\Enums\UserType;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('general_settings')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('merchant_id')->nullable()->constrained('merchants')->onDelete('cascade');
            $table->decimal('amount',16,2)->nullable();
            $table->tinyInteger('merchant_account')->nullable();
            $table->string('transaction_id')->nullable();
            $table->foreignId('from_account')->nullable()->constrained('accounts')->onDelete('cascade');
            $table->foreignId('reference_file')->nullable()->constrained('uploads');
            $table->text('description')->nullable();
            $table->integer('created_by')->nullable()->comment(UserType::ADMIN.'=admin,'.UserType::MERCHANT.'=merchant');
            $table->unsignedTinyInteger('status')->default(ApprovalStatus::PENDING)->comment( ApprovalStatus::REJECT.'= Reject,' .ApprovalStatus::APPROVED.'=Approved , '.ApprovalStatus::PENDING.'= Pending,' .ApprovalStatus::PROCESSED.'=Process, ');
            $table->timestamps();
            $table->index(['company_id', 'merchant_id', 'from_account', 'reference_file'], 'payments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
