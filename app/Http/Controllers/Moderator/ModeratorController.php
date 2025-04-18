<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class ModeratorController extends Controller
{
    public function index()
    {
        return view('moderator.moderator-dashboard');
    }

    public function downloadUserHistoryPdf(User $user)
    {
        $reports = Report::where('reported_id', $user->id)->with('reporter')->get();
        $posts = Post::withTrashed()->where('user_id', $user->id)->get();
        $comments = Comment::withTrashed()->where('user_id', $user->id)->get();

        $pdf = Pdf::loadView('pdf.user-history', compact('user', 'reports', 'posts', 'comments'));

        return $pdf->download("Historial_de_{$user->name}.pdf");
    }
}
