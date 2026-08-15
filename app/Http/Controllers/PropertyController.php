<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRequest;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Requests\UpdatePropertyRequest;

class PropertyController extends Controller
{
    /**
     * Display a list of the landlord's properties.
     */
    public function index()
    {
        // Thanks to our BelongsToTenant trait, this ONLY fetches the logged-in user's properties!
        $properties = Property::latest()->get();

        return view('properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new property.
     */
    public function create()
    {
        return view('properties.create');
    }

    /**
     * Store a newly created property in the database.
     */
    public function store(StorePropertyRequest $request)
    {
        // The data is already validated by the time it reaches this line.
        // The BelongsToTenant trait will automatically attach the landlord_id!
        Property::create($request->validated());

        return redirect()->route('properties.index')
                         ->with('success', 'Property added successfully!');
    }

    public function edit(Property $property)
    {
        return view('properties.edit', compact('property'));
    }

    /**
     * Update the specified property in storage.
     */
    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $property->update($request->validated());

        return redirect()->route('properties.index')
                         ->with('success', 'Property updated successfully!');
    }

    /**
     * Remove the specified property from storage.
     */
    public function destroy(Property $property)
    {
        $property->delete();

        return redirect()->route('properties.index')
                         ->with('success', 'Property deleted successfully!');
    }
}
