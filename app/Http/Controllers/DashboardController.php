<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function __invoke(): View|RedirectResponse
    {
        $user = auth()->user();

        if ($user === null) {
            return redirect()->route('login');
        }

        if ($user->isSuperAdmin()) {
            return view('dashboards.super-admin');
        }

        if ($user->isAdmin()) {
            return view('dashboards.admin');
        }

        if ($user->isTeacher()) {
            return view('dashboards.teacher');
        }

        return view('dashboards.student');
    }
}
