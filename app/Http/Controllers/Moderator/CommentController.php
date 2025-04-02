<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function index()
    {
        return view('moderator.moderator-comments-index');
    }
}
