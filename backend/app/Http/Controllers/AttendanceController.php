<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Group;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(Request $request): View
    {
        $groups = Group::orderBy('group_name')->get();
        $selectedGroup = $request->integer('group_id');
        $date = $request->input('date', now()->toDateString());
        $students = collect();
        $attendanceMap = collect();

        if ($selectedGroup) {
            $students = Group::findOrFail($selectedGroup)
                ->students()
                ->orderBy('last_name')
                ->get();

            $attendanceMap = Attendance::whereDate('date', $date)
                ->whereIn('student_id', $students->pluck('id'))
                ->pluck('status', 'student_id');
        }

        return view('attendances.index', compact('groups', 'selectedGroup', 'date', 'students', 'attendanceMap'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'group_id' => ['required', 'exists:groups,id'],
            'date' => ['required', 'date'],
            'attendance' => ['required', 'array'],
            'attendance.*' => ['required', 'in:Present,Absent'],
        ]);

        $date = Carbon::parse($validated['date'])->toDateString();

        foreach ($validated['attendance'] as $studentId => $status) {
            Attendance::updateOrCreate(
                ['student_id' => $studentId, 'date' => $date],
                ['status' => $status]
            );
        }

        return redirect()
            ->route('attendances.index', ['group_id' => $validated['group_id'], 'date' => $date])
            ->with('success', 'Attendance saved successfully.');
    }
}
