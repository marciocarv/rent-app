<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUnitRequest;
use App\Models\Property;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        // Eager load the property to prevent N+1 query performance issues
        $units = Unit::with('property')->latest()->get();
        return view('units.index', compact('units'));
    }

    public function create()
    {
        // Fetch all properties so the landlord can select which one this unit belongs to.
        // Thanks to our BelongsToTenant trait, this only fetches THEIR properties!
        $properties = Property::all();

        return view('units.create', compact('properties'));
    }

    public function store(StoreUnitRequest $request)
    {
        Unit::create($request->validated());

        return redirect()->route('units.index')
                         ->with('success', 'Unidade cadastrada com sucesso!');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('units.index')
                         ->with('success', 'Unidade excluída com sucesso!');
    }
}
