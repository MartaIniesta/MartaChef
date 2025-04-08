<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;

class UserHistoryController extends Controller
{
    public function show($userId)
    {
        return view('moderator.user-history', compact('userId'));
    }
}
