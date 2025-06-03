<?php

use App\Livewire\UserHistory;
use App\Models\{User, Post, Comment, Report};
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    Storage::fake('public');
    Queue::fake();

    $this->user = User::factory()->create(['name' => 'Juan Pérez']);
    $this->posts = Post::factory()->count(2)->for($this->user)->create();
    $this->comments = Comment::factory()->count(2)->for($this->user)->create();
    $this->reports = Report::factory()->count(2)->create(['reported_id' => $this->user->id]);
});

/* Carga correctamente el historial del usuario */
it('loads user history correctly', function () {
    Livewire::test(UserHistory::class, ['userId' => $this->user->id])
        ->assertSet('user.id', $this->user->id)
        ->assertCount('posts', 2)
        ->assertCount('comments', 2)
        ->assertCount('reports', 2);
});

/* Muestra la vista correcta */
it('renders the correct view', function () {
    Livewire::test(UserHistory::class, ['userId' => $this->user->id])
        ->assertViewIs('livewire.user-history');
});
