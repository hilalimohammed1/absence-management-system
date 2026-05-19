<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Groupe;
use Illuminate\Http\Request;

class GroupeController extends Controller
{
    public function index()
    {
        return Groupe::all();
    }

    public function store(Request $request)
    {
        $groupe = Groupe::create([
            'nom_groupe' => $request->nom_groupe
        ]);

        return response()->json($groupe, 201);
    }

    public function show($id)
    {
        return Groupe::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $groupe = Groupe::findOrFail($id);

        $groupe->update([
            'nom_groupe' => $request->nom_groupe
        ]);

        return response()->json($groupe);
    }

    public function destroy($id)
    {
        Groupe::destroy($id);

        return response()->json([
            'message' => 'Groupe supprimé'
        ]);
    }
}