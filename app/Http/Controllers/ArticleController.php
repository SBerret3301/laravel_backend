<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Afficher tous les articles
    public function index()
    {
        $articles = Article::all();
        return response()->json($articles);
    }

    // Stocker un nouvel article dans la base de données
    public function store(Request $request)
    {
        // Valider les données entrées
        $validated = $request->validate([
            'code_article' => 'required|string|max:255|unique:articles,code_article',
            'emplacement' => 'required|string|max:255',
            'description' => 'required|string',
            'prix_unitaire' => 'required|numeric',
        ]);

        // Créer l'article et le stocker dans la base de données
        $article = Article::create($validated);

        return response()->json($article, 201);
    }

    // Afficher un article spécifique
    public function show($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json(['message' => 'L\'article n\'existe pas'], 404);
        }

        return response()->json($article);
    }

    // Mettre à jour un article spécifique
    public function update(Request $request, $id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json(['message' => 'L\'article n\'existe pas'], 404);
        }

        // Valider les données entrées
        $validated = $request->validate([
            'code_article' => 'sometimes|required|string|max:255|unique:articles,code_article,' . $id,
            'emplacement' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'prix_unitaire' => 'sometimes|required|numeric',
        ]);

        // Mettre à jour l'article avec les nouvelles données
        $article->update($validated);

        return response()->json($article);
    }

    // Supprimer un article spécifique
    public function destroy($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json(['message' => 'L\'article n\'existe pas'], 404);
        }

        // Supprimer l'article
        $article->delete();

        return response()->json(['message' => 'L\'article a été supprimé avec succès']);
    }
}
