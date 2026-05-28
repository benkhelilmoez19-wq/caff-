<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Afficher le formulaire de connexion.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Traiter la tentative de connexion.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|max:191',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirection selon le rôle de l'utilisateur
            if (Auth::user()->role === 'admin') {
                return redirect('/admin/dashboard');
            }

            return redirect('/index');
        }

        return back()->withErrors(['email' => 'Identifiants incorrects.']);
    }

    /**
     * Déconnecter l'utilisateur et nettoyer la session.
     */
    public function logout(Request $request)
    {
        // 1. Déconnexion de l'utilisateur via Guard
        Auth::logout();

        // 2. Invalidation de la session actuelle pour effacer les données
        $request->session()->invalidate();

        // 3. Régénération du jeton CSRF pour bloquer les attaques de fixation de session
        $request->session()->regenerateToken();

        // 4. CORRECTION : Redirection vers la page d'accueil (/index) avec un message de succès
        return redirect('/index')->with('success', 'Vous avez été déconnecté avec succès.');
    }
}