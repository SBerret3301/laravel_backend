<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function index()
    {
        return Commande::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'utilisateur_id' => 'required|exists:utilisateurs,id',
            'date' => 'required|date',
            'montant_total' => 'required|numeric',
        ]);

        return Commande::create($request->all());
    }

    public function show($id)
    {
        return Commande::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $commande = Commande::findOrFail($id);
        $commande->update($request->all());

        return $commande;
    }

    public function destroy($id)
    {
        $commande = Commande::findOrFail($id);
        $commande->delete();

        return response()->json(null, 204);
    }
}
