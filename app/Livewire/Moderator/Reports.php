<?php

namespace App\Livewire\Moderator;

use Livewire\Component;
use App\Models\Report;

class Reports extends Component
{
    public function markAsReviewed($reportId)
    {
        $report = Report::findOrFail($reportId);
        $report->update(['status' => 'reviewed']);
    }

    public function deleteReport($reportId)
    {
        Report::findOrFail($reportId)->delete();
    }

    public function render()
    {
        return view('livewire.moderator.reports', [
            'reports' => Report::latest()->get()
        ]);
    }
}
