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
use App\Enums\ContractStatus;

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
        if ($contract->landlord_id !== auth()->id()) abort(403);

        $contract->load(['tenant', 'unit.property', 'landlord']);
        $templates = \App\Models\ContractTemplate::where('landlord_id', auth()->id())->get();

        $variables = [
            '[LOCADOR_NOME]' => $contract->landlord->name ?? 'N/A',
            '[LOCATARIO_NOME]' => $contract->tenant->name ?? 'N/A',
            '[IMOVEL_ENDERECO]' => $contract->unit->property->address ?? 'N/A',
            '[VALOR_ALUGUEL]' => 'R$ ' . number_format($contract->monthly_rent, 2, ',', '.'),
            '[DATA_INICIO]' => \Carbon\Carbon::parse($contract->start_date)->format('d/m/Y'),
            '[DATA_FIM]' => \Carbon\Carbon::parse($contract->end_date)->format('d/m/Y'),
            '[DIA_VENCIMENTO]' => $contract->due_day,
            '[PAYMENT_METHOD]' => $contract->payment_method ?? 'N/A',
            '[LOCADOR_CPF]' => $contract->landlord->document_number ?? '___.___.___-__',
            '[LOCADOR_RG]' => $contract->landlord->rg ?? '_______',
            '[LOCADOR_NACIONALIDADE]' => $contract->landlord->nationality ?? 'N/A',
            '[LOCADOR_MARITAL_STATUS]' => $contract->landlord->marital_status ?? 'N/A',
            '[LOCADOR_PROFESSION]' => $contract->landlord->profession ?? 'N/A',
            '[LOCADOR_ADRESS]' => $contract->landlord->address ?? 'N/A',
            '[LOCATARIO_CPF]' => $contract->tenant->document_number ?? '___.___.___-__',
            '[LOCATARIO_RG]' => $contract->tenant->rg ?? '_______',
            '[LOCATARIO_NACIONALIDADE]' => $contract->tenant->nationality ?? 'N/A',
            '[LOCATARIO_MARITAL_STATUS]' => $contract->tenant->marital_status ?? 'N/A',
            '[LOCATARIO_PROFESSION]' => $contract->tenant->profession ?? 'N/A',
            '[LOCATARIO_ADRESS]' => $contract->tenant->address ?? 'N/A',
            '[DATE]' => now()->format('d/m/Y'),
        ];

        return view('contracts.document', compact('contract', 'templates', 'variables'));
    }

    public function finalizeDocument(Request $request, Contract $contract)
    {
        if ($contract->landlord_id !== auth()->id()) abort(403);

        // Ensure we only finalize drafts
        if ($contract->status !== ContractStatus::Draft) {
            return redirect()->back()->with('error', 'Este contrato já foi finalizado.');
        }

        $request->validate([
            'document_body' => 'required|string',
        ]);

        // Generate the SHA-256 hash of the exact HTML string
        $hash = hash('sha256', $request->document_body);

        // Update the contract with the frozen document and new status
        $contract->update([
            'document_body' => $request->document_body,
            'document_hash' => $hash,
            'status' => ContractStatus::PendingSignatures,
        ]);

        return redirect()->route('contracts.document', $contract)
            ->with('success', 'Contrato finalizado! Agora ele está pronto para receber as assinaturas digitais.');
    }

    public function signLandlord(Request $request, Contract $contract)
    {
        // 1. Ensure the user owns the contract
        if ($contract->landlord_id !== auth()->id()) abort(403);

        // 2. Ensure it is in the correct status
        if ($contract->status !== ContractStatus::PendingSignatures) {
            return redirect()->back()->with('error', 'O contrato não está aguardando assinaturas.');
        }

        // 3. Ensure they haven't already signed
        if ($contract->landlord_signed_at !== null) {
            return redirect()->back()->with('error', 'Você já assinou este contrato.');
        }

        // 4. Record the signature evidence
        $contract->update([
            'landlord_signed_at' => now(),
            'landlord_sign_ip' => $request->ip(),
        ]);

        // 5. If both parties have signed, activate the contract!
        if ($contract->landlord_signed_at && $contract->tenant_signed_at) {
            $contract->update(['status' => ContractStatus::Active]);
        }

        return redirect()->back()->with('success', 'Sua assinatura digital foi registrada com sucesso!');
    }
}
