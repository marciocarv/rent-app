<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRequest;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Requests\UpdatePropertyRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Unit;

class PropertyController extends Controller
{
    /**
     * Display a list of the landlord's properties.
     */
    public function index()
    {
        // withCount('units') automatically adds a 'units_count' attribute to each property
        $properties = Property::withCount('units')->latest()->get();

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
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            // 1. Cria o Imóvel com as 3 opções do Enum
            $property = Property::create([
                'name' => $validated['name'],
                'address' => $validated['address'],
                'type' => $validated['type'], // Salva o tipo real (ex: residencial, comercial)
                'landlord_id' => auth()->id(),
            ]);

            // 2. Cria as Unidades com os novos campos
            if ($validated['is_multi_unit'] === 'no') {
                // Imóvel Único (Cria 1 unidade principal)
                $property->units()->create([
                    'name' => 'Unidade Principal',
                    'bedrooms' => $validated['bedrooms'] ?? 0,
                    'bathrooms' => $validated['bathrooms'] ?? 0,
                    'status' => $validated['status'] ?? 'vacant',
                    'landlord_id' => auth()->id(),
                ]);
            } else {
                // Múltiplas Unidades (Cria as unidades do array dinâmico)
                foreach ($validated['units'] as $unitData) {
                    $property->units()->create([
                        'name' => $unitData['name'],
                        'bedrooms' => $unitData['bedrooms'] ?? 0,
                        'bathrooms' => $unitData['bathrooms'] ?? 0,
                        'status' => $unitData['status'] ?? 'vacant',
                        'landlord_id' => auth()->id(),
                    ]);
                }
            }
        });

        return redirect()->route('properties.index')
                         ->with('success', 'Imóvel e unidades cadastrados com sucesso!');
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

    public function show(Property $property)
    {
        // We use 'load' to eagerly fetch the units associated with this property,
        // preventing the N+1 query performance issue.
        $property->load('units');

        return view('properties.show', compact('property'));
    }
}
