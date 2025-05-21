<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Report;
use Artisan;
use Livewire\WithPagination;

class AdminReports extends Component
{
    use WithPagination;

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
        return view('livewire.admin.admin-reports', [
            'reports' => Report::paginate(10)
        ])->layout('layouts.app');
    }
}
