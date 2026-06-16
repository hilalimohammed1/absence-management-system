<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EtudiantController extends Controller
{
    public function index()
    {
        return Student::with('group')->orderBy('last_name')->get();
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        $student = Student::create($data);

        return response()->json($student->load('group'), 201);
    }

    public function show(Student $etudiant)
    {
        return $etudiant->load('group');
    }

    public function update(Request $request, Student $etudiant)
    {
        $etudiant->update($this->validatedData($request, $etudiant));

        return response()->json($etudiant->load('group'));
    }

    public function destroy(Student $etudiant)
    {
        $etudiant->delete();

        return response()->json(['message' => 'Student deleted successfully.']);
    }

    private function validatedData(Request $request, ?Student $student = null): array
    {
        $data = $request->validate([
            'first_name' => ['required_without:prenom', 'string', 'max:100'],
            'prenom' => ['required_without:first_name', 'string', 'max:100'],
            'last_name' => ['required_without:nom', 'string', 'max:100'],
            'nom' => ['required_without:last_name', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', Rule::unique('students')->ignore($student)],
            'phone' => ['nullable', 'string', 'max:30'],
            'group_id' => ['required_without:groupe_id', 'exists:groups,id'],
            'groupe_id' => ['required_without:group_id', 'exists:groups,id'],
        ]);

        return [
            'first_name' => $data['first_name'] ?? $data['prenom'],
            'last_name' => $data['last_name'] ?? $data['nom'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'group_id' => $data['group_id'] ?? $data['groupe_id'],
        ];
    }
}
