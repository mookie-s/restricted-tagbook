<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PrivacyController extends Controller
{
    public function index(): View
    {
        return view('/privacy');
    }
}
