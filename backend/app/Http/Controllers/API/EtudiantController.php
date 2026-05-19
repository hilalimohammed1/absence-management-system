<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    public function index()
    {
        return Etudiant::with('groupe')->get();
    }

    public function store(Request $request)
    {
        $etudiant = Etudiant::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'groupe_id' => $request->groupe_id,
        ]);

        return response()->json($etudiant, 201);
    }

    public function show($id)
    {
        return Etudiant::with('groupe')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $etudiant = Etudiant::findOrFail($id);

        $etudiant->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'groupe_id' => $request->groupe_id,
        ]);

        return response()->json($etudiant);
    }

    public function destroy($id)
    {
        Etudiant::destroy($id);

        return response()->json([
            'message' => 'Etudiant supprimé'
        ]);
    }
}