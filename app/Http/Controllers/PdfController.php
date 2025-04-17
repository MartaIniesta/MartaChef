<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\{Post, PdfDownload};

class PdfController extends Controller
{
    public function downloadPDF(Post $post)
    {
        $isAuthenticated = auth()->check();

        if ($user = auth()->user()) {
            PdfDownload::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
                'pdf_name' => 'Receta_' . str_replace(' ', '_', $post->title) . '.pdf',
            ]);
        }

        $pdf = Pdf::loadView('posts.pdf', [
            'post' => $post,
            'isAuthenticated' => $isAuthenticated
        ]);

        return $pdf->download('Receta_' . str_replace(' ', '_', $post->title) . '.pdf');
    }
}
