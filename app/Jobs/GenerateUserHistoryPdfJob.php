<?php

namespace App\Jobs;

use App\Models\{User, Report, Post, Comment};
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

        $reports = Report::where('reported_id', $user->id)->with('reporter')->get();
        $posts = Post::withTrashed()->where('user_id', $user->id)->get();
        $comments = Comment::withTrashed()->where('user_id', $user->id)->get();

        $data = [
            'user' => $user,
            'reports' => $reports,
            'posts' => $posts,
            'comments' => $comments
        ];

        $safeName = Str::slug($user->name);

        $newHash = hash('sha256', serialize($data));
        $hashPath = "pdfs/historial_{$safeName}_hash.txt";
        $pdfPath = "pdfs/historial_{$safeName}.pdf";

        if (Storage::disk('public')->exists($hashPath)) {
            $storedHash = Storage::disk('public')->get($hashPath);

            if ($storedHash === $newHash && Storage::disk('public')->exists($pdfPath)) {
                return;
            } else {
                if (Storage::disk('public')->exists($pdfPath)) {
                    Storage::disk('public')->delete($pdfPath);
                }
            }
        }

        $pdf = Pdf::loadView('pdf.user-history', $data);
        Storage::disk('public')->put($pdfPath, $pdf->output());

        Storage::disk('public')->put($hashPath, $newHash);
    }
}
