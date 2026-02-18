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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->text('icon')->nullable();
            $table->integer('home_id')->default(0);
            $table->text('form_name')->nullable();
            $table->text('table')->nullable();
            $table->text('model_name')->nullable();
            $table->integer('create_record')->default(0);
            $table->text('link')->nullable();
            $table->integer('initial_status');
            $table->bigInteger('created_by')->nullable();
            $table->date('created_at')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->date('updated_at')->nullable();
            $table->tinyInteger('deleted_tag')->default(0);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
