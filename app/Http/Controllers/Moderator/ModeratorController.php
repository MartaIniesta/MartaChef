<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;

class ModeratorController extends Controller
{
    public function __construct()
    {
        return $this->middleware('role:moderator');
    }

    public function index()
    {
        return view('moderator.moderator-dashboard');
    }
}
