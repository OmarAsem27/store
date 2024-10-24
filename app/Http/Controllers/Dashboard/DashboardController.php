<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth']);
    }
    public function index()
    {
        return View::make('dashboard.index');
    }
}
