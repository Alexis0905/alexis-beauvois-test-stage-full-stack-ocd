<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * @author Alexis Beauvois alexisbeauvois5@gmail.com
 */
class LoginController extends Controller
{
    /**
     * @return View La vue login
     */
    public function showLoginForm(): View
    {
        return view('login');
    }

    /**
     * @param Request $request Les données du formulaire pour se connecter
     * @return RedirectResponse La réponse de l'authentification
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect('/')->with('success', 'You are now logged in');
        }

        return back()->withErrors([
            'email' => 'Email or password is incorrect',
        ])->onlyInput('email');
    }

    /**
     * @param Request $request La requête pour se déconnecter
     * @return RedirectResponse La réponse de la déconnexion
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You are now logged out');
    }
}
