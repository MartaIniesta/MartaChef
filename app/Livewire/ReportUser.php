<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReportUser extends Component
{
    public $user;
    public $reason;
    public $isOpen = false;

    protected $rules = [
        'reason' => 'required|min:10|max:500',
    ];

    protected $messages = [
        'reason.required' => 'Es obligatorio añadir una razón para el reporte.',
        'reason.min' => 'El reporte debe tener al menos 10 caracteres.',
        'reason.max' => 'El reporte no puede exceder los 500 caracteres.',
    ];

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->reset(['reason', 'isOpen']);
    }

    public function submitReport()
    {
        $this->validate();

        $authUser = Auth::user();

        if ($authUser->id === $this->user->id) {
            session()->flash('error', 'No puedes reportarte a ti mismo.');
            return;
        }

        $authUser->reportedUsers()->attach($this->user->id, [
            'reason' => $this->reason,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        session()->flash('message', 'Reporte enviado correctamente.');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.report-user');
    }
}
