<?php

use App\Jobs\SendDownloadedPdfJob;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

it('generates a pdf of the publication', function () {
    // Arrange
    $user = User::factory()->create();
    $post = Post::factory()->create();

    loginAsUser($user);

    $filePath = storage_path('app/public/test-image.png');
    file_put_contents($filePath, 'dummy image content');
    $post->image = 'test-image.png';

    // Act
    $job = new SendDownloadedPdfJob($post, $user);
    $response = $job->handle();

    // Assert
    expect($response)->toBeInstanceOf(Response::class)
        ->and($response->headers->get('content-type'))->toContain('application/pdf');

    unlink($filePath);
});


it('logs the correct message when the PDF is downloaded', function () {
    // Arrange
    $user = User::factory()->create();
    $post = Post::factory()->create();

    loginAsUser($user);

    $imagePath = storage_path('app/public/test-image.png');
    file_put_contents($imagePath, 'dummy image content');
    $post->image = 'test-image.png';

    Log::shouldReceive('info')
        ->once()
        ->with("Usuario {$user->name} ha descargado el PDF de la receta con id: {$post->id}.");

    // Act
    $job = new SendDownloadedPdfJob($post, $user);
    $job->handle();

    unlink($imagePath);
});
