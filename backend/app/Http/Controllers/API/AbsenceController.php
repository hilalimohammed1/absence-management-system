<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Etudiant;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function getEtudiantsByGroupe($groupe_id)
    {
        return Etudiant::where('groupe_id', $groupe_id)->get();
    }

    public function store(Request $request)
    {
        foreach ($request->absences as $absence) {

            Absence::create([
                'etudiant_id' => $absence['etudiant_id'],
                'date' => $request->date,
                'statut' => $absence['statut']
            ]);
        }

        return response()->json([
            'message' => 'Absences enregistrées'
        ]);
    }
}