<?php

use App\Models\PdfDownload;
use App\Models\Post;
use App\Models\User;

/* Muestra una lista de usuarios que han descargado archivos PDF */
it('displays a list of users who have downloaded PDFs', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    PdfDownload::create([
        'user_id' => $user->id,
        'pdf_name' => 'Example PDF',
        'post_id' => $post->id
    ]);

    Artisan::call('pdf:downloads');

    $output = Artisan::output();

    expect($output)->toContain("Usuario {$user->name} ha descargado el pdf 'Example PDF'.");
});

/* Muestra un mensaje cuando no se han descargado archivos PDF */
it('displays a message when no PDFs have been downloaded', function () {
    PdfDownload::truncate();

    $this->artisan('pdf:downloads')
        ->expectsOutput('No se han registrado descargas de PDFs.')
        ->assertExitCode(0);
});
