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
    public function create(Request $request)
    {
        $user = $request->user();

        // Limites baseados em UNIDADES, não imóveis
        $limit = match($user->plan_tier->value) {
            'free' => 2,
            'basic' => 6, // Exemplo: Básico permite até 10 unidades
            'premium' => PHP_INT_MAX,
            default => 1,
        };

        $limit = match($user->plan_tier->value) {
            'free' => 1,
            'basic' => 3,
            'premium' => PHP_INT_MAX,
            default => 1,
        };

        // Verifica as unidades atuais
        if ($user->units()->count() >= $limit) {
            return redirect()->route('plans.index')->with('error', 'Você atingiu o limite de unidades do seu plano. Faça um upgrade para adicionar mais!');
        }

        if ($user->properties()->count() >= $limit) {
            return redirect()->route('plans.index')->with('error', 'Não foi possível salvar: Limite de imóveis do seu plano atingido. Faça um upgrade para adicionar mais!');
        }


        return view('properties.create');

    }

    /**
     * Store a newly created property in the database.
     */
    public function store(StorePropertyRequest $request)
    {
        $user = $request->user();
        $validated = $request->validated();

        // Re-verify limit securely on the backend
        $limit = match($user->plan_tier->value) {
            'free' => 1,
            'basic' => 3,
            'premium' => PHP_INT_MAX,
            default => 1,
        };

        if ($user->properties()->count() >= $limit) {
            return redirect()->route('plans.index')->with('error', 'Não foi possível salvar: Limite de imóveis do seu plano atingido, Faça um upgrade para adicionar mais!');
        }

        $limit2 = match($user->plan_tier->value) {
            'free' => 2,
            'basic' => 6,
            'premium' => PHP_INT_MAX,
            default => 1,
        };

        // Conta quantas unidades o usuário já tem
        $currentUnits = $user->units()->count();

        // Conta quantas unidades ele está tentando criar agora
        $newUnits = ($validated['is_multi_unit'] === 'no') ? 1 : count($validated['units']);

        // Se a soma ultrapassar o limite, bloqueia a ação
        if (($currentUnits + $newUnits) > $limit2) {
            return redirect()->route('plans.index')->with('error', 'Não foi possível salvar: Limite de imóveis do seu plano atingido, Faça um upgrade para adicionar mais!');
            //return back()->with('error', "Você só tem limite para criar mais " . ($limit2 - $currentUnits) . " unidade(s) no seu plano atual.")->withInput();
        }


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
                         ->with('success', 'Imóvel alterado com sucesso!');
    }

    /**
     * Remove the specified property from storage.
     */
    public function destroy(Property $property)
    {
        $property->delete();

        return redirect()->route('properties.index')
                         ->with('success', 'Imóvel apagado com sucesso!');
    }

    public function show(Property $property)
    {
        // We use 'load' to eagerly fetch the units associated with this property,
        // preventing the N+1 query performance issue.
        $property->load('units');

        return view('properties.show', compact('property'));
    }
}
