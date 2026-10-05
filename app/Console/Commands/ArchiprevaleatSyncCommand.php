<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ArchiprevaleatSyncService;

class ArchiprevaleatSyncCommand extends Command
{
    /**
     * Il nome e la firma del comando da terminale.
     */
    protected $signature = 'archiprevaleat:sync 
                            {--table=patient_visits : La tabella da sincronizzare} 
                            {--chunk=500 : Dimensione del chunk per la sincronizzazione}';

    /**
     * Descrizione del comando.
     */
    protected $description = 'Sincronizza e calcola i campi derivati per la tabella patient_visits';

    /**
     * Esecuzione del comando.
     */
    public function handle(ArchiprevaleatSyncService $syncService): int
    {
        $table = $this->option('table');
        $chunk = (int) $this->option('chunk');

        if ($table !== 'patient_visits') {
            $this->error("Tabella '{$table}' non supportata. Tabella valida: patient_visits");
            return Command::FAILURE;
        }

        $this->info("Avvio sincronizzazione per '{$table}' (chunk: {$chunk})...");

        $updated = $syncService->syncAll($chunk);

        $this->info("Completato! Registri aggiornati: {$updated}");

        return Command::SUCCESS;
    }
}
