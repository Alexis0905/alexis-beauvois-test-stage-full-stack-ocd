<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * @author Alexis Beauvois alexisbeauvois5@gmail.com
 */
class PersonController extends Controller
{
    /**
     * @return View La vue index
     */
    public function index(): View
    {
        $people = Person::all();
        return view('people.index', ['people' => $people]);
    }

    /**
     * @return RedirectResponse|View La vue login ou create
     */
    public function create(): RedirectResponse | View
    {
        if (!Auth::check())
        {
            return redirect()->route('login')->with('error', 'You must be logged in');
        }
        return view('people.create');
    }

    /**
     * @param $id L'id de la personne à afficher
     * @return View La vue show
     */
    public function show(Request $request): View
    {
        if ($request->isMethod('POST'))
        {
            $validatedData = $request->validate
            ([
                'person_id' => ['required']
            ]);

            $person = Person::find($validatedData['person_id']);
            $children = Person::find($person->children->where('parent_id', $person->id)->pluck('child_id'));
            $parents = Person::find($person->parents->where('child_id', $person->id)->pluck('parent_id'));
        }

        return view('people.show', ['person' => $person ?? null, 'children' => $children ?? null, 'parents' => $parents ?? null]);
    }

    /**
     * @param Request $request Les données du formulaire pour créer une personne
     * @return RedirectResponse La vue index actualisée
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate
        ([
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'birth_name' => ['nullable', 'max:255'],
            'middle_names' => ['nullable', 'max:255'],
            'date_of_birth' => ['nullable', 'date']
        ]);

        $person = new Person();
        $person->created_by = Auth::id();
        $person->first_name = ucfirst(strtolower($validatedData['first_name']));
        $person->middle_names = $validatedData['middle_names']
            ? implode(',', array_map('ucfirst', array_map('strtolower', explode(' ', $validatedData['middle_names']))))
            : null;
        $person->last_name = strtoupper($validatedData['last_name']);
        $person->birth_name = $validatedData['birth_name']
            ? strtoupper($validatedData['birth_name'])
            : $person->last_name;
        $person->date_of_birth = $validatedData['date_of_birth']
            ? date('Y-m-d', strtotime($validatedData['date_of_birth']))
            : null;

        $person->save();

        return redirect('/people')->with('success', 'Person created!');
    }

    /**
     * @param Request $request Les données du formulaire pour afficher le degré de parenté
     * @return View La vue degree
     */
    public function degree(Request $request): View
    {
        if ($request->isMethod('post'))
        {
            $person = Person::findOrFail($request->person_id);
            $result = $person->getDegreeWith($request->target_person_id);
        }

        return view(
            'people.degree',
            [
                'degree' => isset($result) ? (is_array($result) ? $result['degree'] : $result) : null,
                'time' => $result['time'] ?? null,
                'nb_queries' => $result['nb_queries'] ?? null,
                'shortest_path' => $result['shortest_path'] ?? null
            ]
        );
    }

}
