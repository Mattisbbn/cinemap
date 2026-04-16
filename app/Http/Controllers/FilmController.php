<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('films.index', [
            'films' => Film::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('films.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'release_year' => 'required|integer|min:1000|max:' . date('Y'),
        ]);

        Film::create([
            'title' => $request->input('title'),
            'release_year' => $request->input('release_year'),
        ]);

        return redirect()->route('films.index')->with('success', 'Film créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Film $film)
    {
        return view('films.show', [
            'film' => $film,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Film $film)
    {
        return view('films.edit', [
            'film' => $film,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Film $film)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'release_year' => 'required|integer|min:1000|max:' . date('Y'),
        ]);

        $film->update([
            'title' => $request->input('title'),
            'release_year' => $request->input('release_year'),
        ]);

        return redirect()->route('films.index')->with('success', 'Film mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Film $film)
    {
        $film->delete();
        return redirect()->route('films.index')->with('success', 'Film supprimé avec succès');
    }
}
