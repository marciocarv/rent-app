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
                         ->with('success', 'Contrato Criado e Unidade Marcada como Ocupada!');
    }

    public function terminate(Contract $contract)
    {
        // 1. Ensure the user owns this contract
        if ($contract->landlord_id !== auth()->id()) {
            abort(403, 'Acesso negado.');
        }

        // 2. Update the contract status
        $contract->update([
            'status' => 'terminated',
            'end_date' => now(), // Optionally log exactly when it ended
        ]);

        // 3. Optional but recommended: Delete pending future rent charges
        // This prevents the dashboard from showing "overdue" rent for a finished contract
        $contract->transactions()
            ->where('status', 'pending')
            ->where('due_date', '>', now())
            ->delete();

        // 4. Update the Unit status back to vacant
        if ($contract->unit) {
            $contract->unit->update(['status' => 'vacant']);
        }

        return redirect()->route('contracts.index')->with('success', 'Contrato encerrado com sucesso. A unidade agora está vaga e cobranças futuras foram canceladas.');
    }

    public function document(Contract $contract)
    {
        // 1. Ensure the user owns this contract
        if ($contract->landlord_id !== auth()->id()) {
            abort(403, 'Acesso negado.');
        }

        // 2. Load relationships to get names and addresses
        $contract->load(['tenant', 'unit.property', 'landlord']);

        // 3. Fetch the landlord's saved templates
        $templates = \App\Models\ContractTemplate::where('landlord_id', auth()->id())->get();

        // 4. Map the dynamic variables
        $variables = [
            '[LOCADOR_NOME]' => $contract->landlord->name ?? 'N/A',
            '[LOCATARIO_NOME]' => $contract->tenant->name ?? 'N/A',
            '[IMOVEL_ENDERECO]' => $contract->unit->property->address ?? 'N/A',
            '[VALOR_ALUGUEL]' => 'R$ ' . number_format($contract->monthly_rent, 2, ',', '.'),
            '[DATA_INICIO]' => \Carbon\Carbon::parse($contract->start_date)->format('d/m/Y'),
            '[DATA_FIM]' => \Carbon\Carbon::parse($contract->end_date)->format('d/m/Y'),
            '[DIA_VENCIMENTO]' => $contract->due_day,
        ];

        return view('contracts.document', compact('contract', 'templates', 'variables'));
    }
}
