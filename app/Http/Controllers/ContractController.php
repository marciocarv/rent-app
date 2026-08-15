<?php

namespace App\Http\Controllers;

use App\Enums\UnitStatus;
use App\Enums\UserRole;
use App\Http\Requests\StoreContractRequest;
use App\Models\Contract;
use App\Models\Unit;
use App\Models\User;
use App\Services\CreateContractService;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Display a listing of the contracts.
     */
    public function index()
    {
        // Fetch contracts with their related units and tenants to avoid N+1 query problems
        $contracts = Contract::with(['unit', 'tenant'])->latest()->get();

        return view('contracts.index', compact('contracts'));
    }

    /**
     * Show the form for creating a new contract.
     */
    public function create()
    {
        // We only want to show units that are actually vacant!
        $units = Unit::where('status', UnitStatus::Vacant)->get();

        // We only want to show users who are registered as tenants
        $tenants = User::where('role', UserRole::Tenant)
                       ->where('landlord_id', auth()->id())
                       ->get();

        return view('contracts.create', compact('units', 'tenants'));
    }

    /**
     * Store a newly created contract in storage using our Service Class.
     */
    public function store(StoreContractRequest $request, CreateContractService $createContractService)
    {
        // 1. Data is validated by the Form Request
        $validatedData = $request->validated();

        // 2. We pass the data to our Service class to handle the complex DB logic
        $createContractService->execute($validatedData);

        // 3. We return a simple redirect!
        return redirect()->route('contracts.index')
                         ->with('success', 'Contract created and unit marked as occupied!');
    }
}
