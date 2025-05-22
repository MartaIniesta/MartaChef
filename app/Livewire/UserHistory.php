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
        $hashPath = "pdfs/historial_{$safeName}_hash.txt";

        $data = [
            'user' => $this->user,
            'reports' => $this->reports,
            'posts' => $this->posts,
            'comments' => $this->comments,
        ];

        $newHash = hash('sha256', json_encode($data));

        if (Storage::disk('public')->exists($pdfPath) && Storage::disk('public')->exists($hashPath)) {
            $oldHash = Storage::disk('public')->get($hashPath);
            if ($oldHash === $newHash) {
                return;
            }
        }

        GenerateUserHistoryPdfJob::dispatch($this->user->id);
    }

    public function render()
    {
        return view('livewire.user-history')
            ->layout('layouts.app');
    }
}
