<?php

namespace App\Console\Commands;

use App\Jobs\DeleteOldCommentsJob;
use Illuminate\Console\Command;

class DeleteOldCommentsCommand extends Command
{
    protected $signature = 'delete:old-comments';

    protected $description = 'Elimina comentarios antiguos';

    public function handle(): int
    {
        $this->info('Ejecutando limpieza de comentarios antiguos...');

        $jobResult = (new DeleteOldCommentsJob())->handle();

        if ($jobResult) {
            $this->info('Comentarios antiguos eliminados correctamente.');
        } else {
            $this->info('No se encontraron comentarios tan antiguos para eliminar.');
        }

        return Command::SUCCESS;
    }
}
