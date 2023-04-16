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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            $table->string('name')
                ->comment('Company name');

            $table->string('email')
                ->unique()
                ->nullable()
                ->comment('Company email');

            $table->string('logo_path')
                ->nullable()
                ->comment('Company logo path');

            $table->string('website')
                ->nullable()
                ->comment('Company website URL');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
