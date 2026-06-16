<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Group;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        return view('reports.index', [
            'students' => Student::orderBy('last_name')->get(),
            'groups' => Group::orderBy('group_name')->get(),
        ]);
    }

    public function byStudent(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
        ]);

        $student = Student::with('group')->findOrFail($validated['student_id']);
        $attendances = $student->attendances()->latest('date')->get();

        return Pdf::loadView('pdf.attendance-report', [
            'title' => 'Student Attendance Report',
            'subtitle' => $student->full_name,
            'attendances' => $attendances,
        ])->download('student-attendance-report.pdf');
    }

    public function byGroup(Request $request)
    {
        $validated = $request->validate([
            'group_id' => ['required', 'exists:groups,id'],
        ]);

        $group = Group::findOrFail($validated['group_id']);
        $attendances = Attendance::with('student.group')
            ->whereHas('student', fn ($query) => $query->where('group_id', $group->id))
            ->latest('date')
            ->get();

        return Pdf::loadView('pdf.attendance-report', [
            'title' => 'Group Attendance Report',
            'subtitle' => $group->group_name,
            'attendances' => $attendances,
        ])->download('group-attendance-report.pdf');
    }

    public function byDate(Request $request)
    {
        $validated = $request->validate([
            'date' => ['required', 'date'],
        ]);

        $attendances = Attendance::with('student.group')
            ->whereDate('date', $validated['date'])
            ->orderBy('status')
            ->get();

        return Pdf::loadView('pdf.attendance-report', [
            'title' => 'Daily Attendance Report',
            'subtitle' => $validated['date'],
            'attendances' => $attendances,
        ])->download('daily-attendance-report.pdf');
    }
}
