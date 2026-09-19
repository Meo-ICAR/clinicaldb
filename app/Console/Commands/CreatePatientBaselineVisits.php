<?php

namespace App\Console\Commands;

use App\Models\Patient;
use App\Models\PatientVisit;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('patients:create-baseline-visits')]
#[Description('Crea una visita fittizia iniziale per ogni paziente e vi trasferisce i valori dei campi basali (esame TSA) duplicati tra patients e patient_visits, senza modificare i dati originali del paziente. Comando idempotente: rieseguibile in sicurezza.')]
class CreatePatientBaselineVisits extends Command
{
    private const BASELINE_ANNOTATION = 'Visita fittizia generata automaticamente per la migrazione dei dati basali (TSA) dal record paziente.';

    /**
     * Colonne presenti sia in patients sia in patient_visits che rappresentano dati
     * basali (esame TSA e affini) duplicati tra le due tabelle.
     *
     * @var array<int, string>
     */
    private const DUPLICATED_FIELDS = [
        'ABC_TSA',
        'AGE_TSA',
        'ALP_TSA',
        'ALT_TSA',
        'AST_TSA',
        'ATV_TSA',
        'AZT_TSA',
        'BILDIR_TSA',
        'BILIND_TSA',
        'BILTOT_TSA',
        'CALCIO_TSA',
        'CARDIO1',
        'CARDIO2',
        'CD4_CD8_RAPP_TSA',
        'CD4_TSA',
        'CD8_TSA',
        'COBI_TSA',
        'COLEST_TSA',
        'COLHDL_TSA',
        'COLLDL_TSA',
        'CREA_TSA',
        'CVD_risk',
        'DAD_score',
        'DDI_TSA',
        'DRV_TSA',
        'DT_TSA',
        'DVG_TSA',
        'D_AIDS',
        'D_CARDIO1',
        'D_CARDIO2',
        'D_DECESSO',
        'D_DIABETE',
        'D_HIV',
        'D_STATUS',
        'EFV_TSA',
        'EGFR_TSA',
        'ETV_TSA',
        'EVG_TSA',
        'FDR',
        'FIBRATO_EVER',
        'FIBRATO_ON',
        'FIB_TSA',
        'FI_TSA',
        'FOSFORO_TSA',
        'FPV_TSA',
        'FTC_TSA',
        'FUMO',
        'Framingham_score',
        'GLU_TSA',
        'HBV_TSA',
        'HCV_TSA',
        'HOMA_TSA',
        'Hb_TSA',
        'IDV_TSA',
        'II_TSA',
        'INIZIO_ARV',
        'INSULINA_TSA',
        'IPER_EVER',
        'IPER_ON',
        'LESIONE_BIF',
        'LESIONE_BIL',
        'LPV_TSA',
        'MIT_DX',
        'MIT_SX',
        'MRV_TSA',
        'NADIR_CD4_TSA',
        'NAIVE_TSA',
        'NFV_TSA',
        'NNRTI_TSA',
        'NRTI_TSA',
        'NVP_TSA',
        'PD_TSA',
        'PESO_TSA',
        'PI_TSA',
        'PLACCA',
        'PLT_TSA',
        'PS_TSA',
        'RAL_TSA',
        'RPV_TSA',
        'RTV_TSA',
        'SPE_TSA',
        'SQV_TSA',
        'STATIN_EVER',
        'STATIN_ON',
        'STENOsi',
        'TC_TSA',
        'TDF_TSA',
        'TIME_SOP_TSA',
        'TPV_TSA',
        'TRIG_TSA',
        'T_TSA',
        'VIREMIA_TSA',
        'YEARS_ARV_TSA',
        'YEARS_HIV_TSA',
        'bmi_tsa',
        'data_TSA',
        'lesione_DX',
        'lesione_SX',
        'lesione_c',
        'lesione_f',
        'lesione_fc',
        'placca_bil',
        'placca_c',
        'placca_dx',
        'placca_f',
        'placca_fc',
        'placca_sx',
    ];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $alreadyMigrated = PatientVisit::query()
            ->where('annotazione', self::BASELINE_ANNOTATION)
            ->pluck('patient_id')
            ->flip();

        $patients = Patient::query()->orderBy('id')->get();

        $created = 0;
        $skipped = 0;

        $this->output->progressStart($patients->count());

        foreach ($patients as $patient) {
            if ($alreadyMigrated->has($patient->id)) {
                $skipped++;
                $this->output->progressAdvance();

                continue;
            }

            $data = [
                'patient_id' => $patient->id,
                'visitadel' => $patient->arruolato ?? now()->toDateString(),
                'centro' => $patient->centro,
                'centrocode' => $patient->centrocode,
                'pazientecode' => $patient->pazientecode,
                'active' => $patient->active,
                'annotazione' => self::BASELINE_ANNOTATION,
            ];

            foreach (self::DUPLICATED_FIELDS as $field) {
                $data[$field] = $patient->getAttribute($field);
            }

            PatientVisit::query()->create($data);

            $created++;
            $this->output->progressAdvance();
        }

        $this->output->progressFinish();

        $this->components->info("Visite fittizie create: {$created}. Pazienti già con visita basale (saltati): {$skipped}.");

        return self::SUCCESS;
    }
}
