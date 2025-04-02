<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        return view('moderator.moderator-users-index');
    }
}
