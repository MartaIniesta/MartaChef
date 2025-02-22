<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class SendDownloadedPdfJob implements ShouldQueue
{
    protected $post;
    protected $user;

    public function __construct(Post $post, ?User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    public function handle()
    {
        $data = [
            'post' => $this->post,
            'isAuthenticated' => true,
        ];

        $pdf = Pdf::loadView('posts.pdf', $data);

        Log::info("Usuario {$this->user->name} ha solicitado la generación del PDF de la receta con id: {$this->post->id}.");

        $pdfTitle = str_replace(' ', '_', $this->post->title);
        $pdfPath = 'pdf/Receta_' . $pdfTitle . '.pdf';
        Storage::disk('public')->put($pdfPath, $pdf->output());

        Log::info("PDF generado y guardado correctamente en: {$pdfPath}");
    }
}
