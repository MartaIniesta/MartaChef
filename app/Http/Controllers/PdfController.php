<?php

namespace App\Http\Controllers;

use App\Models\{Post, PdfDownload};
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PdfController extends Controller
{
    public function generatePDF(Post $post)
    {
        $pdfTitle = str_replace(' ', '_', $post->title);
        $pdfPath = 'pdf/Receta_' . $pdfTitle . '.pdf';

        $this->notExistPdf($pdfPath, $post->title);

        if ($user = auth()->user()) {
            PdfDownload::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
                'pdf_name' => 'Receta_' . $pdfTitle . '.pdf',
            ]);
        }

        return response()->download(storage_path('app/public/' . $pdfPath));
    }

    private function notExistPdf(string $pdfPath, string $title): void
    {
        if (!Storage::disk('public')->exists($pdfPath)) {
            Log::error("El PDF de la receta con el título '{$title}' no está disponible en la ruta: {$pdfPath}");
            abort(404);
        }
    }
}
