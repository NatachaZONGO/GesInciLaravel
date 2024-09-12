<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\TypeIncident;
use App\Models\Service;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('description');
            $table->foreignIdFor(TypeIncident::class);
            $table->string('commentaires')->nullable();
            $table->enum('priorite', ['faible', 'moyenne', 'forte'])->nullable();;
            $table->foreignIdFor(Service::class);
            $table->unsignedBigInteger('soumis_par');
            $table->foreign('soumis_par')->references('id')->on('users');
            $table->date('date_soumission');
            $table->unsignedBigInteger('prise_en_charge_par')->nullable();
            $table->foreign('prise_en_charge_par')->references('id')->on('users');
            $table->date('date_prise_en_charge')->nullable();
            $table->enum('statut', ['en_cours', 'traite', 'annule']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
