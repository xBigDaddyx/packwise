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
        Schema::create('carton_boxes', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->unique();
            $table->enum('status', ['unverified', 'verified'])->default('unverified');
            $table->foreignId('packing_list_id')->constrained('packing_lists')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carton_boxes');
    }
};
