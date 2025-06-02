<?php

use Livewire\Livewire;
use App\Livewire\Admin\AdminDashboard;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

/* Representa correctamente el componente del panel de administración */
it('renders the admin dashboard component successfully', function () {
    Livewire::test(AdminDashboard::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.admin.admin-dashboard');
});
