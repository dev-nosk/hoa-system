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
        Schema::create('form_status', function (Blueprint $table) {
            $table->id();
            $table->integer('form_id');
            $table->integer('status_id');
            $table->integer('sequence')->default(1);
            $table->text('status_next')->nullable();
            $table->text('workgroup_ids')->default(1);
            $table->text('category_ids')->nullable();
            $table->integer('task_create')->nullable();
            $table->integer('required_fields')->nullable();
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
        Schema::dropIfExists('form_status');
    }
};
