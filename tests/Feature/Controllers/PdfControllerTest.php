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

it('unauthenticated users cannot download a pdf', function () {
    Auth::logout();

    $response = $this->get(route('posts.pdf', $this->post));

    $response->assertRedirect(route('login'));
});
