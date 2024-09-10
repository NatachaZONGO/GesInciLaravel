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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->unsignedBigInteger('departement_id'); // Clé étrangère
            $table->string('description');
            $table->timestamps();
        });
    }


    /*public function departement(): MorphOne
    {
        return $this->morphMany(Departement::class, 'departement_id');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
