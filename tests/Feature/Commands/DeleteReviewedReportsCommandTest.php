<?php

use App\Models\Report;
use Symfony\Component\Console\Output\BufferedOutput;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

beforeEach(function () {
    Log::spy();
});

/* Muestra un mensaje si no hay informes revisados */
it('shows message if there are no reviewed reports', function () {
    $output = new BufferedOutput();

    Artisan::call('delete:reviewed-reports', [], $output);

    $content = $output->fetch();
    expect($content)->toContain('No hay reportes revisados para eliminar.');
});

/* Elimina los informes revisados y registra cada eliminación */
it('deletes reviewed reports and logs each deletion', function () {
    $reviewed1 = Report::factory()->create(['status' => 'reviewed']);
    $reviewed2 = Report::factory()->create(['status' => 'reviewed']);
    $notReviewed = Report::factory()->create(['status' => 'pending']);

    $exitCode = Artisan::call('delete:reviewed-reports');
    $output = Artisan::output();

    expect($exitCode)->toEqual(0)
        ->and($output)->toContain("Se han eliminado 2 reportes revisados.")
        ->and(Report::where('status', 'reviewed')->count())->toEqual(0)
        ->and(Report::count())->toEqual(1);

    Log::shouldHaveReceived('info')->with("Reporte con ID {$reviewed1->id} eliminado.")->once();
    Log::shouldHaveReceived('info')->with("Reporte con ID {$reviewed2->id} eliminado.")->once();
});
