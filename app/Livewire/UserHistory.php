<?php

namespace App\Livewire;

use App\Models\{Comment, Post, Report, User};
use Livewire\Component;
use App\Jobs\GenerateUserHistoryPdfJob;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserHistory extends Component
{
    public $userId;
    public $user;
    public $reports;
    public $posts;
    public $comments;

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->user = User::findOrFail($userId);

        $this->reports = Report::where('reported_id', $userId)->get();
        $this->posts = Post::withTrashed()->where('user_id', $userId)->get();
        $this->comments = Comment::withTrashed()->with('post')->where('user_id', $userId)->get();

        $this->checkAndDispatchPdfJob();
    }

    public function checkAndDispatchPdfJob()
    {
        $safeName = Str::slug($this->user->name);
        $pdfPath = "pdfs/historial_{$safeName}.pdf";

        if (!Storage::disk('public')->exists($pdfPath)) {
            GenerateUserHistoryPdfJob::dispatch($this->user->id);
            return;
        }

        $pdfLastModified = Storage::disk('public')->lastModified($pdfPath);

        $lastDataUpdate = $this->getLastDataUpdate();

        if ($lastDataUpdate > $pdfLastModified) {
            GenerateUserHistoryPdfJob::dispatch($this->user->id);
        }
    }

    private function getLastDataUpdate()
    {
        $timestamps = collect([
            strtotime($this->user->updated_at),
            Report::where('reported_id', $this->userId)->max('updated_at'),
            Post::withTrashed()->where('user_id', $this->userId)->max('updated_at'),
            Comment::withTrashed()->where('user_id', $this->userId)->max('updated_at'),
        ])->map(fn($date) => $date ? strtotime($date) : 0);

        return $timestamps->max();
    }

    public function render()
    {
        return view('livewire.user-history')
            ->layout('layouts.app');
    }
}
