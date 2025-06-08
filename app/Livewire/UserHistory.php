<?php

namespace App\Livewire;

use App\Models\{Comment, Post, User};
use Livewire\Component;
use App\Jobs\GenerateUserHistoryPdfJob;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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

        $this->reports = $this->user->reporters()->withPivot('reason', 'status', 'created_at', 'updated_at')->get();

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
        $dates = collect([
            strtotime($this->user->updated_at),
            strtotime(DB::table('reports')->where('reported_id', $this->userId)->max('updated_at') ?? 0),
            strtotime(Post::withTrashed()->where('user_id', $this->userId)->max('updated_at') ?? 0),
            strtotime(Comment::withTrashed()->where('user_id', $this->userId)->max('updated_at') ?? 0),
        ]);

        return $dates->max();
    }

    public function render()
    {
        return view('livewire.user-history')
            ->layout('layouts.app');
    }
}
