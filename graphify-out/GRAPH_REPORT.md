# Graph Report - app  (2026-10-05)

## Corpus Check
- Corpus is ~22,758 words - fits in a single context window. You may not need a graph.

## Summary
- 1505 nodes · 3081 edges · 190 communities (53 shown, 137 thin omitted)
- Extraction: 100% EXTRACTED · 0% INFERRED · 0% AMBIGUOUS
- Token cost: 0 input · 0 output

## Community Hubs (Navigation)
- Form Schemas (Lookups)
- Lookup Resource Base
- Patients Table Filters
- App Switcher Widget
- Panel Provider & Auth
- User Model
- Reference Ranges Table
- Treatment Annotations & Users Tables
- Recent Patients Widget
- Visit & Range Forms
- ArtAltro/Epatite/Etnia Pages
- Visit Relation Managers
- User Management Pages
- PatientVisit Model
- Infezione Resource
- Rischio Pages
- Archiprevaleat Sync Service
- User Manual & Prompt Pages
- Lookup Tables (Alcool35...)
- Field Reference Range Resource
- Artisan Commands
- Center/Ecogenicita Forms
- Patient Visit Pages
- Dashboard & Visits Table
- Bulk-Action Tables
- Delete-Action Tables
- Edit-Action Tables
- AlcoolResource group
- AntidiabeticoResource group
- ArtTerapiaResource group
- CardiopatiaResource group
- CenterResource group
- CirrosiResource group
- DiabeteResource group
- DislipidemiaResource group
- DrogaResource group
- EcogenicitaResource group
- EndolumialeResource group
- FarmacoResource group
- FumoResource group
- IctusResource group
- InfezioneHivResource group
- IniResource group
- InsuffrenaleResource group
- IpertensioneResource group
- IpolipemizzanteResource group
- LavoroResource group
- LipodistrofiaResource group
- NeoplasiaResource group
- NrtiResource group
- OsteoporosiResource group
- CreatePi group
- CreateStatoCivile group
- CreateStenosi group
- CreateTip group
- CreateTrattamentoCausaAbbandono group
- CreateTrattamento group
- Date & Patient Forms
- ListCenters group
- Welcome Notification
- Patient Policy
- Patient Model
- Lookup Models
- Edit Pages & EditUser
- Patient Resource
- Alcool35Resource group
- ListAlcool35s group
- EditAlcool35 group
- TipForm group
- ListAlcools group
- ListAntidiabeticos group
- ArtAltroResource group
- ListArtAltros group
- ListArtTerapias group
- EditCardiopatia group
- ListCirrosis group
- EditDiabete group
- EditDislipidemia group
- EditDroga group
- EditEcogenicita group
- EditEndolumiale group
- EpatiteResource group
- EditEpatite group
- ListEpatites group
- EtniaResource group
- EditEtnia group
- ListEtnias group
- EditFarmaco group
- ListFieldReferenceRanges group
- ListFumos group
- ListIctuses group
- EditInfezioneHiv group
- EditIni group
- EditInsuffrenale group
- EditIpertensione group
- EditIpolipemizzante group
- ListLipodistrofias group
- NaiveResource group
- EditNaive group
- ListNaives group
- EditNeoplasia group
- NnrtiResource group
- EditNnrti group
- ListNnrtis group
- ListNrtis group
- ListOsteoporosis group
- EditPatient group
- ListPatients group
- PatientForm group
- PatientsTable group
- EditPatientVisit group
- ListPis group
- EditSino group
- ListSinos group
- SinoResource group
- ListStatoCiviles group
- EditStatogen group
- ListStatogens group
- StatogenResource group
- ListStenosis group
- EditTip group
- ListTrattamentoCausaAbbandonos group
- EditTrattamento group
- App Service Provider
- ArtTerapiaForm group
- CardiopatiasTable group
- CentersTable group
- CirrosisTable group
- DiabetesTable group
- DislipidemiasTable group
- DrogasTable group
- EndolumialesTable group
- EtniasTable group
- FumosTable group
- IctusesTable group
- InfezionesTable group
- InisTable group
- InsuffrenalesTable group
- IpertensionesTable group
- IpolipemizzantesTable group
- LipodistrofiaForm group
- CreateNaive group
- NeoplasiaForm group
- NeoplasiasTable group
- NnrtiForm group
- NnrtisTable group
- NrtisTable group
- OsteoporosisTable group
- PiForm group
- PisTable group
- RischiosTable group
- CreateStatogen group
- StatogensTable group
- TrattamentosTable group
- Alcool group
- Antidiabetico group
- ArtAltro group
- ArtTerapia group
- Cardiopatia group
- Center group
- Diabete group
- Droga group
- Ecogenicita group
- Endolumiale group
- Etnia group
- Farmaco group
- Fumo group
- Ictus group
- Infezione group
- InfezioneHiv group
- Ini group
- Insuffrenale group
- Ipertensione group
- Ipolipemizzante group
- Lavoro group
- Lipodistrofia group
- Naive group
- Neoplasia group
- Nnrti group
- Nrti group
- Osteoporosi group
- Pi group
- Rischio group
- Sino group
- StatoCivile group
- Statogen group
- Stenosi group
- Tip group
- Trattamento group
- TrattamentoCausaAbbandono group

## God Nodes (most connected - your core abstractions)
1. `LookupResource` - 87 edges
2. `User` - 43 edges
3. `LookupModel` - 42 edges
4. `PatientVisit` - 22 edges
5. `Patient` - 19 edges
6. `FieldReferenceRange` - 18 edges
7. `PatientResource` - 17 edges
8. `PatientVisitResource` - 16 edges
9. `UserResource` - 15 edges
10. `FieldReferenceRangeResource` - 14 edges

## Surprising Connections (you probably didn't know these)
- `{closure#1}()` --references--> `User`  [EXTRACTED]
  Filament/Resources/Users/Tables/UsersTable.php → Models/User.php
- `{closure#9}()` --references--> `User`  [EXTRACTED]
  Filament/Resources/Users/Tables/UsersTable.php → Models/User.php
- `{closure#1}()` --references--> `FieldReferenceRange`  [EXTRACTED]
  Filament/Resources/FieldReferenceRanges/Tables/FieldReferenceRangesTable.php → Models/FieldReferenceRange.php
- `{closure#2}()` --references--> `FieldReferenceRange`  [EXTRACTED]
  Filament/Resources/FieldReferenceRanges/Tables/FieldReferenceRangesTable.php → Models/FieldReferenceRange.php
- `{closure#3}()` --references--> `FieldReferenceRange`  [EXTRACTED]
  Filament/Resources/FieldReferenceRanges/Tables/FieldReferenceRangesTable.php → Models/FieldReferenceRange.php

## Import Cycles
- None detected.

## Communities (190 total, 137 thin omitted)

### Community 0 - "Form Schemas (Lookups)"
Cohesion: 0.03
Nodes (30): Alcool35Form, AlcoolForm, AntidiabeticoForm, ArtAltroForm, CardiopatiaForm, CirrosiForm, DiabeteForm, DislipidemiaForm (+22 more)

### Community 2 - "Patients Table Filters"
Cohesion: 0.08
Nodes (4): {closure#4}(), {closure#1}(), {closure#14}(), {closure#4}()

### Community 3 - "App Switcher Widget"
Cohesion: 0.08
Nodes (7): AppSwitcherWidget, {closure#1}(), SsoTokenApiController, Controller, SaveSentEmailToImap, ExternalAppResolver, SsoTokenBroker

### Community 4 - "Panel Provider & Auth"
Cohesion: 0.08
Nodes (3): EditProfile, AdminPanelProvider, {closure#1}()

### Community 5 - "User Model"
Cohesion: 0.09
Nodes (4): {closure#1}(), {closure#3}(), {closure#4}(), User

### Community 6 - "Reference Ranges Table"
Cohesion: 0.13
Nodes (8): {closure#1}(), {closure#2}(), {closure#3}(), {closure#4}(), {closure#5}(), {closure#6}(), FieldReferenceRangesTable, FieldReferenceRange

### Community 7 - "Treatment Annotations & Users Tables"
Cohesion: 0.15
Nodes (13): {closure#1}(), {closure#2}(), {closure#3}(), {closure#4}(), {closure#1}(), {closure#10}(), {closure#3}(), {closure#4}() (+5 more)

### Community 8 - "Recent Patients Widget"
Cohesion: 0.14
Nodes (10): {closure#3}(), {closure#4}(), {closure#1}(), {closure#2}(), {closure#3}(), RecentlyModifiedPatients, {closure#1}(), {closure#2}() (+2 more)

### Community 9 - "Visit & Range Forms"
Cohesion: 0.15
Nodes (4): {closure#1}(), {closure#6}(), {closure#7}(), {closure#9}()

### Community 10 - "ArtAltro/Epatite/Etnia Pages"
Cohesion: 0.15
Nodes (6): CreateArtAltro, CreateEpatite, CreateEtnia, CreateNnrti, CreateSino, CreateUser

### Community 11 - "Visit Relation Managers"
Cohesion: 0.12
Nodes (3): TreatmentAnnotationsRelationManager, VisitsRelationManager, PatientVisitForm

### Community 12 - "User Management Pages"
Cohesion: 0.12
Nodes (4): ListUsers, UserForm, UsersTable, UserResource

### Community 13 - "PatientVisit Model"
Cohesion: 0.20
Nodes (5): {closure#1}(), {closure#2}(), {closure#3}(), PatientVisit, PatientVisitPolicy

### Community 14 - "Infezione Resource"
Cohesion: 0.14
Nodes (4): InfezioneResource, CreateInfezione, EditInfezione, ListInfeziones

### Community 15 - "Rischio Pages"
Cohesion: 0.14
Nodes (4): CreateRischio, EditRischio, ListRischios, RischioResource

### Community 18 - "Lookup Tables (Alcool35...)"
Cohesion: 0.12
Nodes (5): Alcool35sTable, EcogenicitasTable, LavorosTable, NaivesTable, StenosisTable

### Community 19 - "Field Reference Range Resource"
Cohesion: 0.14
Nodes (4): FieldReferenceRangeResource, CreateFieldReferenceRange, EditFieldReferenceRange, FieldReferenceRangeForm

### Community 20 - "Artisan Commands"
Cohesion: 0.20
Nodes (3): ArchiprevaleatSyncCommand, CreatePatientBaselineVisits, SeedFieldReferenceRanges

### Community 21 - "Center/Ecogenicita Forms"
Cohesion: 0.14
Nodes (4): CenterForm, EcogenicitaForm, EndolumialeForm, StenosiForm

### Community 24 - "Bulk-Action Tables"
Cohesion: 0.15
Nodes (4): AlcoolsTable, AntidiabeticosTable, SinosTable, StatoCivilesTable

### Community 25 - "Delete-Action Tables"
Cohesion: 0.15
Nodes (4): ArtTerapiasTable, EpatitesTable, TipsTable, TrattamentoCausaAbbandonosTable

### Community 26 - "Edit-Action Tables"
Cohesion: 0.15
Nodes (4): ArtAltrosTable, FarmacosTable, InfezioneHivsTable, LipodistrofiasTable

### Community 27 - "AlcoolResource group"
Cohesion: 0.20
Nodes (3): AlcoolResource, CreateAlcool, EditAlcool

### Community 28 - "AntidiabeticoResource group"
Cohesion: 0.20
Nodes (3): AntidiabeticoResource, CreateAntidiabetico, EditAntidiabetico

### Community 29 - "ArtTerapiaResource group"
Cohesion: 0.20
Nodes (3): ArtTerapiaResource, CreateArtTerapia, EditArtTerapia

### Community 30 - "CardiopatiaResource group"
Cohesion: 0.20
Nodes (3): CardiopatiaResource, CreateCardiopatia, ListCardiopatias

### Community 31 - "CenterResource group"
Cohesion: 0.20
Nodes (3): CenterResource, CreateCenter, EditCenter

### Community 32 - "CirrosiResource group"
Cohesion: 0.20
Nodes (3): CirrosiResource, CreateCirrosi, EditCirrosi

### Community 33 - "DiabeteResource group"
Cohesion: 0.20
Nodes (3): DiabeteResource, CreateDiabete, ListDiabetes

### Community 34 - "DislipidemiaResource group"
Cohesion: 0.20
Nodes (3): DislipidemiaResource, CreateDislipidemia, ListDislipidemias

### Community 35 - "DrogaResource group"
Cohesion: 0.20
Nodes (3): DrogaResource, CreateDroga, ListDrogas

### Community 36 - "EcogenicitaResource group"
Cohesion: 0.20
Nodes (3): EcogenicitaResource, CreateEcogenicita, ListEcogenicitas

### Community 37 - "EndolumialeResource group"
Cohesion: 0.20
Nodes (3): EndolumialeResource, CreateEndolumiale, ListEndolumiales

### Community 38 - "FarmacoResource group"
Cohesion: 0.20
Nodes (3): FarmacoResource, CreateFarmaco, ListFarmacos

### Community 39 - "FumoResource group"
Cohesion: 0.20
Nodes (3): FumoResource, CreateFumo, EditFumo

### Community 40 - "IctusResource group"
Cohesion: 0.20
Nodes (3): IctusResource, CreateIctus, EditIctus

### Community 41 - "InfezioneHivResource group"
Cohesion: 0.20
Nodes (3): InfezioneHivResource, CreateInfezioneHiv, ListInfezioneHivs

### Community 42 - "IniResource group"
Cohesion: 0.20
Nodes (3): IniResource, CreateIni, ListInis

### Community 43 - "InsuffrenaleResource group"
Cohesion: 0.20
Nodes (3): InsuffrenaleResource, CreateInsuffrenale, ListInsuffrenales

### Community 44 - "IpertensioneResource group"
Cohesion: 0.20
Nodes (3): IpertensioneResource, CreateIpertensione, ListIpertensiones

### Community 45 - "IpolipemizzanteResource group"
Cohesion: 0.20
Nodes (3): IpolipemizzanteResource, CreateIpolipemizzante, ListIpolipemizzantes

### Community 46 - "LavoroResource group"
Cohesion: 0.20
Nodes (3): LavoroResource, CreateLavoro, EditLavoro

### Community 47 - "LipodistrofiaResource group"
Cohesion: 0.20
Nodes (3): LipodistrofiaResource, CreateLipodistrofia, EditLipodistrofia

### Community 48 - "NeoplasiaResource group"
Cohesion: 0.20
Nodes (3): NeoplasiaResource, CreateNeoplasia, ListNeoplasias

### Community 49 - "NrtiResource group"
Cohesion: 0.20
Nodes (3): NrtiResource, CreateNrti, EditNrti

### Community 50 - "OsteoporosiResource group"
Cohesion: 0.20
Nodes (3): OsteoporosiResource, CreateOsteoporosi, EditOsteoporosi

### Community 51 - "CreatePi group"
Cohesion: 0.20
Nodes (3): CreatePi, EditPi, PiResource

### Community 52 - "CreateStatoCivile group"
Cohesion: 0.20
Nodes (3): CreateStatoCivile, EditStatoCivile, StatoCivileResource

### Community 53 - "CreateStenosi group"
Cohesion: 0.20
Nodes (3): CreateStenosi, EditStenosi, StenosiResource

### Community 54 - "CreateTip group"
Cohesion: 0.20
Nodes (3): CreateTip, ListTips, TipResource

### Community 55 - "CreateTrattamentoCausaAbbandono group"
Cohesion: 0.20
Nodes (3): CreateTrattamentoCausaAbbandono, EditTrattamentoCausaAbbandono, TrattamentoCausaAbbandonoResource

### Community 56 - "CreateTrattamento group"
Cohesion: 0.20
Nodes (3): CreateTrattamento, ListTrattamentos, TrattamentoResource

### Community 62 - "Lookup Models"
Cohesion: 0.20
Nodes (5): Alcool35, Cirrosi, Dislipidemia, Epatite, LookupModel

## Knowledge Gaps
- **137 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `LookupResource` connect `Lookup Resource Base` to `Recent Patients Widget`, `Infezione Resource`, `Rischio Pages`, `User Manual & Prompt Pages`, `AlcoolResource group`, `AntidiabeticoResource group`, `ArtTerapiaResource group`, `CardiopatiaResource group`, `CenterResource group`, `CirrosiResource group`, `DiabeteResource group`, `DislipidemiaResource group`, `DrogaResource group`, `EcogenicitaResource group`, `EndolumialeResource group`, `FarmacoResource group`, `FumoResource group`, `IctusResource group`, `InfezioneHivResource group`, `IniResource group`, `InsuffrenaleResource group`, `IpertensioneResource group`, `IpolipemizzanteResource group`, `LavoroResource group`, `LipodistrofiaResource group`, `NeoplasiaResource group`, `NrtiResource group`, `OsteoporosiResource group`, `CreatePi group`, `CreateStatoCivile group`, `CreateStenosi group`, `CreateTip group`, `CreateTrattamentoCausaAbbandono group`, `CreateTrattamento group`, `Alcool35Resource group`, `TipForm group`, `ArtAltroResource group`, `EpatiteResource group`, `EtniaResource group`, `NaiveResource group`, `NnrtiResource group`, `SinoResource group`, `StatogenResource group`?**
  _High betweenness centrality (0.075) - this node is a cross-community bridge._
- **Should `Form Schemas (Lookups)` be split into smaller, more focused modules?**
  _Cohesion score 0.029304029304029304 - nodes in this community are weakly interconnected._
- **Why does `User` connect `User Model` to `Panel Provider & Auth`, `Treatment Annotations & Users Tables`, `PatientVisit Model`, `User Manual & Prompt Pages`, `Welcome Notification`, `Patient Policy`, `Patient Model`?**
  _High betweenness centrality (0.066) - this node is a cross-community bridge._
- **Should `Patients Table Filters` be split into smaller, more focused modules?**
  _Cohesion score 0.07936507936507936 - nodes in this community are weakly interconnected._
- **Why does `PatientVisit` connect `PatientVisit Model` to `Patients Table Filters`, `Recent Patients Widget`, `Archiprevaleat Sync Service`, `User Manual & Prompt Pages`, `Artisan Commands`?**
  _High betweenness centrality (0.032) - this node is a cross-community bridge._
- **Should `App Switcher Widget` be split into smaller, more focused modules?**
  _Cohesion score 0.07862903225806452 - nodes in this community are weakly interconnected._
- **Should `Panel Provider & Auth` be split into smaller, more focused modules?**
  _Cohesion score 0.07526881720430108 - nodes in this community are weakly interconnected._