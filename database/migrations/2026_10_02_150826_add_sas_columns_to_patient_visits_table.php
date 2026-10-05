<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Colonne SAS del tracciato "Export SR" che non esistevano in patient_visits.
     */
    public function up(): void
    {
        Schema::table('patient_visits', function (Blueprint $table) {
            $table->string('ident', 8)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('repeatpaz', 50)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('singlepaz', 50)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('etnia', 20)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('naive', 20)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('placcasn', 1)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('_3tc', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('abc', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('tpv', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('atv', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('azt', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('dt', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('ddi', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('idv', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('drv', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('dTg', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('efv', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('etv', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('fpv', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('ftc', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('lpv', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('mrv', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('nfv', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('nvp', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('ral', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('evg', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('rpv', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('rtv', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('sqv', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('tdf', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('cobi', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('t', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('d4t', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('dor', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('bic', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('taf', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('cab_', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('cab', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('placcasntot', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('placcadxtot', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('placcatot', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('placcachar', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->string('statin_', 10)->nullable()->charset('ascii')->collation('ascii_general_ci');
            $table->integer('i')->nullable();
            $table->integer('totarv')->nullable();
            $table->integer('dorav_')->nullable();
            $table->integer('k1')->nullable();
            $table->integer('annoarr')->nullable();
            $table->integer('n_placca')->nullable();
            $table->integer('stensi')->nullable();
            $table->integer('pladx')->nullable();
            $table->integer('pladx1')->nullable();
            $table->integer('plasx')->nullable();
            $table->integer('plasx1')->nullable();
            $table->integer('plasx2')->nullable();
            $table->integer('plabis')->nullable();
            $table->integer('torv1')->nullable();
            $table->integer('torv2')->nullable();
            $table->integer('torv3')->nullable();
            $table->integer('torv4')->nullable();
            $table->integer('torv5')->nullable();
            $table->integer('torv6')->nullable();
            $table->integer('torv7')->nullable();
            $table->integer('annovisita')->nullable();
            $table->integer('biktarvy')->nullable();
            $table->decimal('alt_m', 4, 2)->nullable();
            $table->decimal('k2', 6, 3)->nullable();
            $table->decimal('provaq', 8, 4)->nullable();
            $table->decimal('provaw', 8, 4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_visits', function (Blueprint $table) {
            $table->dropColumn([
                'ident',
                'repeatpaz',
                'singlepaz',
                'etnia',
                'naive',
                'placcasn',
                '_3tc',
                'abc',
                'tpv',
                'atv',
                'azt',
                'dt',
                'ddi',
                'idv',
                'drv',
                'dTg',
                'efv',
                'etv',
                'fpv',
                'ftc',
                'lpv',
                'mrv',
                'nfv',
                'nvp',
                'ral',
                'evg',
                'rpv',
                'rtv',
                'sqv',
                'tdf',
                'cobi',
                't',
                'd4t',
                'dor',
                'bic',
                'taf',
                'cab_',
                'cab',
                'placcasntot',
                'placcadxtot',
                'placcatot',
                'placcachar',
                'statin_',
                'i',
                'totarv',
                'dorav_',
                'k1',
                'annoarr',
                'n_placca',
                'stensi',
                'pladx',
                'pladx1',
                'plasx',
                'plasx1',
                'plasx2',
                'plabis',
                'torv1',
                'torv2',
                'torv3',
                'torv4',
                'torv5',
                'torv6',
                'torv7',
                'annovisita',
                'biktarvy',
                'alt_m',
                'k2',
                'provaq',
                'provaw',
            ]);
        });
    }
};
