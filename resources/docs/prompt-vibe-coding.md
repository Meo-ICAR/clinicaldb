# Prompt di contesto per vibe coding — ClinicalDB

Incolla questo prompt all'inizio di una sessione con un assistente AI (Claude Code o simili) prima di
chiedere nuove funzionalità su questo progetto, così l'assistente parte con il contesto corretto invece
di doverlo dedurre da zero o assumere convenzioni standard di Laravel che qui non valgono.

---

## Stack e contesto

- Laravel 13, PHP 8.4, Filament 5 (namespace `Filament\Schemas\*`, `Filament\Forms\Components\*`,
  `Filament\Tables\*`), MySQL.
- Il database **non è stato creato da questo progetto Laravel**: è uno schema legacy (centinaia di
  colonne su `patients` e `patient_visits`, decine di tabelle di lookup a riga singola tipo
  `fumos`, `statociviles`, ecc.) importato da una vecchia applicazione. Le migration Laravel esistenti
  NON coprono queste tabelle: `php artisan migrate` a secco fallisce perché prova a ricreare `users` e
  simili. Per applicare una nuova migration, usare sempre
  `php artisan migrate --path=database/migrations/<file>.php` mirato al singolo file.
- I commenti di colonna nello schema DB sono già scritti in italiano e sono affidabili: usali per
  capire il significato di un campo prima di indovinare dal nome della colonna.

## Convenzioni da rispettare

- **Timestamp**: le tabelle legacy (`patients`, `patient_visits`, `users`) usano colonne
  `created`/`modified` (non `created_at`/`updated_at`), dichiarate nel model con
  `public const CREATED_AT = 'created'; public const UPDATED_AT = 'modified';`. Le tabelle
  genuinamente nuove create da questo progetto (es. `field_reference_ranges`, `socialite_users`)
  usano invece i timestamp standard di Laravel. Verifica sempre quale convenzione si applica prima di
  scrivere una migration.
- **Chiavi primarie**: `users.id` è un UUID (char 36), non un intero autoincrementante. Il model
  `User` dichiara `public $incrementing = false; protected $keyType = 'string';` — se mai crei un
  altro model con chiave UUID, ricordati di fare lo stesso, altrimenti `getKey()` si rompe
  silenziosamente e qualunque cosa passi per la serializzazione dei job in coda (notifiche
  `ShouldQueue` incluse) può finire sul record sbagliato per coercizione implicita di MySQL.
- **Mass assignment**: i model usano `protected $guarded = ['id'];`, non `$fillable`. Non aggiungere
  l'attributo PHP `#[Fillable([...])]` sopra un model che ha già `$guarded`: se `getFillable()` non è
  vuoto, Eloquent ignora `$guarded` e passa in modalità allowlist, scartando silenziosamente tutti gli
  altri campi.
- **Risorse Filament**: ogni resource è divisa in `Schemas/{Nome}Form.php`, `Tables/{Nome}Table.php`,
  `Pages/*`. Le label sono in italiano; i campi numerici con un'unità di misura nota la riportano nel
  label, es. `->label('CD4 (cell/µL)')`.
- **Etichette e opzioni delle select su tabelle di lookup**: molte tabelle di lookup hanno come unica
  colonna `id`, senza descrizione separata: il valore stesso di `id` è l'etichetta da mostrare
  (pattern `DB::table($table)->orderBy('id')->pluck('id', 'id')->all()`). Alcune lookup (es.
  `ecogenicitas`, `stenosis`, `endolumiales`) hanno invece solo ID numerici senza etichette testuali:
  in quei casi le etichette leggibili sono hardcoded nel codice Filament con un commento che segnala
  che sono proposte e vanno validate da un clinico.
- **Duplicazione dati paziente/visita**: `patients` e `patient_visits` condividono ~120 nomi di
  colonna. La maggior parte (campi `*_TSA`, terapie, esami) rappresenta **lo stesso concetto tracciato
  nel tempo**: su `patients` è uno snapshot storico (spesso della prima visita), su `patient_visits` è
  il valore per quella specifica visita. Non è un bug da "deduplicare": è un pattern di
  denormalizzazione intenzionale del vecchio sistema.
- **Soglie cliniche**: la tabella `field_reference_ranges` contiene min/max/media (calcolati dai dati
  reali, comando `patients:seed-field-reference-ranges`) e le soglie normal/warning/alert (valori di
  letteratura, inseriti manualmente, mai calcolati automaticamente). La direzione (valore alto o basso
  patologico) si deduce confrontando `warning_value` con `normal_value`
  (`FieldReferenceRange::direction()`), non va assunta.
- **Formattazione**: dopo ogni modifica a file PHP esegui `vendor/bin/pint --dirty --format agent`
  prima di considerare il lavoro concluso.
- **Verifica**: questo progetto non ha una suite di test che copra i resource Filament (il DB di test
  in `phpunit.xml` è uno sqlite in memoria che non ha le tabelle legacy). Per verificare che una
  pagina Filament funzioni, monta il componente Livewire reale via tinker
  (`Livewire::test(EditPatient::class, ['record' => $id])`) con un utente autenticato reale, non
  fidarti solo della costruzione dello schema.

## Cosa NON fare

- Non introdurre `$fillable` o l'attributo `#[Fillable]` su model esistenti.
- Non assumere che `created_at`/`updated_at` esistano su tabelle legacy.
- Non filtrare gli elenchi (liste pazienti/visite) per centro utente per default: la regola attuale è
  "tutti vedono tutto, solo la modifica/eliminazione è ristretta al proprio centro o ai propri record"
  (vedi `PatientPolicy` / `PatientVisitPolicy`).
- Non eseguire `php artisan migrate` senza `--path` su questo progetto.

---

*Documento generato per accompagnare le sessioni di sviluppo assistito da AI su questo progetto. Va
aggiornato quando cambiano le convenzioni sopra descritte.*
