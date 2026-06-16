<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupeController extends Controller
{
    public function index()
    {
        return Group::withCount('students')->orderBy('group_name')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'group_name' => ['required_without:nom_groupe', 'string', 'max:255'],
            'nom_groupe' => ['required_without:group_name', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $group = Group::create([
            'group_name' => $data['group_name'] ?? $data['nom_groupe'],
            'description' => $data['description'] ?? null,
        ]);

        return response()->json($group, 201);
    }

    public function show(Group $groupe)
    {
        return $groupe->load('students');
    }

    public function update(Request $request, Group $groupe)
    {
        $data = $request->validate([
            'group_name' => ['sometimes', 'string', 'max:255'],
            'nom_groupe' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $groupe->update([
            'group_name' => $data['group_name'] ?? $data['nom_groupe'] ?? $groupe->group_name,
            'description' => array_key_exists('description', $data) ? $data['description'] : $groupe->description,
        ]);

        return response()->json($groupe);
    }

    public function destroy(Group $groupe)
    {
        $groupe->delete();

        return response()->json(['message' => 'Group deleted successfully.']);
    }
}
