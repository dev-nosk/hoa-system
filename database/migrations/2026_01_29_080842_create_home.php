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
        Schema::create('home', function (Blueprint $table) {
            $table->id();
            $table->text('icon')->nullable();
            $table->text('home_name')->nullable();
            $table->text('link')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->date('created_at')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->date('updated_at')->nullable();
            $table->tinyInteger('deleted_tag')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home');
    }
};
