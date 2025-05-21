<?php

namespace App\Livewire\Moderator;

use Livewire\Component;

class ModeratorDashboard extends Component
{
    public function render()
    {
        return view('livewire.moderator.moderator-dashboard')
            ->layout('layouts.app');
    }
}
