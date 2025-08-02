<?php

use App\Enums\Status;
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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('general_settings')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->foreignId('image_id')->nullable()->constrained('uploads')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('description')->nullable();
            $table->string('position')->nullable();
            $table->unsignedTinyInteger('status')->default(Status::ACTIVE)->comment(Status::ACTIVE.'= Active, '.Status::INACTIVE.'= Inactive');
            $table->timestamps();
            $table->index(['company_id', 'title', 'image_id'], 'services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
};
