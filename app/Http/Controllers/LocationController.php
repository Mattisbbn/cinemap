<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('location.index', [
            'locations' => Location::with(['film', 'user'])->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('location.create', [
            'films' => Film::all(),
        ]);
    }

    // film name city country desctription
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'film_id' => 'required|exists:films,id',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $payload = $request->all();
        $payload['user_id'] = Auth::id();

        Location::create($payload);

        return redirect()->route('locations.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        $location->load(['film', 'user'])->loadCount('location_votes');

        return view('location.show', [
            'location' => $location,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        return view('location.edit', [
            'location' => $location,
            'films' => Film::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'film_id' => 'required|exists:films,id',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $location->update($request->all());

        return redirect()->route('locations.index')->with('success', 'Localisation modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        $location->delete();

        return redirect()->route('locations.index')->with('success', 'Localisation supprimée avec succès');
    }

    public function upvote(Request $request)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
        ]);

        $location = Location::findOrFail($request->location_id);

        if ($location->location_votes()->where('user_id', Auth::id())->exists()) {
            return redirect()->back()->with('error', 'Vous avez déjà voté pour cette localisation.');
        }

        $location->location_votes()->create([
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Merci pour votre vote !');
    }
}
