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
        Schema::create('t_service', function (Blueprint $table) {
            $table->id();
            $table->integer('service_request_by')->nullable();
            $table->date('service_request_at')->nullable();
            $table->integer('service_category_id')->nullable();
            $table->integer('current_status_id')->nullable();
            $table->integer('service_amount')->nullable();
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_service');
    }
};
