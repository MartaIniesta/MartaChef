<?php

namespace App\Console\Commands;

use App\Models\PdfDownload;
use Illuminate\Console\Command;

class ListPdfDownloadsCommand extends Command
{
    protected $signature = 'pdf:downloads';
    protected $description = 'Muestra una lista de usuarios que han descargado PDFs';

    public function handle()
    {
        $downloads = PdfDownload::with('user')->get();

        if ($downloads->isEmpty()) {
            $this->info('No se han registrado descargas de PDFs.');
            return 0;
        }

        foreach ($downloads as $download) {
            $this->line("Usuario {$download->user->name} ha descargado el pdf '{$download->pdf_name}'.");
        }

        return 0;
    }
}
