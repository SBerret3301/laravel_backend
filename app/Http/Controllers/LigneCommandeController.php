<?php

namespace App\Http\Controllers;

use App\Models\LigneCommande;
use Illuminate\Http\Request;

class LigneCommandeController extends Controller
{
    public function index()
    {
        return LigneCommande::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'commande_id' => 'required|exists:commandes,id',
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer',
            'prix' => 'required|numeric',
        ]);

        return LigneCommande::create($request->all());
    }

    public function show($id)
    {
        return LigneCommande::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $ligne = LigneCommande::findOrFail($id);
        $ligne->update($request->all());

        return $ligne;
    }

    public function destroy($id)
    {
        $ligne = LigneCommande::findOrFail($id);
        $ligne->delete();

        return response()->json(null, 204);
    }
}
