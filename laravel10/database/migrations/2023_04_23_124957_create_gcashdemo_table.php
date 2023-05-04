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
            $table->string('reference', 100);
            $table->string('gcash_reference', 100)->unique();
            $table->string('gcash_name', 100);
            $table->string('gcash_number', 20);
            $table->decimal('gcash_amount', 18, 2);
            $table->decimal('total_amount_received', 18, 2);
            $table->decimal('expected_amount', 18, 2);
            $table->decimal('balance_amount', 18, 2);
            $table->string('status_message', 100)->nullable();
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
