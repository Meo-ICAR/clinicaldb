<?php

namespace App\Filament\Resources\PatientVisits\Tables;

use App\Models\PatientVisit;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\QueryBuilder\Constraints\BooleanConstraint;
use Filament\QueryBuilder\Constraints\Constraint;
use Filament\QueryBuilder\Constraints\DateConstraint;
use Filament\QueryBuilder\Constraints\NumberConstraint;
use Filament\QueryBuilder\Constraints\TextConstraint;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer as XlsxWriter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PatientVisitsTable
{
    /**
     * Tracciato dell'export completo, identico per nome e posizione a quello del San Raffaele
     * ("Export SR"): [intestazione, colonne sorgente]. Con più sorgenti vale la prima valorizzata;
     * con null la colonna del tracciato SR non ha corrispondente a DB e resta vuota.
     * Le colonne SAS di patient_visits (i, k1, torv1…, repeatpaz…) sono quelle aggiunte dalla migrazione add_sas_columns.
     * Le colonne a DB non elencate vengono accodate.
     *
     * @var array<int, array{0: string, 1: array<int, string>|null}>
     */
    private const EXPORT_LAYOUT = [
        ['pazientecode', ['patients.pazientecode']],
        ['arruolato', ['patients.arruolato']],
        ['datanascita', ['patients.datanascita']],
        ['sesso', ['patients.sesso']],
        ['menopausa', ['patients.menopausa']],
        ['etnia_id', ['patients.etnia_id']],
        ['rischio_id', ['patients.rischio_id']],
        ['statocivile_id', ['patients.statocivile_id']],
        ['fumo_id', ['patients.fumo_id']],
        ['fumodurata', ['patients.fumodurata']],
        ['lavoro_id', ['patients.lavoro_id']],
        ['ictus_id', ['patients.ictus_id']],
        ['cardiopatie_id', ['patients.cardiopatie_id']],
        ['diabete_id', ['patients.diabete_id']],
        ['dislipidemie_id', ['patients.dislipidemie_id']],
        ['lipodistrofia_id', ['patients.lipodistrofia_id']],
        ['neoplasie_id', ['patients.neoplasie_id']],
        ['osteoporosi_id', ['patients.osteoporosi_id']],
        ['insuffrenale_id', ['patients.insuffrenale_id']],
        ['ormonali_id', ['patients.ormonali_id']],
        ['ipolipemizzanti_id', ['patients.ipolipemizzanti_id']],
        ['ipolipemizzantiquali', ['patients.ipolipemizzantiquali']],
        ['ipolipemizzantidamesi', ['patients.ipolipemizzantidamesi']],
        ['ipertensione_id', ['patients.ipertensione_id']],
        ['ipertensionefar_id', ['patients.ipertensionefar_id']],
        ['antidiabetici_id', ['patients.antidiabetici_id']],
        ['farmaci_id', ['patients.farmaci_id']],
        ['farmaciquali', ['patients.farmaciquali']],
        ['alcool_id', ['patients.alcool_id']],
        ['alcool35_id', ['patients.alcool35_id']],
        ['droghe_id', ['patients.droghe_id']],
        ['droghequali', ['patients.droghequali']],
        ['cirrosi_id', ['patients.cirrosi_id']],
        ['epatite_id', ['patients.epatite_id']],
        ['infezionehiv_id', ['patients.infezionehiv_id']],
        ['stadiocdc', ['patients.stadiocdc']],
        ['datahiv', ['patients.datahiv']],
        ['positivodal', ['patients.positivodal']],
        ['naive_id', ['patients.naive_id']],
        ['pi_id', ['patients.pi_id']],
        ['nrti_id', ['patients.nrti_id']],
        ['nnrti_id', ['patients.nnrti_id']],
        ['ini_id', ['patients.ini_id']],
        ['artaltro_id', ['patients.artaltro_id']],
        ['artterapie_id', ['patients.artterapie_id']],
        ['trattamentodal', ['patients.trattamentodal']],
        ['farmaciterapia', ['patients.farmaciterapia']],
        ['ultimaterapia', ['patients.ultimaterapia']],
        ['infezioni_id', ['patients.infezioni_id']],
        ['cd4', ['patient_visits.CD4_TSA', 'patients.CD4_TSA']],
        ['cd4nadir', ['patient_visits.NADIR_CD4_TSA', 'patients.NADIR_CD4_TSA']],
        ['cd4data', ['patients.cd4data']],
        ['altezza', ['patients.altezza']],
        ['commenti', ['patients.commenti']],
        ['visitadel', ['patient_visits.visitadel']],
        ['CD4_1', ['patient_visits.CD4']],
        ['CD4CD8', ['patient_visits.CD4_CD8_RAPP_TSA', 'patients.CD4_CD8_RAPP_TSA']],
        ['Trattamentovecchio', ['patient_visits.Trattamentovecchio']],
        ['trattamentocausaabbandono_id', ['patient_visits.trattamentocausaabbandono_id']],
        ['Trattamentonuovo', ['patient_visits.Trattamentonuovo']],
        ['Trattamentonuovodal', ['patient_visits.Trattamentonuovodal']],
        ['peso', ['patient_visits.peso']],
        ['circonferenza', ['patient_visits.circonferenza']],
        ['PAS', ['patient_visits.PAS']],
        ['Creatinina', ['patient_visits.Creatinina']],
        ['HIVRNA', ['patient_visits.HIVRNA']],
        ['HIVRNAnorilevabile', ['patient_visits.HIVRNAnorilevabile']],
        ['placcasxbordi', ['patient_visits.placcasxbordi']],
        ['placcadxbordi', ['patient_visits.placcadxbordi']],
        ['placcasxclivaggio', ['patient_visits.placcasxclivaggio']],
        ['placcadxclivaggio', ['patient_visits.placcadxclivaggio']],
        ['placcasxomogenea', ['patient_visits.placcasxomogenea']],
        ['placcadxomogenea', ['patient_visits.placcadxomogenea']],
        ['placcasxombra', ['patient_visits.placcasxombra']],
        ['placcdsxombra', ['patient_visits.placcdsxombra']],
        ['PAD', ['patient_visits.PAD']],
        ['Colesterolo', ['patient_visits.Colesterolo']],
        ['HDL', ['patient_visits.HDL']],
        ['LDL', ['patient_visits.LDL']],
        ['Trigliceridi', ['patient_visits.Trigliceridi']],
        ['Glicemia', ['patient_visits.Glicemia']],
        ['GPT', ['patient_visits.GPT']],
        ['GOT', ['patient_visits.GOT']],
        ['gamma_GT', ['patient_visits.gamma_GT']],
        ['ProteurinaFlag', ['patient_visits.ProteurinaFlag']],
        ['centro', ['patient_visits.centro']],
        ['centrocode', ['patient_visits.centrocode']],
        ['pazientecode_1', ['patient_visits.pazientecode']],
        ['annotazione', ['patient_visits.annotazione']],
        ['Carotide_comune_sx', ['patient_visits.Carotide_comune_sx']],
        ['Carotide_comune_dx', ['patient_visits.Carotide_comune_dx']],
        ['Bulbo_sx', ['patient_visits.Bulbo_sx']],
        ['Bulbo_dx', ['patient_visits.Bulbo_dx']],
        ['Carotide_interna_sx', ['patient_visits.Carotide_interna_sx']],
        ['Carotide_interna_dx', ['patient_visits.Carotide_interna_dx']],
        ['placche_sx', ['patient_visits.placche_sx']],
        ['placche_dx', ['patient_visits.placche_dx']],
        ['Carotide_comune_sxc', ['patient_visits.Carotide_comune_sxc']],
        ['Carotide_comune_dxc', ['patient_visits.Carotide_comune_dxc']],
        ['Bulbo_sxc', ['patient_visits.Bulbo_sxc']],
        ['Bulbo_dxc', ['patient_visits.Bulbo_dxc']],
        ['Carotide_interna_sxc', ['patient_visits.Carotide_interna_sxc']],
        ['Carotide_interna_dxc', ['patient_visits.Carotide_interna_dxc']],
        ['placche_sxc', ['patient_visits.placche_sxc']],
        ['placche_dxc', ['patient_visits.placche_dxc']],
        ['statocivile_id_1', ['patient_visits.statocivile_id']],
        ['statogen_id', ['patient_visits.statogen_id']],
        ['fumo_id_1', ['patient_visits.fumo_id']],
        ['AGE_TSA', ['patient_visits.AGE_TSA']],
        ['FDR', ['patient_visits.FDR']],
        ['NADIR_CD4_TSA', ['patient_visits.NADIR_CD4_TSA']],
        ['HCV_TSA', ['patient_visits.HCV_TSA']],
        ['HBV_TSA', ['patient_visits.HBV_TSA']],
        ['D_STATUS', ['patient_visits.D_STATUS']],
        ['TIME_SOP_TSA', ['patient_visits.TIME_SOP_TSA']],
        ['VIREMIA_TSA', ['patient_visits.VIREMIA_TSA']],
        ['CD4_CD8_RAPP_TSA', ['patient_visits.CD4_CD8_RAPP_TSA']],
        ['IDV_TSA', ['patient_visits.IDV_TSA']],
        ['SQV_TSA', ['patient_visits.SQV_TSA']],
        ['T_TSA', ['patient_visits.T_TSA']],
        ['FUMO', ['patient_visits.FUMO']],
        ['data_TSA', ['patient_visits.data_TSA']],
        ['PLACCA', ['patient_visits.PLACCA']],
        ['placca_dx', ['patient_visits.placca_dx']],
        ['placca_sx', ['patient_visits.placca_sx']],
        ['placca_bil', ['patient_visits.placca_bil']],
        ['placca_f', ['patient_visits.placca_f']],
        ['placca_c', ['patient_visits.placca_c']],
        ['placca_fc', ['patient_visits.placca_fc']],
        ['STENOsi', ['patient_visits.STENOsi']],
        ['F23', ['patient_visits.F23']],
        ['F24', ['patient_visits.F24']],
        ['bmi_tsa', ['patient_visits.bmi_tsa']],
        ['CVD_risk', ['patient_visits.CVD_risk']],
        ['Framingham_score', ['patient_visits.Framingham_score']],
        ['DAD_score', ['patient_visits.DAD_score']],
        ['D_CARDIO1', ['patient_visits.D_CARDIO1']],
        ['CARDIO1', ['patient_visits.CARDIO1']],
        ['D_CARDIO2', ['patient_visits.D_CARDIO2']],
        ['CARDIO2', ['patient_visits.CARDIO2']],
        ['placcasxecogen_id', ['patient_visits.placcasxecogen_id']],
        ['placcasxecogen_id_1', ['patient_visits.placcasxecogen_id']],
        ['placcasxstratosup', ['patient_visits.placcasxstratosup']],
        ['placcadxstratosup', ['patient_visits.placcadxstratosup']],
        ['placcasxstratopar', ['patient_visits.placcasxstratopar']],
        ['placcadxstratopar', ['patient_visits.placcadxstratopar']],
        ['placcasxsupendo_id', ['patient_visits.placcasxsupendo_id']],
        ['placcadxsupendo_id', ['patient_visits.placcadxsupendo_id']],
        ['placcasxclivaggio2', ['patient_visits.placcasxclivaggio2']],
        ['placcadxclivaggio2', ['patient_visits.placcadxclivaggio2']],
        ['capqi', ['patient_visits.capqi']],
        ['placcasxsten', ['patient_visits.placcasxsten']],
        ['placcadxsten', ['patient_visits.placcadxsten']],
        ['bictegravir', ['patient_visits.bictegravir']],
        ['capqi_1', ['patient_visits.capqi']],
        ['imtsx', ['patient_visits.imtsx']],
        ['imtdx', ['patient_visits.imtdx']],
        ['imtci', ['patient_visits.imtci']],
        ['imtcc', ['patient_visits.imtcc']],
        ['placcasx', ['patient_visits.placcasx']],
        ['placcadx', ['patient_visits.placcadx_clean']],
        ['placcaci', ['patient_visits.placcaci']],
        ['placcacc', ['patient_visits.placcacc']],
        ['archi', ['patient_visits.archi']],
        ['ident', ['patient_visits.pazientecode']],
        ['aids', ['patient_visits.aids']],
        ['annohiv', ['patient_visits.annohiv']],
        ['anni_hiv', ['patient_visits.YEARS_HIV_TSA', 'patients.YEARS_HIV_TSA']],
        ['annitarv', ['patient_visits.YEARS_ARV_TSA', 'patients.YEARS_ARV_TSA']],
        ['eta', ['patient_visits.eta']],
        ['alt_m', ['patients.altezza']],
        ['bmi', ['patient_visits.bmi']],
        ['sbp', ['patient_visits.PS_TSA', 'patients.PS_TSA', 'patient_visits.PAS']],
        ['dbp', ['patient_visits.PD_TSA', 'patients.PD_TSA', 'patient_visits.PAD']],
        ['pat1', ['patient_visits.pat1']],
        ['pat2', ['patient_visits.pat2']],
        ['pat3', ['patient_visits.pat3']],
        ['pat4', ['patient_visits.pat4']],
        ['pat5', ['patient_visits.pat5']],
        ['pat6', ['patient_visits.pat6']],
        ['pat6spec', ['patient_visits.pat6spec']],
        ['hcv', ['patient_visits.hcv']],
        ['hbv', ['patient_visits.hbv']],
        ['diabete', ['patient_visits.diabete']],
        ['risk', ['patient_visits.FDR', 'patients.FDR', 'patients.rischio_id']],
        ['i', ['patient_visits.i']],
        ['imt_sn', ['patient_visits.MIT_SX', 'patients.MIT_SX']],
        ['imt_dx', ['patient_visits.MIT_DX', 'patients.MIT_DX']],
        ['totarv', ['patient_visits.totarv']],
        ['_3tc', ['patient_visits.TC_TSA', 'patients.TC_TSA']],
        ['abc', ['patient_visits.ABC_TSA', 'patients.ABC_TSA']],
        ['tpv', ['patient_visits.TPV_TSA', 'patients.TPV_TSA']],
        ['atv', ['patient_visits.ATV_TSA', 'patients.ATV_TSA']],
        ['azt', ['patient_visits.AZT_TSA', 'patients.AZT_TSA']],
        ['dt', ['patient_visits.DT_TSA', 'patients.DT_TSA']],
        ['ddi', ['patient_visits.DDI_TSA', 'patients.DDI_TSA']],
        ['idv', ['patient_visits.IDV_TSA', 'patients.IDV_TSA']],
        ['drv', ['patient_visits.DRV_TSA', 'patients.DRV_TSA']],
        ['dTg', ['patient_visits.DVG_TSA', 'patients.DVG_TSA']],
        ['efv', ['patient_visits.EFV_TSA', 'patients.EFV_TSA']],
        ['etv', ['patient_visits.ETV_TSA', 'patients.ETV_TSA']],
        ['fpv', ['patient_visits.FPV_TSA', 'patients.FPV_TSA']],
        ['ftc', ['patient_visits.FTC_TSA', 'patients.FTC_TSA']],
        ['lpv', ['patient_visits.LPV_TSA', 'patients.LPV_TSA']],
        ['mrv', ['patient_visits.MRV_TSA', 'patients.MRV_TSA']],
        ['nfv', ['patient_visits.NFV_TSA', 'patients.NFV_TSA']],
        ['nvp', ['patient_visits.NVP_TSA', 'patients.NVP_TSA']],
        ['ral', ['patient_visits.RAL_TSA', 'patients.RAL_TSA']],
        ['evg', ['patient_visits.EVG_TSA', 'patients.EVG_TSA']],
        ['rpv', ['patient_visits.RPV_TSA', 'patients.RPV_TSA']],
        ['rtv', ['patient_visits.RTV_TSA', 'patients.RTV_TSA']],
        ['sqv', ['patient_visits.SQV_TSA', 'patients.SQV_TSA']],
        ['t', ['patient_visits.t']],
        ['tdf', ['patient_visits.TDF_TSA', 'patients.TDF_TSA']],
        ['cobi', ['patient_visits.COBI_TSA', 'patients.COBI_TSA']],
        ['regimen', ['patient_visits.Trattamentonuovo']],
        ['doravirina', ['patient_visits.doravirina']],
        ['dorav_', ['patient_visits.dorav_']],
        ['k1', ['patient_visits.k1']],
        ['k2', ['patient_visits.k2']],
        ['etnia', ['patients.etnia_id']],
        ['eGFR', ['patient_visits.EGFR_TSA', 'patients.EGFR_TSA']],
        ['provaq', ['patient_visits.provaq']],
        ['provaw', ['patient_visits.provaw']],
        ['creat', ['patient_visits.creat']],
        ['cd8', ['patient_visits.cd8']],
        ['d4t', ['patient_visits.d4t']],
        ['dor', ['patient_visits.dor']],
        ['bic', ['patient_visits.bic']],
        ['taf', ['patient_visits.taf']],
        ['cab_', ['patient_visits.cab_']],
        ['cab', ['patient_visits.cab']],
        ['nrti', ['patient_visits.NRTI_TSA', 'patients.NRTI_TSA']],
        ['nnrti', ['patient_visits.NNRTI_TSA', 'patients.NNRTI_TSA']],
        ['pi', ['patient_visits.pi']],
        ['insti', ['patient_visits.II_TSA', 'patients.II_TSA']],
        ['nrtipre', ['patient_visits.NRTI_TSA', 'patients.NRTI_TSA']],
        ['nnrtipre', ['patient_visits.NNRTI_TSA', 'patients.NNRTI_TSA']],
        ['instipre', ['patient_visits.II_TSA', 'patients.II_TSA']],
        ['pipre', ['patient_visits.PI_TSA', 'patients.PI_TSA']],
        ['annoarr', ['patient_visits.visitadel']],
        ['naive', ['patient_visits.NAIVE_TSA', 'patients.NAIVE_TSA']],
        ['cvd', ['patient_visits.cvd']],
        ['placcasntot', ['patient_visits.placcasntot']],
        ['placcadxtot', ['patient_visits.placcadxtot']],
        ['placcatot', ['patient_visits.placcatot']],
        ['n_placca', ['patient_visits.n_placca']],
        ['placcasn', ['patient_visits.placcasn']],
        ['stensi', ['patient_visits.stensi']],
        ['pladx', ['patient_visits.pladx']],
        ['pladx1', ['patient_visits.pladx1']],
        ['plasx', ['patient_visits.plasx']],
        ['plasx1', ['patient_visits.plasx1']],
        ['plasx2', ['patient_visits.plasx2']],
        ['plabis', ['patient_visits.plabis']],
        ['placcachar', ['patient_visits.placcachar']],
        ['ispessdx', ['patient_visits.ispessdx']],
        ['ispesssn', ['patient_visits.ispesssn']],
        ['placcat', ['patient_visits.placcat']],
        ['ispess', ['patient_visits.ispess']],
        ['ipertensione', ['patient_visits.ipertensione']],
        ['cat_imt', ['patient_visits.cat_imt']],
        ['repeatpaz', ['patient_visits.repeatpaz']],
        ['statin_', ['patient_visits.statin_']],
        ['torv1', ['patient_visits.torv1']],
        ['torv2', ['patient_visits.torv2']],
        ['torv3', ['patient_visits.torv3']],
        ['torv4', ['patient_visits.torv4']],
        ['torv5', ['patient_visits.torv5']],
        ['torv6', ['patient_visits.torv6']],
        ['torv7', ['patient_visits.torv7']],
        ['statine', ['patient_visits.STATIN_ON', 'patients.STATIN_ON']],
        ['anyipolip', ['patient_visits.anyipolip']],
        ['altripolip', ['patient_visits.FIBRATO_ON', 'patients.FIBRATO_ON']],
        ['ipolipemizzanti', ['patient_visits.ipolipemizzanti']],
        ['dislipidemia', ['patient_visits.dislipidemia']],
        ['htfar', ['patient_visits.IPER_ON', 'patients.IPER_ON']],
        ['centroext', ['patient_visits.centro']],
        ['annovisita', ['patient_visits.visitadel']],
        ['singlepaz', ['patient_visits.singlepaz']],
        ['biktarvy', ['patient_visits.biktarvy']],
    ];

    /**
     * Colonne del tracciato SR che a DB non esistono come tali e si ricavano da altre:
     * flag farmaco "SIGLA/" da *_TSA, regimen come elenco ordinato delle sigle, totarv come
     * numero di farmaci, annoarr/annovisita come anno della visita, alt_m in metri, naive;
     * archi esce come archi - 1 (nel tracciato SR vale 0 dove a DB vale 1);
     * annitarv in valore assoluto (a DB ci sono anni di terapia negativi).
     *
     * @var array<string, string>
     */
    private const EXPORT_DRUG_LABELS = [
        '_3tc' => '3TC',
        'abc' => 'ABC',
        'tpv' => 'TPV',
        'atv' => 'ATV',
        'azt' => 'AZT',
        'dt' => 'D4T',
        'ddi' => 'DDI',
        'idv' => 'IDV',
        'drv' => 'DRV',
        'dTg' => 'DTG',
        'efv' => 'EFV',
        'etv' => 'ETV',
        'fpv' => 'FVP',
        'ftc' => 'FTC',
        'lpv' => 'LPV',
        'mrv' => 'MRV',
        'nfv' => 'NFV',
        'nvp' => 'NVP',
        'ral' => 'RAL',
        'evg' => 'EVG',
        'rpv' => 'RPV',
        'rtv' => 'RTV',
        'sqv' => 'SQV',
        'tdf' => 'TDF',
        'cobi' => 'COBI',
    ];

    /**
     * Ordine delle sigle nella colonna regimen (come nel tracciato SR: NRTI, NNRTI, PI, INSTI, booster).
     *
     * @var array<int, string>
     */
    private const EXPORT_REGIMEN_ORDER = ['3TC', 'ABC', 'AZT', 'D4T', 'DDI', 'FTC', 'EFV', 'ETV', 'NVP', 'RPV', 'TDF', 'ATV', 'DRV', 'FVP', 'IDV', 'LPV', 'NFV', 'SQV', 'TPV', 'DTG', 'EVG', 'RAL', 'MRV', 'RTV', 'COBI'];

    /**
     * Raggruppamento del fattore di rischio HIV nelle 4 categorie del tracciato SR
     * (colonna risk); il dettaglio resta in rischio_id.
     *
     * @var array<string, string>
     */
    private const EXPORT_RISK_GROUPS = [
        'omosessuale' => 'Sexual',
        'eterosessuale' => 'Sexual',
        'bisessuale' => 'Sexual',
        'partner hiv+' => 'Sexual',
        'tossicodipendente' => 'IDU',
        'ex-tossicodipendente' => 'IDU',
        'duplice (td/etero)' => 'IDU',
        'duplice (td/omo)' => 'IDU',
        'trasfuso' => 'Transfusion',
        'emofiliaco' => 'Transfusion',
        'non noto' => 'other/unknown',
        'altro' => 'other/unknown',
    ];

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('patient.pazientecode')->label(__('filament/admin/patient_visit_resource.patient.pazientecode'))->searchable()->sortable(),
                TextColumn::make('visitadel')->label(__('filament/admin/patient_visit_resource.visitadel'))->date('d/m/Y')->sortable(),
                TextColumn::make('centrocode')->label(__('filament/admin/patient_visit_resource.centrocode'))->searchable(),
                TextColumn::make('CD4')->label(__('filament/admin/patient_visit_resource.c_d4'))->numeric()->sortable(),
                TextColumn::make('HIVRNA')->label(__('filament/admin/patient_visit_resource.h_i_v_r_n_a'))->numeric()->sortable(),
                TextColumn::make('peso')->label(__('filament/admin/patient_visit_resource.peso'))->numeric(),
                IconColumn::make('HIVRNAnorilevabile')->label(__('filament/admin/patient_visit_resource.h_i_v_r_n_anorilevabile'))->boolean(),
                IconColumn::make('active')->label(__('filament/admin/patient_visit_resource.active'))->boolean(),
            ])
            ->headerActions([
                ExportAction::make()->label(__('filament/admin/patient_visit_resource.export')),
                self::fullExportAction(),
            ])
            ->defaultSort('visitadel', 'desc')
            ->recordActions([EditAction::make()
                ->label(__('filament/admin/patient_visit_resource.edit'))])
            ->modifyQueryUsing(fn (Builder $query): Builder => self::applyAnomalyFilter($query))
            ->filters([
                SelectFilter::make('centrocode')
                    ->label(__('filament/admin/patient_visit_resource.centrocode'))
                    ->options(fn (): array => DB::table('centers')->orderBy('center')->pluck('center', 'centercode')->all())
                    ->searchable()
                    ->default(fn (): ?string => auth()->user()?->centercode),
                ...self::queryBuilderFiltersByType(),
            ])
            ->filtersFormWidth(Width::TwoExtraLarge)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label(__('filament/admin/patient_visit_resource.delete_bulk')),
                ]),
            ]);
    }

    /**
     * Export denormalizzato visite + paziente nel tracciato SR (vedi EXPORT_LAYOUT): rispetta i
     * filtri attivi della tabella. Scrive l'xlsx in streaming con OpenSpout: pxlrbt/PhpSpreadsheet
     * con ~300 colonne per riga è troppo lento e pesante sull'intero archivio.
     */
    private static function fullExportAction(): Action
    {
        return Action::make('export_full')
            ->label(__('filament/admin/patient_visit_resource.export_full'))
            ->icon('heroicon-o-arrow-down-tray')
            ->action(function (HasTable $livewire): BinaryFileResponse {
                $existing = [
                    'patients' => Schema::getColumnListing('patients'),
                    'patient_visits' => Schema::getColumnListing('patient_visits'),
                ];
                $realName = function (string $source) use ($existing): ?string {
                    [$table, $column] = explode('.', $source, 2);

                    return collect($existing[$table])->first(fn (string $name): bool => strcasecmp($name, $column) === 0);
                };

                $spec = [];
                $used = [];
                $headers = [];

                foreach (self::EXPORT_LAYOUT as [$header, $sources]) {
                    $resolved = collect($sources ?? [])
                        ->map(fn (string $source): ?string => ($name = $realName($source)) ? explode('.', $source, 2)[0].'.'.$name : null)
                        ->filter()
                        ->values()
                        ->all();
                    $used = [...$used, ...$resolved];
                    $headers[strtolower($header)] = true;
                    $spec[] = ['header' => $header, 'sources' => $resolved];
                }

                $tail = [
                    ...array_map(fn (string $column): string => "patient_visits.{$column}", $existing['patient_visits']),
                    ...array_map(fn (string $column): string => "patients.{$column}", $existing['patients']),
                ];

                foreach (array_diff($tail, $used) as $source) {
                    [$table, $column] = explode('.', $source, 2);
                    $header = $table === 'patients' ? "patients_{$column}" : $column;

                    while (isset($headers[strtolower($header)])) {
                        $header .= '_2';
                    }

                    $headers[strtolower($header)] = true;
                    $spec[] = ['header' => $header, 'sources' => [$source]];
                }

                $select = [];

                foreach ($spec as $index => $column) {
                    $columns = array_map(fn (string $source): string => '`'.str_replace('.', '`.`', $source).'`', $column['sources']);
                    $expression = match (count($columns)) {
                        0 => 'NULL',
                        1 => $columns[0],
                        default => 'COALESCE('.implode(', ', $columns).')',
                    };
                    $select[] = DB::raw("{$expression} as `c{$index}`");
                }

                $query = PatientVisit::query()
                    ->join('patients', 'patient_visits.patient_id', '=', 'patients.id')
                    ->select($select)
                    ->whereIn('patient_visits.id', $livewire->getFilteredTableQuery()->reorder()->select('patient_visits.id'))
                    ->orderBy('patient_visits.id');

                $path = tempnam(sys_get_temp_dir(), 'export_full_').'.xlsx';

                $writer = new XlsxWriter;
                $writer->openToFile($path);
                $writer->addRow(Row::fromValues(array_column($spec, 'header')));

                $headerIndex = array_flip(array_column($spec, 'header'));

                foreach ($query->toBase()->cursor() as $record) {
                    $values = array_map(fn (int $index): mixed => $record->{"c{$index}"} ?? null, array_keys($spec));

                    foreach (self::EXPORT_DRUG_LABELS as $header => $label) {
                        $index = $headerIndex[$header];
                        $values[$index] = filled($values[$index]) && $values[$index] != 0 ? "{$label}/" : null;
                    }

                    $labels = array_values(array_filter(
                        self::EXPORT_REGIMEN_ORDER,
                        fn (string $label): bool => filled($values[$headerIndex[array_search($label, self::EXPORT_DRUG_LABELS, true)]]),
                    ));

                    if ($labels !== []) {
                        $values[$headerIndex['regimen']] = implode('/', $labels).'/';
                        $values[$headerIndex['totarv']] = count($labels);
                    }

                    foreach (['annoarr', 'annovisita'] as $header) {
                        $values[$headerIndex[$header]] = filled($values[$headerIndex[$header]]) ? substr((string) $values[$headerIndex[$header]], 0, 4) : null;
                    }

                    $values[$headerIndex['alt_m']] = filled($values[$headerIndex['alt_m']]) ? round($values[$headerIndex['alt_m']] / 100, 2) : null;
                    $annitarv = $values[$headerIndex['annitarv']];
                    $values[$headerIndex['annitarv']] = is_numeric(str_replace(',', '.', (string) $annitarv)) ? abs((float) str_replace(',', '.', (string) $annitarv)) : $annitarv;
                    $risk = $values[$headerIndex['risk']];
                    $values[$headerIndex['risk']] = blank($risk) ? null : (self::EXPORT_RISK_GROUPS[mb_strtolower(trim((string) $risk))] ?? 'other/unknown');
                    $archi = $values[$headerIndex['archi']];
                    $values[$headerIndex['archi']] = blank($archi) ? null : $archi - 1;
                    $naive = $values[$headerIndex['naive']];
                    $values[$headerIndex['naive']] = blank($naive) ? null : ($naive == 1 ? 'Naive' : 'Experienced');

                    $writer->addRow(Row::fromValues($values));
                }

                $writer->close();

                return response()->download($path, 'visite_pazienti_'.now()->format('Ymd_His').'.xlsx')->deleteFileAfterSend();
            });
    }

    /**
     * Applica il filtro "?rr_field=&rr_min=&rr_max=" usato dai link della schermata
     * Range di riferimento per individuare le visite con valori anomali su un campo.
     */
    private static function applyAnomalyFilter(Builder $query): Builder
    {
        $field = request()->query('rr_field');

        if (blank($field) || ! is_string($field) || ! Schema::hasColumn('patient_visits', $field)) {
            return $query;
        }

        $min = request()->query('rr_min');
        $max = request()->query('rr_max');
        $min = is_numeric($min) ? (float) $min : null;
        $max = is_numeric($max) ? (float) $max : null;

        if ($min !== null && $max !== null) {
            return $query->whereBetween($field, [min($min, $max), max($min, $max)]);
        }

        if ($min !== null) {
            return $query->where($field, '>=', $min);
        }

        if ($max !== null) {
            return $query->where($field, '<=', $max);
        }

        return $query;
    }

    /**
     * Un QueryBuilder separato per ciascun tipo di dato (Booleano, Data, Numero, Testo),
     * invece di un unico selettore con tutti i ~200 campi mescolati: ogni "Aggiungi
     * regola" mostra così solo i campi del proprio tipo, ordinati alfabeticamente.
     *
     * @return array<int, QueryBuilder>
     */
    private static function queryBuilderFiltersByType(): array
    {
        return collect(Schema::getColumns('patient_visits'))
            ->map(fn (array $column): array => self::constraintDataForColumn($column))
            ->sortBy(['group', 'label'])
            ->groupBy('group')
            ->map(fn (Collection $constraints, string $group): QueryBuilder => QueryBuilder::make("query_builder_{$group}")
                ->label("Filtri: {$group}")
                ->constraints($constraints->pluck('constraint')->values()->all()))
            ->values()
            ->all();
    }

    /**
     * @param  array{name: string, type_name: string, type: string, comment: ?string}  $column
     * @return array{group: string, label: string, constraint: Constraint}
     */
    private static function constraintDataForColumn(array $column): array
    {
        $name = $column['name'];
        $label = filled($column['comment']) ? Str::before($column['comment'], '.') : Str::headline($name);

        if ($column['type_name'] === 'tinyint' && $column['type'] === 'tinyint(1)') {
            return ['group' => 'Booleano', 'label' => $label, 'constraint' => BooleanConstraint::make($name)->label($label)];
        }

        if (in_array($column['type_name'], ['bigint', 'int', 'smallint', 'tinyint', 'float', 'double', 'decimal'], true)) {
            return ['group' => 'Numero', 'label' => $label, 'constraint' => NumberConstraint::make($name)->label($label)];
        }

        if (in_array($column['type_name'], ['date', 'datetime', 'timestamp'], true)) {
            return ['group' => 'Data', 'label' => $label, 'constraint' => DateConstraint::make($name)->label($label)];
        }

        return ['group' => 'Testo', 'label' => $label, 'constraint' => TextConstraint::make($name)->label($label)];
    }
}
