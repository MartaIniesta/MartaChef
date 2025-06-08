<?php

use App\Livewire\Admin\AdminReports;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

/* Representa la vista del componente */
it('renders the component view', function () {
    Livewire::test(AdminReports::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.admin.admin-reports');
});
