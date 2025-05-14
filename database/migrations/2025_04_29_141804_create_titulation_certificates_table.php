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
        Schema::create('titulation_certificates', function (Blueprint $table) {
            $table->id();
            $table->boolean('type');
            $table->string('project_name')->nullable();
            $table->text('remarks')->nullable();
            $table->date('certificate_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('titulation_certificates');
    }
};
