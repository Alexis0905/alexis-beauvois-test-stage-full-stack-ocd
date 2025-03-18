<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Mockery\Generator\Method;

/**
 * @author Alexis Beauvois alexisbeauvois5@gmail.com
 */
class AuthController extends Controller
{
    /**
     * @param Request $request Les données du formulaire pour se créer un compte
     * @return RedirectResponse|View La réponse de la création de compte ou la vue register
     */
    public function register(Request $request): RedirectResponse | View
    {
        if ($request->isMethod('GET'))
        {
            return view('register');
        }

        $credentials = $request->validate
        ([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = new User($credentials);
        $user->save();

        if (Auth::attempt($credentials))
        {
            $request->session()->regenerate();

            return redirect('/')->with('success', 'You are now registered');
        }

        return redirect('register')->with('error', 'Error');
    }

    /**
     * @param Request $request Les données du formulaire pour se connecter
     * @return RedirectResponse|View La réponse de la connexion ou la vue login
     */
    public function login(Request $request): RedirectResponse | View
    {
        if ($request->isMethod('GET'))
        {
            return view('login');
        }

        $credentials = $request->validate
        ([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials))
        {
            $request->session()->regenerate();

            return redirect('/')->with('success', 'You are now logged in');
        }

        return redirect()->route('login')->with('error', 'Incorrect email or password');
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
