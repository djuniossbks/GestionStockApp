<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UtilisateurController extends Controller
{
    public function index(): View
    {
        return view('utilisateurs.index', ['utilisateurs' => User::latest()->paginate(15)]);
    }

    public function create(): View
    {
        return view('utilisateurs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'gestionnaire'])],
        ]);

        User::create($data);

        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur cree avec succes.');
    }

    public function edit(User $utilisateur): View
    {
        return view('utilisateurs.edit', compact('utilisateur'));
    }

    public function update(Request $request, User $utilisateur): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($utilisateur->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'gestionnaire'])],
        ]);

        if (blank($data['password'])) {
            unset($data['password']);
        }

        $utilisateur->update($data);

        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur modifie avec succes.');
    }

    public function destroy(User $utilisateur): RedirectResponse
    {
        if ($utilisateur->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $utilisateur->delete();

        return back()->with('success', 'Utilisateur supprime avec succes.');
    }
}
