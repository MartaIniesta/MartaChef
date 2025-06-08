<?php

use App\Livewire\Moderator\ModeratorReports;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

/* Representa la vista del componente */
it('renders the component view', function () {
    Livewire::test(ModeratorReports::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.moderator.moderator-reports');
});
