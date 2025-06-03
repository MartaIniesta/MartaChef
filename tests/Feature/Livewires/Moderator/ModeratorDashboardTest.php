<?php

use App\Livewire\Moderator\ModeratorDashboard;
use Livewire\Livewire;

/* Representa el componente del panel del moderador */
it('renders the moderator dashboard component', function () {
    Livewire::test(ModeratorDashboard::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.moderator.moderator-dashboard');
});
