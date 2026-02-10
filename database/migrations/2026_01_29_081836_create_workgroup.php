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
        Schema::create('workgroup', function (Blueprint $table) {
            $table->id();
            $table->text('workgroup_name')->nullable();
            $table->longText('description');
            $table->integer('create')->default(0);
            $table->integer('list_view')->default(0);
            $table->integer('upload')->default(0);
            $table->integer('attachement_create')->default(0);
            $table->integer('attachement_view')->default(0);
            $table->integer('attachement_delete')->default(0);
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
        Schema::dropIfExists('workgroup');
    }
};
