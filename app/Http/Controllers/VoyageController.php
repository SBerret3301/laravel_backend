<?php

namespace App\Http\Controllers;

use App\Models\Voyage;
use Illuminate\Http\Request;

class VoyageController extends Controller
{
    public function index()
    {
        return Voyage::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'destination' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'prix' => 'required|numeric',
        ]);

        return Voyage::create($validated);
    }

    public function show(Voyage $voyage)
    {
        return $voyage;
    }

    public function update(Request $request, Voyage $voyage)
    {
        $voyage->update($request->all());
        return $voyage;
    }

    public function destroy(Voyage $voyage)
    {
        $voyage->delete();
        return response()->json(null, 204);
    }
}
