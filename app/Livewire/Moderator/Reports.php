<?php

namespace App\Livewire\Moderator;

use Livewire\Component;
use App\Models\Report;
use Artisan;

class Reports extends Component
{
    public string $deleteMessage = '';

    public function markAsReviewed($reportId)
    {
        $report = Report::findOrFail($reportId);
        $report->update(['status' => 'reviewed']);
    }

    public function deleteReport($reportId)
    {
        Report::findOrFail($reportId)->delete();
    }

    public function deleteReviewedReports()
    {
        Artisan::call('delete:reviewed-reports');
        $this->deleteMessage = Artisan::output();
    }

    public function render()
    {
        return view('livewire.moderator.reports', [
            'reports' => Report::get()
        ])->layout('layouts.app');
    }
}
