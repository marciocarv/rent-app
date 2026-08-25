<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Enums\ContractStatus;
use Illuminate\Http\Request;

class TenantContractController extends Controller
{
    public function show(Contract $contract)
    {
        // Ensure the logged-in user is the actual tenant for this contract
        if ($contract->tenant_id !== auth()->id()) {
            abort(403, 'Acesso negado.');
        }

        return view('tenants.contracts.show', compact('contract'));
    }

    public function sign(Request $request, Contract $contract)
    {
        // Security checks
        if ($contract->tenant_id !== auth()->id()) abort(403);

        if ($contract->status !== ContractStatus::PendingSignatures) {
            return redirect()->back()->with('error', 'Este contrato não está aguardando assinaturas.');
        }

        if ($contract->tenant_signed_at !== null) {
            return redirect()->back()->with('error', 'Você já assinou este contrato.');
        }

        // Record the tenant's signature evidence
        $contract->update([
            'tenant_signed_at' => now(),
            'tenant_sign_ip' => $request->ip(),
        ]);

        // If both parties have signed, activate the contract automatically!
        if ($contract->landlord_signed_at && $contract->tenant_signed_at) {
            $contract->update(['status' => ContractStatus::Active]);
        }

        return redirect()->back()->with('success', 'Sua assinatura digital foi registrada com sucesso!');
    }
}
