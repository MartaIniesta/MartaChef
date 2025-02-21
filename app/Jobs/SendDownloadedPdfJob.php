<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class SendDownloadedPdfJob
{
    protected $post;
    protected $user;

    public function __construct(Post $post, User $user)
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

        Log::info("Usuario {$this->user->name} ha descargado el PDF de la receta con id: {$this->post->id}.");

        return $pdf->download('Receta_' . $this->post->title . '.pdf');
    }
}
