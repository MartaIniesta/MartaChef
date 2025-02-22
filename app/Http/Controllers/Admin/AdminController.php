<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        return $this->middleware('role:admin');
    }

    public function index()
    {
        return view('admin.admin-dashboard');
    }
}
