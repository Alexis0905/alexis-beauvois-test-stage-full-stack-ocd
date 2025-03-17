<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * @author Alexis Beauvois alexisbeauvois5@gmail.com
 */
class PersonController extends Controller
{

    public function index(): View
    {
        $people = Person::all();
        return view('people.index', ['people' => $people]);
    }

    public function create(): View
    {
        return view('people.create');
    }

    public function show($id): View
    {
        $person = Person::all()->find($id);
        $children = Person::all()->find($person->children->where('parent_id', $person->id)->pluck('child_id'));
        $parents = Person::all()->find($person->parents->where('child_id', $person->id)->pluck('parent_id'));
        return view('people.show', ['person' => $person, 'children' => $children, 'parents' => $parents]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'birth_name' => ['nullable', 'max:255'],
            'middle_names' => ['nullable', 'max:255'],
            'date_of_birth' => ['nullable', 'date']
        ]);

        $person = new Person();
        $person->fill($validatedData);
        $person->created_by = 1;

        $person->save();

        return redirect('/people')->with('success', 'Person created!');
    }
}
