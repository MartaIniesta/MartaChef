<?php

use App\Livewire\Moderator\ModeratorReports;
use App\Models\Report;
use Livewire\Livewire;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

uses(LazilyRefreshDatabase::class);

/* Marca un reporte como revisado */
it('marks a report as reviewed', function () {
    $report = Report::factory()->create(['status' => 'pending']);

    Livewire::test(ModeratorReports::class)
        ->call('markAsReviewed', $report->id);

    assertDatabaseHas('reports', [
        'id' => $report->id,
        'status' => 'reviewed',
    ]);
});

/* Elimina un solo reporte */
it('deletes a single report', function () {
    $report = Report::factory()->create();

    Livewire::test(ModeratorReports::class)
        ->call('deleteReport', $report->id);

    assertDatabaseMissing('reports', ['id' => $report->id]);
});

/* Llama al comando para eliminar los informes revisados y establece el mensaje */
it('calls artisan command to delete reviewed reports and sets message', function () {
    Report::factory()->create();

    Artisan::spy();

    Artisan::shouldReceive('call')
        ->once()
        ->with('delete:reviewed-reports');

    Artisan::shouldReceive('output')
        ->andReturn('Reviewed reports deleted.');

    Livewire::test(ModeratorReports::class)
        ->call('deleteReviewedReports')
        ->assertSet('deleteMessage', 'Reviewed reports deleted.');
});

/* Representa la vista del componente */
it('renders the component view', function () {
    Livewire::test(ModeratorReports::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.moderator.moderator-reports');
});
