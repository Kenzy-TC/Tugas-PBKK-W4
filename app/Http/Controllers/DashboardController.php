<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard', [
            'totalStudents' => Student::count(),
            'activeStudents' => Student::where('status', 'Aktif')->count(),
            'totalUsers' => User::count(),
            'totalPrograms' => Student::distinct('study_program')->count('study_program'),
            'recentStudents' => Student::latest()->take(5)->get(),
        ]);
    }
}
