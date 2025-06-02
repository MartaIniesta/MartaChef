<?php

use App\Models\{Post, User};
use Illuminate\Support\Facades\Storage;

/* Descarga un PDF y crea un registro PdfDownload para usuarios autenticados */
it('downloads a pdf and creates a PdfDownload record for authenticated users', function () {
    Storage::disk('public')->put(
        'tarta-fresas.png',
        file_get_contents(base_path('storage/app/public/images/tarta-fresas.png'))
    );

    $post = Post::factory()->create([
        'title' => 'Mi receta especial',
        'image' => 'tarta-fresas.png',
    ]);

    $user = User::factory()->create();

    loginAsUser($user);

    $response = $this->get(route('posts.pdf', $post));

    $response->assertStatus(200);
    $response->assertHeader('content-type', 'application/pdf');

    $this->assertDatabaseHas('pdf_downloads', [
        'user_id' => $user->id,
        'post_id' => $post->id,
        'pdf_name' => 'Receta_Mi_receta_especial.pdf',
    ]);
});

/* Redirige a los invitados al login al intentar descargar un pdf */
it('redirects guests when trying to download a pdf', function () {
    $post = Post::factory()->create([
        'title' => 'Receta sin usuario',
    ]);

    $response = $this->get(route('posts.pdf', $post));

    $response->assertStatus(302);
    $response->assertRedirect(route('login'));
});
