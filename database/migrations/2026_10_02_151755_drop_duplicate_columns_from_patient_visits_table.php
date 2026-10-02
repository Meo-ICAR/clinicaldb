<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Elimina da patient_visits le colonne duplicate di altre già presenti (centro, PS_TSA, PD_TSA, MIT_SX, MIT_DX, FDR, Trattamentonuovo, pazientecode, annovisita).
     */
    public function up(): void
    {
        Schema::table('patient_visits', function (Blueprint $table) {
            $table->dropColumn([
                'centroext',
                'annoarr',
                'ident',
                'sbp',
                'dbp',
                'imt_sn',
                'imt_dx',
                'risk',
                'regimen',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_visits', function (Blueprint $table) {
            $table->string('centroext')->nullable()->comment('Denominazione centro clinico di appartenenza');
            $table->integer('annoarr')->nullable();
            $table->string('ident', 8)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->unsignedSmallInteger('sbp')->nullable()->comment('Pressione Arteriosa Sistolica PAS (mmHg)');
            $table->unsignedSmallInteger('dbp')->nullable()->comment('Pressione Arteriosa Diastolica PAD (mmHg)');
            $table->decimal('imt_sn', 4, 2)->unsigned()->nullable()->comment('Spessore Intima-Media Carotide Sx max (mm)');
            $table->decimal('imt_dx', 4, 2)->unsigned()->nullable()->comment('Spessore Intima-Media Carotide Dx max (mm)');
            $table->string('risk', 100)->nullable()->comment('Fattore di rischio di trasmissione HIV');
            $table->string('regimen')->nullable()->comment('Regime e schema della terapia ARV');
        });
    }
};
