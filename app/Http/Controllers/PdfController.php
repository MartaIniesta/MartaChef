<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PdfController extends Controller
{
    public function generatePDF(Post $post)
    {
        $pdfPath = 'pdf/Receta_' . $post->title . '.pdf';

        if (!Storage::disk('public')->exists($pdfPath)) {
            Log::error("El PDF de la receta con el título '{$post->title}' no está disponible en la ruta: {$pdfPath}");

            abort(404);
        }

        return response()->download(storage_path('app/public/' . $pdfPath));
    }
}
