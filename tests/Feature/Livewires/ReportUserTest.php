<?php

use App\Livewire\ReportUser;
use App\Models\User;
use Livewire\Livewire;
use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->reporter = User::factory()->create();
    $this->reported = User::factory()->create();
});

/* Se inicializa con un usuario para informar */
it('initializes with a user to report', function () {
    Livewire::test(ReportUser::class, ['user' => $this->reported])
        ->assertSet('user.id', $this->reported->id)
        ->assertSet('isOpen', false)
        ->assertSet('reason', null);
});

/* Abre el modal correctamente */
it('opens the modal correctly', function () {
    Livewire::test(ReportUser::class, ['user' => $this->reported])
        ->call('openModal')
        ->assertSet('isOpen', true);
});

/* Cierra el modal y restablece las propiedades */
it('closes the modal and resets properties', function () {
    Livewire::test(ReportUser::class, ['user' => $this->reported])
        ->set('reason', 'Some reason longer than 10 chars')
        ->call('openModal')
        ->call('closeModal')
        ->assertSet('isOpen', false)
        ->assertSet('reason', null);
});

/* Valida correctamente el campo de motivo */
it('validates the reason field properly', function () {
    Livewire::test(ReportUser::class, ['user' => $this->reported])
        ->set('reason', '')
        ->call('submitReport')
        ->assertHasErrors(['reason' => 'required']);

    Livewire::test(ReportUser::class, ['user' => $this->reported])
        ->set('reason', 'Too short')
        ->call('submitReport')
        ->assertHasErrors(['reason' => 'min']);

    Livewire::test(ReportUser::class, ['user' => $this->reported])
        ->set('reason', str_repeat('a', 501))
        ->call('submitReport')
        ->assertHasErrors(['reason' => 'max']);
});

/* Crea un informe y restablece el estado al enviarlo */
it('creates a report and resets state on submit', function () {
    $reporter = User::factory()->create();
    $reported = User::factory()->create();
    $reason = 'Este usuario ha violado las normas de la comunidad.';

    actingAs($reporter);

    Livewire::test(ReportUser::class, ['user' => $reported])
        ->set('reason', $reason)
        ->call('submitReport')
        ->assertSet('isOpen', false)
        ->assertSet('reason', null);

    $this->assertDatabaseHas('reports', [
        'reporter_id' => $reporter->id,
        'reported_id' => $reported->id,
        'reason' => $reason,
        'status' => 'pending',
    ]);
});
