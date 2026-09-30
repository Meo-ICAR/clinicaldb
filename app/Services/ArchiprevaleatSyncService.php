<?php

namespace App\Services;

use App\Models\PatientVisit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ArchiprevaleatSyncService
{
    /**
     * Esegue la sincronizzazione batch di tutta la tabella patient_visits.
     */
    public function syncAll(int $chunkSize = 500): int
    {
        $count = 0;

        DB::table('patient_visits')
            ->join('patients', 'patient_visits.patient_id', '=', 'patients.id')
            ->select('patient_visits.*', 
                'patients.datanascita as p_datanascita',
                'patients.sesso as p_sesso',
                'patients.etnia_id as p_etnia_id',
                'patients.rischio_id as p_rischio_id',
                'patients.fumo_id as p_fumo_id',
                'patients.fumodurata as p_fumodurata',
                'patients.altezza as p_altezza',
                'patients.datahiv as p_datahiv',
                'patients.positivodal as p_positivodal',
                'patients.ictus_id as p_ictus_id',
                'patients.cardiopatie_id as p_cardiopatie_id',
                'patients.diabete_id as p_diabete_id',
                'patients.epatite_id as p_epatite_id',
                'patients.ipertensione_id as p_ipertensione_id',
                'patients.ipertensionefar_id as p_ipertensionefar_id',
                'patients.ipolipemizzanti_id as p_ipolipemizzanti_id',
                'patients.ipolipemizzantiquali as p_ipolipemizzantiquali',
                'patients.stadiocdc as p_stadiocdc'
            )
            ->orderBy('patient_visits.id')
            ->chunk($chunkSize, function ($rows) use (&$count) {
                foreach ($rows as $row) {
                    $rowArray = (array) $row;
                    $transformed = $this->transformRow($rowArray);

                    if (!empty($transformed)) {
                        DB::table('patient_visits')
                            ->where('id', $rowArray['id'])
                            ->update($transformed);
                        $count++;
                    }
                }
            });

        return $count;
    }

    /**
     * Normalizza e aggiorna una singola istanza del modello Eloquent PatientVisit.
     */
    public function normalizeVisitModel(PatientVisit $visit): void
    {
        if (!$visit->relationLoaded('patient')) {
            $visit->load('patient');
        }

        $p = $visit->patient;
        if (!$p) {
            return;
        }

        $row = array_merge($visit->toArray(), [
            'p_datanascita'          => $p->datanascita ?? null,
            'p_sesso'                => $p->sesso ?? null,
            'p_etnia_id'             => $p->etnia_id ?? null,
            'p_rischio_id'           => $p->rischio_id ?? null,
            'p_fumo_id'              => $p->fumo_id ?? null,
            'p_fumodurata'           => $p->fumodurata ?? null,
            'p_altezza'              => $p->altezza ?? null,
            'p_datahiv'              => $p->datahiv ?? null,
            'p_positivodal'          => $p->positivodal ?? null,
            'p_ictus_id'             => $p->ictus_id ?? null,
            'p_cardiopatie_id'       => $p->cardiopatie_id ?? null,
            'p_diabete_id'           => $p->diabete_id ?? null,
            'p_epatite_id'           => $p->epatite_id ?? null,
            'p_ipertensione_id'      => $p->ipertensione_id ?? null,
            'p_ipertensionefar_id'   => $p->ipertensionefar_id ?? null,
            'p_ipolipemizzanti_id'   => $p->ipolipemizzanti_id ?? null,
            'p_ipolipemizzantiquali' => $p->ipolipemizzantiquali ?? null,
            'p_stadiocdc'            => $p->stadiocdc ?? null,
        ]);

        $transformed = $this->transformRow($row);

        if (!empty($transformed)) {
            foreach ($transformed as $key => $value) {
                $visit->{$key} = $value;
            }
        }
    }

   /**
     * Trasforma un array di dati grezzi applicando tutte le regole di calcolo e sanificazione.
     */
    public function transformRow(array $row): array
    {
        $visitDate = !empty($row['visitadel']) ? Carbon::parse($row['visitadel']) : null;
        $birthDate = !empty($row['p_datanascita']) ? Carbon::parse($row['p_datanascita']) : null;

        // 1. Età e Dati Generali (Guard per date incoerenti o etá negative)
        $eta = null;
        if ($visitDate && $birthDate && $visitDate->gte($birthDate)) {
            $calculatedEta = (int) $birthDate->diffInYears($visitDate);
            if ($calculatedEta >= 0 && $calculatedEta <= 120) {
                $eta = $calculatedEta;
            }
        }
        
        $altezzaM = (!empty($row['p_altezza']) && $row['p_altezza'] > 0) ? ($row['p_altezza'] / 100) : null;
        $peso = !empty($row['peso']) && $row['peso'] > 0 ? (float)$row['peso'] : null;
        $bmi = ($peso && $altezzaM) ? round($peso / ($altezzaM * $altezzaM), 2) : null;

        $sbp = !empty($row['PAS']) ? (int)$row['PAS'] : null;
        $dbp = !empty($row['PAD']) ? (int)$row['PAD'] : null;

        // 2. Storia HIV e Terapia (Guard per intervalli negativi)
        $dataHiv = !empty($row['p_datahiv']) ? Carbon::parse($row['p_datahiv']) : (!empty($row['p_positivodal']) ? Carbon::parse($row['p_positivodal']) : null);
        $annoHiv = $dataHiv ? (int)$dataHiv->year : null;
        
        $anniHiv = null;
        if ($visitDate && $dataHiv && $visitDate->gte($dataHiv)) {
            $anniHiv = round($visitDate->diffInDays($dataHiv) / 365.25, 2);
        }

        $inizioArv = !empty($row['Trattamentonuovodal']) ? Carbon::parse($row['Trattamentonuovodal']) : (!empty($row['INIZIO_ARV']) ? Carbon::parse($row['INIZIO_ARV']) : null);
        
        $anniTarv = null;
        if ($visitDate && $inizioArv && $visitDate->gte($inizioArv)) {
            $anniTarv = round($visitDate->diffInDays($inizioArv) / 365.25, 2);
        }

        $aids = (!empty($row['p_stadiocdc']) && strtoupper($row['p_stadiocdc']) === 'C') ? 1 : 0;
        $regimen = $row['Trattamentonuovo'] ?? null;

        // Analisi classi farmaci
        $regimenUpper = strtoupper($regimen ?? '');
        $nrti = (preg_match('/(3TC|FTC|TDF|TAF|ABC|AZT)/i', $regimenUpper)) ? 1 : 0;
        $nnrti = (preg_match('/(EFV|NVP|RPV|ETV|DOR)/i', $regimenUpper)) ? 1 : 0;
        $pi = (preg_match('/(DRV|ATV|LPV|SQV|RTV)/i', $regimenUpper)) ? 1 : 0;
        $insti = (preg_match('/(DTG|BIC|RAL|EVG)/i', $regimenUpper)) ? 1 : 0;
        $doravirina = (strpos($regimenUpper, 'DOR') !== false) ? 1 : 0;

        // 3. Laboratorio ed eGFR
        $creat = !empty($row['Creatinina']) && $row['Creatinina'] > 0 ? (float)$row['Creatinina'] : null;
        $sesso = strtoupper($row['p_sesso'] ?? 'M');
        $egfr = $this->calculateEgfr($creat, $eta, $sesso);

        // 4. Stile di vita e Comorbilità
        $fumoClean = $this->parseFumo($row['p_fumo_id'] ?? $row['fumo_id'] ?? null);
        $hcv = (!empty($row['p_epatite_id']) && strpos(strtoupper((string)$row['p_epatite_id']), 'C') !== false) ? 1 : 0;
        $hbv = (!empty($row['p_epatite_id']) && strpos(strtoupper((string)$row['p_epatite_id']), 'B') !== false) ? 1 : 0;
        $diabete = (!empty($row['p_diabete_id']) && $row['p_diabete_id'] != '0') ? 1 : 0;
        
        $ipertensione = (!empty($row['p_ipertensione_id']) && $row['p_ipertensione_id'] != '0') ? 'S' : 'N';
        $htfar = (!empty($row['p_ipertensionefar_id']) && $row['p_ipertensionefar_id'] != '0') ? 1 : 0;
        
        $statine = (preg_match('/STATIN/i', $row['p_ipolipemizzantiquali'] ?? '')) ? 1 : 0;
        $ipolipemizzanti = (!empty($row['p_ipolipemizzanti_id']) && $row['p_ipolipemizzanti_id'] != '0') ? 1 : 0;

        // 5. IMT e Calcoli Carotidei
        $imtSnValues = array_filter([
            $row['Carotide_interna_sx'] ?? null, $row['Carotide_comune_sx'] ?? null, $row['Bulbo_sx'] ?? null,
            $row['Carotide_comune_sxc'] ?? null, $row['Bulbo_sxc'] ?? null, $row['Carotide_interna_sxc'] ?? null
        ], fn($v) => $v !== null && $v > 0);

        $imtDxValues = array_filter([
            $row['Carotide_interna_dx'] ?? null, $row['Carotide_comune_dx'] ?? null, $row['Bulbo_dx'] ?? null,
            $row['Carotide_comune_dxc'] ?? null, $row['Bulbo_dxc'] ?? null, $row['Carotide_interna_dxc'] ?? null
        ], fn($v) => $v !== null && $v > 0);

        $imtSn = !empty($imtSnValues) ? max($imtSnValues) : null;
        $imtDx = !empty($imtDxValues) ? max($imtDxValues) : null;

        $placcaDxClean = (($imtDx !== null && $imtDx > 1.2) || ($row['placcadxbordi'] ?? 0) == 1 || ($row['placcadxclivaggio'] ?? 0) == 1 || ($row['placcadxomogenea'] ?? 0) == 1) ? 'S' : 'N';
        $placcaSnClean = (($imtSn !== null && $imtSn > 1.2) || ($row['placcasxbordi'] ?? 0) == 1 || ($row['placcasxclivaggio'] ?? 0) == 1 || ($row['placcasxomogenea'] ?? 0) == 1) ? 'S' : 'N';

        $placcat = ($placcaDxClean === 'S' || $placcaSnClean === 'S') ? 'S' : 'N';
        
        $ispessDx = (($imtDx !== null && $imtDx > 1.0) || $placcaDxClean === 'S') ? 'S' : 'N';
        $ispessSn = (($imtSn !== null && $imtSn > 1.0) || $placcaSnClean === 'S') ? 'S' : 'N';
        $ispess = ($ispessDx === 'S' || $ispessSn === 'S') ? 'S' : 'N';

        $catImt = 0;
        if ($placcat === 'S') {
            $catImt = 2; // Placca
        } elseif ($ispess === 'S') {
            $catImt = 1; // Ispessimento IMT
        }

        return [
            'archi'           => $row['archi'] ?? 1,
            'centroext'       => $row['centro'] ?? null,
            'eta'             => $eta,
            'bmi'             => $bmi,
            'sbp'             => $sbp,
            'dbp'             => $dbp,
            'annohiv'         => $annoHiv,
            'anni_hiv'        => $anniHiv,
            'annitarv'        => $anniTarv,
            'aids'            => $aids,
            'risk'            => $row['p_rischio_id'] ?? null,
            'regimen'         => $regimen,
            'nrti'            => $nrti,
            'nnrti'           => $nnrti,
            'pi'              => $pi,
            'insti'           => $insti,
            'doravirina'      => $doravirina,
            'egfr'            => $egfr,
            'creat'           => $creat,
            'cd8'             => !empty($row['CD8_TSA']) ? (int)$row['CD8_TSA'] : null,
            'fumo_clean'      => $fumoClean,
            'hcv'             => $hcv,
            'hbv'             => $hbv,
            'diabete'         => $diabete,
            'ipertensione'    => $ipertensione,
            'htfar'           => $htfar,
            'statine'         => $statine,
            'ipolipemizzanti' => $ipolipemizzanti,
            'imt_sn'          => $imtSn,
            'imt_dx'          => $imtDx,
            'placcadx_clean'  => $placcaDxClean,
            'placcasn_clean'  => $placcaSnClean,
            'placcat'         => $placcat,
            'ispessdx'        => $ispessDx,
            'ispesssn'        => $ispessSn,
            'ispess'          => $ispess,
            'cat_imt'         => $catImt,
        ];
    }
    /**
     * Calcola la stima eGFR basata sulla Creatinina Sferica (Formula CKD-EPI).
     */
    private function calculateEgfr(?float $creat, ?int $eta, string $sesso): ?float
    {
        if (!$creat || !$eta) {
            return null;
        }

        $k = ($sesso === 'F') ? 0.7 : 0.9;
        $alpha = ($sesso === 'F') ? -0.329 : -0.411;
        $genderMultiplier = ($sesso === 'F') ? 1.018 : 1.0;

        $min = min($creat / $k, 1);
        $max = max($creat / $k, 1);

        $egfr = 141 * pow($min, $alpha) * pow($max, -1.209) * pow(0.993, $eta) * $genderMultiplier;

        return round($egfr, 2);
    }

    /**
     * Normalizza il valore del fumo in un piccolo intero (0=No, 1=Ex, 2=Sì).
     */
    private function parseFumo(?string $fumoRaw): ?int
    {
        if ($fumoRaw === null) {
            return null;
        }

        $f = strtoupper((string)$fumoRaw);
        if ($f === '1' || strpos($f, 'SI') !== false || strpos($f, 'YES') !== false) {
            return 2; // Fumatore attivo
        }
        if ($f === '2' || strpos($f, 'EX') !== false) {
            return 1; // Ex fumatore
        }
        if ($f === '0' || strpos($f, 'NO') !== false) {
            return 0; // Non fumatore
        }

        return null;
    }
}
