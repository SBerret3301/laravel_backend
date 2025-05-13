<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    public function index()
    {
        return Produit::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string',
            'description' => 'required|string',
            'prix' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        return Produit::create($validated);
    }

    public function show(Produit $produit)
    {
        return $produit;
    }

    public function update(Request $request, Produit $produit)
    {
        $produit->update($request->all());
        return $produit;
    }

    public function destroy(Produit $produit)
    {
        $produit->delete();
        return response()->json(null, 204);
    }
}
