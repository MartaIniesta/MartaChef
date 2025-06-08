<?php

namespace App\Jobs;

use App\Models\{User, Post, Comment};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GenerateUserHistoryPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function handle()
    {
        $user = User::withTrashed()->findOrFail($this->userId);
        $safeName = Str::slug($user->name);
        $pdfPath = "pdfs/historial_{$safeName}.pdf";

        if (Storage::disk('public')->exists($pdfPath)) {
            Storage::disk('public')->delete($pdfPath);
        }

        $reports = $user->reporters()->withPivot('reason', 'status', 'created_at', 'updated_at')->get();

        $posts = Post::withTrashed()->where('user_id', $user->id)->get();
        $comments = Comment::withTrashed()->where('user_id', $user->id)->get();

        $data = [
            'user' => $user,
            'reports' => $reports,
            'posts' => $posts,
            'comments' => $comments,
        ];

        $pdf = Pdf::loadView('pdf.user-history', $data);
        Storage::disk('public')->put($pdfPath, $pdf->output());
    }
}
