<?php

use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use function Pest\Laravel\actingAs;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    Storage::fake('public');
    $this->seed(RolesSeeder::class);
});

/* Descarga el historial del usuario en PDF si existe */
it('downloads the user history PDF if it exists', function () {
    $user = User::factory()->create(['name' => 'John Doe']);
    $user->assignRole('admin');
    actingAs($user);

    $safeName = Str::slug($user->name);
    $filename = "historial_{$safeName}.pdf";
    $pdfPath = "pdfs/{$filename}";

    Storage::disk('public')->put($pdfPath, 'PDF content');

    $response = $this->withoutExceptionHandling()->get(route('user-history.download', $user));

    $response->assertOk();
    $response->assertHeader('content-disposition', 'attachment; filename=' . $filename);
});

/* Devuelve 404 si el PDF no existe */
it('returns 404 if the PDF does not exist', function () {
    $user = User::factory()->create(['name' => 'Jane Smith']);
    $user->assignRole('admin');
    actingAs($user);

    $safeName = Str::slug($user->name);
    $filename = "historial_{$safeName}.pdf";
    $pdfPath = "pdfs/{$filename}";

    $response = $this->get(route('user-history.download', $user));

    $response->assertNotFound();
});
