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
        Schema::create('ref_fields', function (Blueprint $table) {
            $table->id();
            $table->text('field_name');
            $table->text('field_type');
            $table->text('field_class');
            $table->text('field_id');
            $table->text('label');
            $table->text('ref_table');
            $table->text('ref_table_value');
            $table->text('ref_display');
            $table->integer('sequence')->default(0);
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
        Schema::dropIfExists('ref_fields');
    }
};
