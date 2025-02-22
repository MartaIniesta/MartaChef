<?php

use App\Jobs\SendDownloadedPdfJob;
use App\Models\{Post, User};
use Illuminate\Support\Facades\{Log, Storage};
use Barryvdh\DomPDF\Facade\Pdf;

beforeEach(function () {
    Storage::fake('public');
});

it('generates a pdf of the publication', function () {
    // Arrange
    $user = User::factory()->create();
    $post = Post::factory()->create(['title' => 'Mi Receta']);

    loginAsUser($user);

    Pdf::shouldReceive('loadView')->once()->andReturnSelf();
    Pdf::shouldReceive('output')->once()->andReturn('pdf-content');

    // Act
    $job = new SendDownloadedPdfJob($post, $user);
    $job->handle();

    // Assert
    $pdfPath = 'pdf/Receta_Mi_Receta.pdf';
    Storage::disk('public')->assertExists($pdfPath);
});

it('logs the correct message when the PDF is generated', function () {
    // Arrange
    $user = User::factory()->create();
    $post = Post::factory()->create(['title' => 'Mi Receta']);

    loginAsUser($user);

    Log::shouldReceive('info')
        ->once()
        ->with("Usuario {$user->name} ha solicitado la generación del PDF de la receta con id: {$post->id}.");

    Log::shouldReceive('info')
        ->once()
        ->with("PDF generado y guardado correctamente en: pdf/Receta_Mi_Receta.pdf");

    Pdf::shouldReceive('loadView')->once()->andReturnSelf();
    Pdf::shouldReceive('output')->once()->andReturn('pdf-content');

    // Act
    $job = new SendDownloadedPdfJob($post, $user);
    $job->handle();
});
