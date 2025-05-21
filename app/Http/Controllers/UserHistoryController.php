<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\{Comment, Post, Report, User};

class UserHistoryController extends Controller
{
    public function downloadUserHistoryPdf(User $user)
    {
        $reports = Report::where('reported_id', $user->id)->with('reporter')->get();
        $posts = Post::withTrashed()->where('user_id', $user->id)->get();
        $comments = Comment::withTrashed()->where('user_id', $user->id)->get();

        $pdf = Pdf::loadView('pdf.user-history', compact('user', 'reports', 'posts', 'comments'));

        return $pdf->download("Historial_de_{$user->name}.pdf");
    }
}
