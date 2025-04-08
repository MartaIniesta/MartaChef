<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use App\Models\Post;

class ReportController extends Controller
{
    public function index()
    {
        return view('moderator.moderator-reports-index');
    }
}
