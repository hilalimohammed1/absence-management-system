<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AbsenceController extends Controller
{
    public function getEtudiantsByGroupe($groupe_id)
    {
        return Student::where('group_id', $groupe_id)->orderBy('last_name')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => ['required', 'date'],
            'attendances' => ['required_without:absences', 'array'],
            'attendances.*.student_id' => ['required_with:attendances', 'exists:students,id'],
            'attendances.*.status' => ['required_with:attendances', 'in:Present,Absent'],
            'absences' => ['required_without:attendances', 'array'],
            'absences.*.etudiant_id' => ['required_with:absences', 'exists:students,id'],
            'absences.*.statut' => ['required_with:absences', 'in:Present,Absent'],
        ]);

        $date = Carbon::parse($data['date'])->toDateString();
        $items = $data['attendances'] ?? $data['absences'];

        foreach ($items as $item) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $item['student_id'] ?? $item['etudiant_id'],
                    'date' => $date,
                ],
                ['status' => $item['status'] ?? $item['statut']]
            );
        }

        return response()->json(['message' => 'Attendance saved successfully.']);
    }
}
