<?php

namespace App\Console\Commands;

use App\Models\Report;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteReviewedReportsCommand extends Command
{
    protected $signature = 'delete:reviewed-reports';
    protected $description = 'Eliminar todos los reportes que han sido revisados';

    public function handle(): void
    {
        $reports = Report::where('status', 'reviewed')->get();
        $count = $reports->count();

        if ($count === 0) {
            $this->info("No hay reportes revisados para eliminar.");
            return;
        }

        foreach ($reports as $report) {
            $report->delete();
            Log::info("Reporte con ID {$report->id} eliminado.");
        }

        $this->info("Se han eliminado {$count} reportes revisados.");
    }
}
