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
        Schema::create('gcashdemo', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 100)->unique();
            $table->string('gcash_reference', 100)->unique();
            $table->string('gcash_name', 100);
            $table->string('gcash_number', 20);
            $table->decimal('amount', 18, 2);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gcashdemo');
    }
};
