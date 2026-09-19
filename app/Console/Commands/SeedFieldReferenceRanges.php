<?php

namespace App\Console\Commands;

use App\Models\FieldReferenceRange;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('patients:seed-field-reference-ranges')]
#[Description('Calcola min/max/media dai dati reali di patient_visits per i campi numerici della videata Visita e aggiorna field_reference_ranges con le soglie cliniche proposte. Idempotente: aggiorna le righe esistenti, rieseguibile in produzione.')]
class SeedFieldReferenceRanges extends Command
{
    /**
     * Campi numerici di patient_visits con etichetta, unità di misura e soglie cliniche
     * proposte (normal/warning/alert). Le soglie sono valori di riferimento standard di
     * letteratura dove il significato del campo è noto: vanno validate da un clinico
     * prima di essere usate in produzione. Dove il significato clinico non è consolidato
     * (es. misure di placca in mm, capqi) le soglie sono lasciate assenti e viene
     * calcolata solo la statistica descrittiva (min/max/media).
     *
     * @var array<string, array{label: string, unit: ?string, normal?: float, warning?: float, alert?: float}>
     */
    private const FIELD_DEFINITIONS = [
        'peso' => ['label' => 'Peso', 'unit' => 'kg'],
        'circonferenza' => ['label' => 'Circonferenza', 'unit' => 'cm'],
        'PAS' => ['label' => 'Pressione sistolica', 'unit' => 'mmHg', 'normal' => 120, 'warning' => 140, 'alert' => 180],
        'PAD' => ['label' => 'Pressione diastolica', 'unit' => 'mmHg', 'normal' => 80, 'warning' => 90, 'alert' => 120],
        'CD4' => ['label' => 'CD4', 'unit' => 'cell/µL', 'normal' => 500, 'warning' => 350, 'alert' => 200],
        'CD4CD8' => ['label' => 'Rapporto CD4/CD8', 'unit' => null, 'normal' => 1.0, 'warning' => 0.6, 'alert' => 0.3],
        'HIVRNA' => ['label' => 'HIV RNA', 'unit' => 'copie/mL', 'normal' => 50, 'warning' => 200, 'alert' => 1000],
        'Creatinina' => ['label' => 'Creatinina', 'unit' => 'mg/dL', 'normal' => 1.2, 'warning' => 1.5, 'alert' => 2.0],
        'Colesterolo' => ['label' => 'Colesterolo totale', 'unit' => 'mg/dL', 'normal' => 200, 'warning' => 240, 'alert' => 300],
        'HDL' => ['label' => 'HDL', 'unit' => 'mg/dL', 'normal' => 60, 'warning' => 40, 'alert' => 30],
        'LDL' => ['label' => 'LDL', 'unit' => 'mg/dL', 'normal' => 100, 'warning' => 160, 'alert' => 190],
        'Trigliceridi' => ['label' => 'Trigliceridi', 'unit' => 'mg/dL', 'normal' => 150, 'warning' => 200, 'alert' => 500],
        'Glicemia' => ['label' => 'Glicemia', 'unit' => 'mg/dL', 'normal' => 100, 'warning' => 126, 'alert' => 200],
        'Insulina' => ['label' => 'Insulina', 'unit' => 'µU/mL', 'normal' => 25, 'warning' => 35, 'alert' => 50],
        'Proteinuria' => ['label' => 'Proteinuria', 'unit' => 'mg/dL', 'normal' => 30, 'warning' => 100, 'alert' => 300],
        'GPT' => ['label' => 'GPT (ALT)', 'unit' => 'U/L', 'normal' => 40, 'warning' => 80, 'alert' => 200],
        'GOT' => ['label' => 'GOT (AST)', 'unit' => 'U/L', 'normal' => 40, 'warning' => 80, 'alert' => 200],
        'gamma_GT' => ['label' => 'Gamma GT', 'unit' => 'U/L', 'normal' => 55, 'warning' => 100, 'alert' => 300],
        'Bil_T' => ['label' => 'Bilirubina totale', 'unit' => 'mg/dL', 'normal' => 1.2, 'warning' => 2.0, 'alert' => 3.0],
        'Bil_D' => ['label' => 'Bilirubina diretta', 'unit' => 'mg/dL', 'normal' => 0.3, 'warning' => 0.6, 'alert' => 1.0],
        'Bil_I' => ['label' => 'Bilirubina indiretta', 'unit' => 'mg/dL', 'normal' => 0.8, 'warning' => 1.2, 'alert' => 2.0],
        'Carotide_comune_sx' => ['label' => 'Carotide comune sx', 'unit' => 'mm', 'normal' => 0.9, 'warning' => 1.2, 'alert' => 1.5],
        'Carotide_comune_dx' => ['label' => 'Carotide comune dx', 'unit' => 'mm', 'normal' => 0.9, 'warning' => 1.2, 'alert' => 1.5],
        'Carotide_comune_sxc' => ['label' => 'Carotide comune sx (follow-up)', 'unit' => 'mm', 'normal' => 0.9, 'warning' => 1.2, 'alert' => 1.5],
        'Carotide_comune_dxc' => ['label' => 'Carotide comune dx (follow-up)', 'unit' => 'mm', 'normal' => 0.9, 'warning' => 1.2, 'alert' => 1.5],
        'Bulbo_sx' => ['label' => 'Bulbo sx', 'unit' => 'mm', 'normal' => 0.9, 'warning' => 1.2, 'alert' => 1.5],
        'Bulbo_dx' => ['label' => 'Bulbo dx', 'unit' => 'mm', 'normal' => 0.9, 'warning' => 1.2, 'alert' => 1.5],
        'Bulbo_sxc' => ['label' => 'Bulbo sx (follow-up)', 'unit' => 'mm', 'normal' => 0.9, 'warning' => 1.2, 'alert' => 1.5],
        'Bulbo_dxc' => ['label' => 'Bulbo dx (follow-up)', 'unit' => 'mm', 'normal' => 0.9, 'warning' => 1.2, 'alert' => 1.5],
        'Carotide_interna_sx' => ['label' => 'Carotide interna sx', 'unit' => 'mm', 'normal' => 0.9, 'warning' => 1.2, 'alert' => 1.5],
        'Carotide_interna_dx' => ['label' => 'Carotide interna dx', 'unit' => 'mm', 'normal' => 0.9, 'warning' => 1.2, 'alert' => 1.5],
        'Carotide_interna_sxc' => ['label' => 'Carotide interna sx (follow-up)', 'unit' => 'mm', 'normal' => 0.9, 'warning' => 1.2, 'alert' => 1.5],
        'Carotide_interna_dxc' => ['label' => 'Carotide interna dx (follow-up)', 'unit' => 'mm', 'normal' => 0.9, 'warning' => 1.2, 'alert' => 1.5],
        'imtsx' => ['label' => 'IMT sx', 'unit' => 'mm', 'normal' => 0.9, 'warning' => 1.2, 'alert' => 1.5],
        'imtdx' => ['label' => 'IMT dx', 'unit' => 'mm', 'normal' => 0.9, 'warning' => 1.2, 'alert' => 1.5],
        'imtcc' => ['label' => 'IMT segmento carotide comune', 'unit' => 'mm', 'normal' => 0.9, 'warning' => 1.2, 'alert' => 1.5],
        'imtci' => ['label' => 'IMT segmento carotide interna', 'unit' => 'mm', 'normal' => 0.9, 'warning' => 1.2, 'alert' => 1.5],
        'placcadxsten' => ['label' => 'Stenosi entità dx', 'unit' => '%', 'normal' => 0, 'warning' => 50, 'alert' => 70],
        'placcasxsten' => ['label' => 'Stenosi entità sx', 'unit' => '%', 'normal' => 0, 'warning' => 50, 'alert' => 70],
        'placcadx' => ['label' => 'Placca dx', 'unit' => 'mm'],
        'placcasx' => ['label' => 'Placca sx', 'unit' => 'mm'],
        'placcacc' => ['label' => 'Placca segmento carotide comune', 'unit' => 'mm'],
        'placcaci' => ['label' => 'Placca segmento carotide interna', 'unit' => 'mm'],
        'capqi' => ['label' => 'CAP/QI', 'unit' => null],
        'DOPPLERID' => ['label' => 'ID Doppler', 'unit' => null],
    ];

    public function handle(): int
    {
        foreach (self::FIELD_DEFINITIONS as $field => $definition) {
            $stats = DB::table('patient_visits')
                ->selectRaw("MIN(`{$field}`) as min_value, MAX(`{$field}`) as max_value, AVG(`{$field}`) as weighted_average")
                ->whereNotNull($field)
                ->first();

            FieldReferenceRange::query()->updateOrCreate(
                ['table' => 'patient_visits', 'field' => $field],
                [
                    'label' => $definition['label'],
                    'unit' => $definition['unit'] ?? null,
                    'min_value' => $stats?->min_value,
                    'max_value' => $stats?->max_value,
                    'weighted_average' => $stats?->weighted_average,
                    'normal_value' => $definition['normal'] ?? null,
                    'warning_value' => $definition['warning'] ?? null,
                    'alert_value' => $definition['alert'] ?? null,
                ]
            );
        }

        $this->components->info('Tabella field_reference_ranges aggiornata per '.count(self::FIELD_DEFINITIONS).' campi.');

        return self::SUCCESS;
    }
}
