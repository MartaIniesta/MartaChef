<?php

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\{Post, User};
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->post = Post::factory()->create(['title' => 'Mi Receta']);
});

it('downloads an existing PDF for authenticated users and logs the download', function () {
    loginAsUser($this->user);

    $pdf = PDF::loadHTML('<h1>Contenido de la receta</h1>');
    $pdfTitle = str_replace(' ', '_', $this->post->title);
    $pdfPath = "pdf/Receta_{$pdfTitle}.pdf";

    Storage::disk('public')->put($pdfPath, $pdf->output());

    $response = $this->get(route('posts.pdf', $this->post));

    Storage::disk('public')->assertExists($pdfPath);

    $response->assertOk()
        ->assertHeader('Content-Type', 'application/pdf');

    $this->assertDatabaseHas('pdf_downloads', [
        'user_id' => $this->user->id,
        'post_id' => $this->post->id,
        'pdf_name' => "Receta_{$pdfTitle}.pdf",
    ]);
});

it('returns 404 if PDF does not exist', function () {
    loginAsUser($this->user);

    Storage::fake('public');

    Log::shouldReceive('error')
        ->once()
        ->withArgs(fn ($message) => str_contains($message, 'El PDF de la receta con el título'));

    $response = $this->get(route('posts.pdf', $this->post));

    $response->assertNotFound();
});

it('unauthenticated users cannot download a pdf', function () {
    Auth::logout();

    $response = $this->get(route('posts.pdf', $this->post));

    $response->assertRedirect(route('login'));
});
