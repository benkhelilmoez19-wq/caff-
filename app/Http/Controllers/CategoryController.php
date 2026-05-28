<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category; // <-- Assurez-vous d'avoir créé le modèle Category

class CategoryController extends Controller
{
    /**
     * 1. LISTE DES CATÉGORIES (READ)
     * Affiche la page index avec toutes les catégories existantes.
     */
    public function index()
    {
        // Récupère toutes les catégories de la base de données
        $categories = Category::latest()->get();

        // Envoie les catégories à la vue index.blade.php
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * 2. ENREGISTREMENT (STORE / CREATE)
     * Reçoit les données du Modal d'ajout et crée la catégorie.
     */
    public function store(Request $request)
    {
        // Validation des données reçues
        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:1000',
        ]);

        // Création en base de données
        Category::create([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        // Redirection vers l'index avec un message de succès
        return redirect()->route('categories.index')->with('success', 'La catégorie a été ajoutée avec succès !');
    }

    /**
     * 3. MISE À JOUR (UPDATE)
     * Reçoit les données du Modal d'édition et modifie la catégorie.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        // Validation (on ignore le nom de l'actuelle catégorie pour éviter le blocage du unique)
        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:1000',
        ]);

        // Mise à jour
        $category->update([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')->with('success', 'La catégorie a été modifiée avec succès !');
    }

    /**
     * 4. SUPPRESSION (DESTROY)
     * Supprime définitivement une catégorie de la base de données.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'La catégorie a été supprimée avec succès !');
    }
}