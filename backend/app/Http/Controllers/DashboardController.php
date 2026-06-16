<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalStudents = Student::count();
        $totalGroups = Group::count();
        $totalRecords = Attendance::count();
        $totalAbsences = Attendance::where('status', 'Absent')->count();
        $absenceRate = $totalRecords > 0 ? round(($totalAbsences / $totalRecords) * 100, 1) : 0;

        $absencesByGroup = Group::withCount([
            'students',
            'students as absences_count' => function ($query) {
                $query->join('attendances', 'students.id', '=', 'attendances.student_id')
                    ->where('attendances.status', 'Absent');
            },
        ])->orderBy('group_name')->get();

        $dailyStats = Attendance::select('date', DB::raw("SUM(status = 'Absent') as absent_count"))
            ->groupBy('date')
            ->orderByDesc('date')
            ->limit(7)
            ->get()
            ->sortBy('date');

        return view('dashboard', compact(
            'totalStudents',
            'totalGroups',
            'totalAbsences',
            'absenceRate',
            'absencesByGroup',
            'dailyStats'
        ));
    }
}
