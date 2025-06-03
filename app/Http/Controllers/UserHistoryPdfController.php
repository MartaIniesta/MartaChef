<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;

class UserHistoryPdfController extends Controller
{
    public function download(User $user)
    {
        $safeName = Str::slug($user->name);
        $filename = "historial_{$safeName}.pdf";
        $pdfPath = "pdfs/{$filename}";

        if (!Storage::disk('public')->exists($pdfPath)) {
            abort(404, 'PDF no disponible todavía.');
        }

        return Storage::disk('public')->download($pdfPath, $filename);
    }
}
