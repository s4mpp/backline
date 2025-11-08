<?php

namespace S4mpp\Backline\Controllers;

use Illuminate\Routing\Controller;

final class HomeController extends Controller
{
    public function __invoke()
    {
        return view('backline::home.index');
    }
}
