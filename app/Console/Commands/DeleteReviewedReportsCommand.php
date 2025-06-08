<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteReviewedReportsCommand extends Command
{
    protected $signature = 'delete:reviewed-reports';
    protected $description = 'Eliminar todos los reportes que han sido revisados';

    public function handle(): void
    {
        $reportIds = DB::table('reports')->where('status', 'reviewed')->pluck('id');

        $count = $reportIds->count();

        if ($count === 0) {
            $this->info("No hay reportes revisados para eliminar.");
            return;
        }

        DB::table('reports')->whereIn('id', $reportIds)->delete();

        foreach ($reportIds as $id) {
            Log::info("Reporte con ID {$id} eliminado.");
        }

        $this->info("Se han eliminado {$count} reportes revisados.");
    }
}
