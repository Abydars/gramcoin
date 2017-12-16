<?php

namespace App\Http\Controllers;

class PanelController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'activated']);
    }
}
