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
            $table->integer('service_request_by');
            $table->date('service_request_at');
            $table->integer('service_category_id');
            $table->integer('current_status_id');
            $table->integer('create_by')->default(1);
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
