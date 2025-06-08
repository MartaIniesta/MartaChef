<?php

namespace App\Livewire\Moderator;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Livewire\WithPagination;

class ModeratorReports extends Component
{
    use WithPagination;

    public string $deleteMessage = '';

    public function markAsReviewed($reportId)
    {
        DB::table('reports')
            ->where('id', $reportId)
            ->update(['status' => 'reviewed']);
    }

    public function deleteReport($reportId)
    {
        DB::table('reports')
            ->where('id', $reportId)
            ->delete();
    }

    public function deleteReviewedReports()
    {
        Artisan::call('delete:reviewed-reports');
        $this->deleteMessage = Artisan::output();
    }

    public function render()
    {
        $reports = DB::table('reports')
            ->join('users as reporter', 'reports.reporter_id', '=', 'reporter.id')
            ->join('users as reported', 'reports.reported_id', '=', 'reported.id')
            ->select(
                'reports.*',
                'reporter.name as reporter_name',
                'reported.name as reported_name'
            )
            ->paginate(10);

        return view('livewire.moderator.moderator-reports', [
            'reports' => $reports,
        ])->layout('layouts.app');
    }
}
